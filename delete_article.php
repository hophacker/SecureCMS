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
$stmt = $con->prepare("DELETE FROM article WHERE id=?");
$stmt->bind_param('s', $articleid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
echo "Deleted";
?>
