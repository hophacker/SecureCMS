<?php include_once("checkInput.php"); ?>
<?
session_start();
include ("functions.php");
//Change this to your DB settings
//mysqli_select_db($db, $con);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="styles.css"/>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
$con = conN();
//Get the page titles and welcome page
$result = mysqli_query($con,"SELECT * FROM settings");
$site_name = "";
$welcome = "";
while($row = mysqli_fetch_array($result)){
    $site_name =  $row['site_name'];
    $welcome = $row['welcome'];
}
?>
<title><? echo $site_name; ?></title>
<div class="header"><? echo $site_name; ?></div>
</head>
<body>
<div class="bigcontainer">
<div class="sidebar">
  <? include "login.php" ?>
  <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="index.php?page=articles">Articles</a></li>
    <li><a href="index.php?page=search">Search</a></li>
  </ul>
<?
//If it is an admin, show admin options
if($_SESSION['is_admin'] == 1){
?>
  <b>Admin Resources</b>
  <ul>
    <li><a href="index.php?page=view_users">View Users</a></li>
    <li><a href="index.php?page=add_article">Add Article</a></li>
    <li><a href="index.php?page=edit_settings">Settings</a></li>
  </ul>
<?

}
?>
</div>
<div class="container">
