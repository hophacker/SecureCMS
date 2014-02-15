<?php 
include("checkInput.php");
?>
<form action="#" method="POST">
  Username: <br/>
  <input type="text" name="username"/>
  <br/>
  Email: <br/>
  <input type="text" name="email"/>
  <br/>
  Password: <br/>
  <input type="password" name="password"/>
  <br/>
  Confirm Password: <br/>
  <input type="password" name="confirm"/>
  <br/>
  <input type="submit" value="Register"/>
</form>
<?
//Get the details they provided
	if(isset($_POST)){
	$username = $_POST['username'];
	$email = $_POST['email'];
	$confirm = $_POST['confirm'];
	$password = $_POST['password'];
    //logBegin
    checkSQLInput($username);
    checkSQLInput($email);
    checkSQLInput($password);
    //logEnd
	//Verify they typed the same password twice
	if($password != $confirm){
		echo "Error: Your passwords do not match.";
	}
	else {
		//Add the account

		$password = sha1($password);
        //VulBegin: SQL Injection
        /*Original Code:
		$query = "INSERT INTO users (user_name,email,password,is_admin) VALUES ('$username','$email','$password',false)"; 
		if (!mysqli_query($con,$query))
  		{
  			die('Error: ' . mysqli_error($con));
        }
         */
        //Patch Code:
		$stmt = $con->prepare("INSERT INTO users (user_name,email,password,is_admin) VALUES (?,?,?,false)"); 
        $stmt->bind_param('sss', $username, $email, $password);
		if ($stmt->execute() != 1)
  		{
  			die('Error: ' . mysqli_error($con));
        }
        //VulEnd
		echo "User created. You may not log in.";	
	}
	
}
else{
	echo "Error: You left something blank, please make sure you completed the form in full.";	
}

