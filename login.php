<?
//Did they login?
if(isset($_POST['username'])){
	$username = $_POST['username'];
	$password = sha1($_POST['pass']);
	//Get any users with that username and password
	$q = "SELECT * FROM users WHERE user_name='$username' AND password='$password'";
	$result = mysqli_query($con,$q);
if($result == NULL){
	//No results found! Must be wrong user
	echo "Error: Wrong username/password.";	
}
	//Start a session for the logged in user
	while($row = mysqli_fetch_array($result)){
		$_SESSION['username'] = $row['user_name'];
		$_SESSION['user_id'] = $row['id'];
		$_SESSION['is_admin'] = $row['is_admin'];
	}	
}


if(isset($_SESSION['username'])){
	//Welcome them to the site!
	echo "Welcome, " . $_SESSION['username'];	
	echo "<br/><a href='index.php?page=logout'>Logout</a>";
}
else {
	//Display the login form if they aren't logged in
	?>

No account? <a href="index.php?page=register">Register</a>
<form action="" method="POST">
  Username: <br/>
  <input type="text" name="username"/>
  <br/>
  Password: <br/>
  <input type="password" name="pass"/>
  <br/>
  <input type="submit" value="Login"/>
</form>
<?
}
?>
