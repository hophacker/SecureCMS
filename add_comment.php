<?php include_once("checkInput.php"); ?>
<for action="#" method="post">
  <textarea rows="5" cols="50" name="comment"></textarea>
  <br/>
  <input type="submit" value="Comment"/>
</form>
<?
//Did they post a comment?
if(isset($_POST['comment'])){
    $comment = $_POST['comment'];
    $authorid = $_SESSION['user_id'];

    //Insert it into the database

    //VulBegin: SQL Injection
    /*Original Code:
  $query = "INSERT INTO comments (user_id,article_id,comment) VALUES ('$authorid','$articleid','$comment')"; 
echo $query;

    if (!mysqli_query($con,$query))
  {
  die('Error: ' . mysqli_error($con));
  }
     */
    //Patch Code:
    $query = "INSERT INTO comments (user_id,article_id,comment) VALUES ('$authorid','$articleid','$comment')"; 
    if (!mysqli_query($con,$query))
    {
        die('Error: ' . mysqli_error($con));
    }

    mysqli_select_db("SecureCMS", $con);
    $stmt = $con->prepare("INSERT INTO comments (user_id,article_id,comment) VALUES (?,?,?)");
    $stmt->bind_param('sss', $authorid, $articleid, $comment);
    if ($stmt->execute() != 1) 
    {
        die('Error: ' . mysqli_error($con));
    }
    //VulEnd



    echo "Comment added.";
}

?>
