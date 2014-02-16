<?php include_once("checkInput.php"); ?>
<?
//Get all the comments for that article
//VulBegin: SQL Injection
/*Original Code:
$result = mysqli_query($con,"SELECT comments.id as cid,comment,user_name,time FROM comments,users WHERE comments.user_id=users.id AND comments.article_id='$articleid'");
*/
//Patch Code:
$con_corrupt = conC();
$con = conN();
$result = mysqli_query($con_corrupt,"SELECT comments.id as cid,comment,user_name,time FROM comments,users WHERE comments.user_id=users.id AND comments.article_id='$articleid'");
$stmt = $con->prepare("SELECT comments.id as cid,comment,user_name,time FROM comments,users WHERE comments.user_id=users.id AND comments.article_id='?'");
$stmt->bind_param('s',  $articleid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
//Display the comments
//VulBegin: XSS
/*Original Code:
while($row = mysqli_fetch_array($result)){
	echo $row['user_name'] . " said:<br/>" . nl2br($row['comment']);
	//If an admin is logged in, give them the option to delete it
	if($_SESSION['is_admin'] == 1){
	echo "<a href='index.php?page=delete_comment&comment_id=" . $row['cid'] . "'>Delete</a>";	
	}
	echo "<br/><br/>";
}	
*/
//Patch Code:
while($row = mysqli_fetch_array($result)){
	echo checkXSS($row['user_name']) . " said:<br/>" . checkXSS(nl2br($row['comment']));
	//If an admin is logged in, give them the option to delete it
	if($_SESSION['is_admin'] == 1){
	echo "<a href='index.php?page=delete_comment&comment_id=" . checkXSS($row['cid']) . "'>Delete</a>";	
	}
	echo "<br/><br/>";
}	
//VulEnd
?>
