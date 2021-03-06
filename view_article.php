<?php include_once("checkInput.php"); ?>
<?
//What article to show?
$articleid = $_GET['article_id'];

//VulBegin: SQL Injection
/*Original Code:
$result = mysqli_query($con,"SELECT * FROM article,users WHERE article.author_id=users.id AND article.id='$articleid'");
*/
//Patch Code:
$con_corrupt = conC();
$con = conN();
$result = mysqli_query($con_corrupt,"SELECT * FROM article,users WHERE article.author_id=users.id AND article.id='$articleid'");

$stmt = $con->prepare("SELECT * FROM article,users WHERE article.author_id=users.id AND article.id='?'");
$stmt->bind_param('s', $articleid);
if ($stmt->execute() != 1) 
{
    die('Error: ' . mysqli_error($con));
}
//VulEnd
//Show the result from the sql query


//VulBegin: XSS Injection
/*Original Code:
while($row = mysqli_fetch_array($result)){
	echo "<b>" . $row['title'] . "</b> by " . $row['user_name'] . "<br/><br/>";
	echo nl2br($row['content']);
	echo "<br/><br/>";
	if($_SESSION['is_admin'] == 1){
		echo "<a href='index.php?page=edit_article&article_id=" . $articleid . "'>Edit</a> ";	
		echo "<a href='index.php?page=delete_article&article_id=" . $articleid . "'>Delete</a>";	

	}
}	
*/
//Patch Code:
while($row = mysqli_fetch_array($result)){
	echo "<b>" . checkXSS($row['title']) . "</b> by " . checkXSS($row['user_name']) . "<br/><br/>";
	echo nl2br(checkXSS($row['content']));
	echo "<br/><br/>";
	if($_SESSION['is_admin'] == 1){
		echo "<a href='index.php?page=edit_article&article_id=" . checkXSS($articleid) . "'>Edit</a> ";	
		echo "<a href='index.php?page=delete_article&article_id=" . checkXSS($articleid) . "'>Delete</a>";	
	}
}	
//VulEnd

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
