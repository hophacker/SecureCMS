<?
//What article to show?
$articleid = $_GET['article_id'];
$result = mysqli_query($con,"SELECT * FROM article,users WHERE article.author_id=users.id AND article.id='$articleid'");
//Show the result from the sql query
while($row = mysqli_fetch_array($result)){
	echo "<b>" . $row['title'] . "</b> by " . $row['user_name'] . "<br/><br/>";
	echo nl2br($row['content']);
	echo "<br/><br/>";
	if($_SESSION['is_admin'] == 1){
		echo "<a href='index.php?page=edit_article&article_id=" . $articleid . "'>Edit</a> ";	
		echo "<a href='index.php?page=delete_article&article_id=" . $articleid . "'>Delete</a>";	

	}
}	
echo "<br/>";
//Get the comments
include ("view_comments.php");
//Is a user logged in and therefore allowed to comment?
if(isset($_SESSION['username'])){
	echo "<br/>Add comment:<br/>";
	$include = "add_comment.php";
 include ($include);	
}
else {
	//Not logged in, can't comment
 echo "Please login to comment.";	
}



?>