<?php include_once("checkInput.php"); ?>
<?
//Make sure it is an admin editing
verifyAdmin();
//Get their updates
if(isset($_POST['title'])){
    $title = addslashes($_POST['title']);
    $content = addslashes($_POST['content']);
    $articleid = $_GET['article_id'];
    //Update in database
    //VulBegin: SQL Injection
    /*Original Code:
    $query = "UPDATE article SET title='$title',content='$content' WHERE id='$articleid'"; 
    if (!mysqli_query($con,$query))
    {
        die('Error: ' . mysqli_error($con));
    }
     */
    //Patch Code:
    $con_corrupt = conC();
    $con = conN();
    $query = "UPDATE article SET title='$title',content='$content' WHERE id='$articleid'"; 
    if (!mysqli_query($con_corrupt,$query))
    {
        die('Error: ' . mysqli_error($con_corrupt));
    }

    $stmt = $con->prepare( "UPDATE article SET title=?,content=? WHERE id=?");
    $stmt->bind_param('sss', $title, $content, $articleid);
    if ($stmt->execute() != 1) 
    {
        die('Error: ' . mysqli_error($con));
    }
    //VulEnd
    echo "Updated";
}
else{
    //Display the current article
    $articleid = $_GET['article_id'];
    $title = "";
    $content = "";
    $result = mysqli_query($con,"SELECT * FROM article,users WHERE article.author_id=users.id AND article.id='$articleid'");
    //Put the current article in the form
    while($row = mysqli_fetch_array($result)){
        $title = $row['title'];
        $content =  $row['content'];
    }	
    //VulBegin: 
    //Patch Code: Cross Site Scripting (XSS)
    $title = htmlspecialchars($title, ENT_QUOTES);
    $content = htmlspecialchars($content, ENT_QUOTES);
    //logBegin
    $title = checkXSS($title);
    $content = checkXSS($content);
    //logEnd
    //VulEnd
?>
     <form action="#" method="post">
    Title: <input type="text" name="title" value="<? echo $title; ?>"/><br/>
    <textarea rows="23" cols="75" name="content"><? echo nl2br($content); ?></textarea><br/>
    <input type="submit" value="Post"/>
  </form>
<?   
}
?>
