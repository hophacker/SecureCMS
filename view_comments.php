<?
//Get all the comments for that article
$result = mysqli_query($con,"SELECT comments.id as cid,comment,user_name,time FROM comments,users WHERE comments.user_id=users.id AND comments.article_id='$articleid'");
//Display the comments
while($row = mysqli_fetch_array($result)){
	echo $row['user_name'] . " said:<br/>" . nl2br($row['comment']);
	//If an admin is logged in, give them the option to delete it
	if($_SESSION['is_admin'] == 1){
	echo "<a href='index.php?page=delete_comment&comment_id=" . $row['cid'] . "'>Delete</a>";	
	}
	echo "<br/><br/>";
}	

?>