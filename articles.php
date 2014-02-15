<?
//Get all the articles
$result = mysqli_query($con,"SELECT title,user_name,article.id as aid FROM article,users WHERE article.author_id=users.id");
//Display them
while($row = mysqli_fetch_array($result)){
	echo "<b><a href='index.php?page=view_article&article_id=" . $row['aid'] . "'>" . $row['title'] . "</a></b> by " . $row['user_name'] . "<br/><br/>";
}	

?>