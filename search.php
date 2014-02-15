<form action="#" method="POST">
  Search Term:
  <input type="text" name="term" />
  <input type="submit" value="Search"/>
</form>
<?
//Get the search term
if(isset($_POST['term'])){
	$term = $_POST['term'];
	$result = mysqli_query($con,"SELECT title,user_name,article.id as aid FROM article,users WHERE title LIKE '%$term%' AND article.author_id=users.id");
//Display articles with matching titles
while($row = mysqli_fetch_array($result)){
	echo "<b><a href='index.php?page=view_article&article_id=" . $row['aid'] . "'>" . $row['title'] . "</a></b> by " . $row['user_name']. "<br/><br/>";
}	
}
?>
