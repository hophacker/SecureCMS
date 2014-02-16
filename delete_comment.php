<?php include_once("checkInput.php"); ?>
<?
//Make sure the admin is logged in
verifyAdmin();
//Get and delete the comment
$commentid = $_GET['comment_id'];
//logBegin
checkSQLInput($comment_id);
//logEnd
//VulBegin: SQL Injection
/*Original Code:
 mysqli_query($con,"DELETE FROM comments WHERE id='$commentid'");
 */
//Patch Code:
$con_corrupt = conC();
$con = conN();
 mysqli_query($con_corrupt, "DELETE FROM comments WHERE id='$commentid'");
$stmt = $con->prepare("DELETE FROM comments WHERE id=?");
$stmt->bind_param('s', $commentid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
echo "Deleted";
?>
