<?php include_once("checkInput.php"); ?>
<?
//Make sure its an admin adding the article
verifyAdmin();
//Did they submit something?
if(isset($_POST['title'])){
    //Get the title, content and author
    $title = addslashes($_POST['title']);
    $content = addslashes($_POST['content']);
    $authorid = $_SESSION['user_id'];
    //Insert into database 
    //VulBegin: SQL Injection
    /*Original Code:
    $query = "INSERT INTO article (title,content,author_id) VALUES ('$title','$content','$authorid')"; 
    if (!mysqli_query($con,$query))
    {
        die('Error: ' . mysqli_error($con));
    }
    */
    //Patch Code:
    $stmt = $con->prepare("INSERT INTO article (title,content,author_id) VALUES (?,?,?)");
    $stmt->bind_param('sss', $title, $content, $author_id);
    if ($stmt->execute() != 1) 
    {
        die('Error: ' . mysqli_error($con));
    }
    //VulEnd
    echo "Posted article!";
}
else{
    //Display the form
?>

<form action="#" method="post">
  Title:
  <input type="text" name="title"/>
  <br/>
  <textarea rows="23" cols="75" name="content"></textarea>
  <br/>
  <input type="submit" value="Post"/>
</form>
<?   
}
?>
