<?php include_once("checkInput.php"); ?>
<?
Verif that an admin is logged in
verifyAdmin();
//Get the article to delete
$articleid = $_GET['article_id'];
//logBegin
checkSQLInput($article_id);
//logEnd

//VulBegin: SQL Injection
/*Original Code:
 mysqli_query($con,"DELETE FROM article WHERE id='$articleid'");
 */
//Patch Code:
$con_corrupt = conC();
$con = conN();
mysqli_query($con_corrupt, "DELETE FROM article WHERE id='$articleid'");

$stmt = $con->prepare("DELETE FROM article WHERE id=?");
$stmt->bind_param('s', $articleid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
echo "Deleted";
?>
