<?php include_once("checkInput.php"); ?>
<form action="#" method="POST">
  Search Term:
  <input type="text" name="term" />
  <input type="submit" value="Search"/>
</form>
<?
//Get the search term
if(isset($_POST['term'])){
	$term = $_POST['term'];
    //VulBegin: SQL Injection
    /*Original Code:
	$result = mysqli_query($con,"SELECT title,user_name,article.id as aid FROM article,users WHERE title LIKE '%$term%' AND article.author_id=users.id");
    */
    //Patch Code:
    $con_corrupt = conC();
    $con = conN();
	$result = mysqli_query($con_corrupt,"SELECT title,user_name,article.id as aid FROM article,users WHERE title LIKE '%$term%' AND article.author_id=users.id");
    $stmt = $con->prepare("SELECT title,user_name,article.id as aid FROM article,users WHERE title LIKE '%?%' AND article.author_id=users.id");
    $stmt->bind_param('s', $term);
    if ($stmt->execute() != 1) 
    {
        die('Error: ' . mysqli_error($con));
    }
    //VulEnd


//Display articles with matching titles
while($row = mysqli_fetch_array($result)){

  //VulBegin: SQL Injection
    /*Original Code:
	echo "<b><a href='index.php?page=view_article&article_id=" . $row['aid'] . "'>" . $row['title'] . "</a></b> by " . $row['user_name']. "<br/><br/>";
    */
    //Patch Code:
	echo "<b><a href='index.php?page=view_article&article_id=" . checkXSS($row['aid']) . "'>" . checkXSS($row['title']) . "</a></b> by " . checkXSS($row['user_name']). "<br/><br/>";
    //VulEnd
}	
}
?>
