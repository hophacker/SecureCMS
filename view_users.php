<?
//Verify that an admin is logged in
verifyAdmin();
$result = mysqli_query($con,"SELECT * FROM users");

?>

<table border="1">
  <tr>
    <td><b>ID</b></td>
    <td><b>Username</b></td>
    <td><b>Email</b></td>
  </tr>
  <?
//Show all users
while($row = mysqli_fetch_array($result)){
	echo "<tr><td>" . $row['id'] . "</td><td>" . $row['user_name'] . "</td><td>" . $row['email'] . "</td></tr>";
}	
?>
</table>
