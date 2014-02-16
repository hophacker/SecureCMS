<?php include_once("checkInput.php"); ?>
<?
//Verifies that the logged in user is an admin
function verifyAdmin(){
	//Check that the current session is for an administrator, if not, don't load the rest of the page
	if($_SESSION['is_admin'] == NULL || $_SESSION['is_admin'] == 0){
		die("You must be logged in as an administrator to see this page.");	
	}
}
?>
