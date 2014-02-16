<?php include_once("checkInput.php"); ?>
<?
//Did they login?
if(isset($_POST['username'])){
    $username = $_POST['username'];
    $password = sha1($_POST['pass']);
    //Get any users with that username and password

    //VulBegin: SQL Injection
    /*Original Code:
    $q = "SELECT * FROM users WHERE user_name='$username' AND password='$password'";
    $result = mysqli_query($con,$q);
    if($result == NULL){
        //No results found! Must be wrong user
        echo "Error: Wrong username/password.";	
    }
    */
    //Patch Code:
    $con_corrupt = conC();
    $q = "SELECT * FROM users WHERE user_name='$username' AND password='$password'";
    $result = mysqli_query($con_corrupt ,$q);
    if($result == NULL){
        //No results found! Must be wrong user
        echo "Error: Wrong username/password.";	
    }

    $con = conN();
    $stmt = $con->prepare("SELECT * FROM users WHERE user_name=? AND password=?");
    $stmt->bind_param('ss', $username, $password);
    if ($stmt->execute() != 1) 
    {
        die('Error: ' . mysqli_error($con));
    }
    //VulEnd
    //Start a session for the logged in user
    while($row = mysqli_fetch_array($result)){
        $_SESSION['username'] = $row['user_name'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['is_admin'] = $row['is_admin'];
        $_SESSION['database'] = $row['database'];
    }	
}


if(isset($_SESSION['username'])){
    //Welcome them to the site!

    //VulBegin: XSS
    /*Original Code:
    echo "Welcome, " . $_SESSION['username'];	
    */
    //Patch Code:
    echo "Welcome, " . checkXSS($_SESSION['username']);	
    //VulEnd
   
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
