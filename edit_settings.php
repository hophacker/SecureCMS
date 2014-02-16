<?php include_once("checkInput.php"); ?>
<?
//Verify that the admin is editing the settings
verifyAdmin();
//Get the name of the site
if(isset($_POST['name'])){
    $name = addslashes($_POST['name']);
    $welcome = addslashes($_POST['welcome']);
    //logBegin
    $name = checkXSS($name);
    $welcome = checkXSS($welcome);
    //logEnd
    //Delete current settings
    $query = "DELETE * FROM settings"; 
    mysqli_query($con,$query);
    //Change the settings in the database
    //VulBegin: SQL Injection
    /*Original Code:
    $query = "INSERT INTO settings (site_name,welcome) VALUES ('$name','$welcome')";
    mysqli_query($con,$query);
    */
    //Patch Code:
    $con_corrupt = conC();
    $con = conN();
    $query = "INSERT INTO settings (site_name,welcome) VALUES ('$name','$welcome')";
    mysqli_query($con_corrupt,$query);
    $stmt = $con->prepare( "INSERT INTO settings (site_name,welcome) VALUES (?,?)");
    $stmt->bind_param('ss', $name, $welcome);
    if ($stmt->execute() != 1) 
    {
        die('Error: ' . mysqli_error($con));
    }
    //VulEnd
    echo "Updated.";
}
else{
    //Display the current settings  
    $result = mysqli_query($con,"SELECT * FROM settings");

    while($row = mysqli_fetch_array($result)){
        $name = $row['site_name'];
        $welcome =  $row['welcome'];
    }	
    //logBegin
    checkHTMLInput($name);
    checkHTMLInput($welcome);
    //logEnd
//VulBegin: 
//Patch Code: Cross Site Scripting (XSS)
    $name = htmlspecialchars($name, ENT_QUOTES);
    $welcome = htmlspecialchars($welcome, ENT_QUOTES);
//VulEnd
?>

<form action="#" method="post">
  Site name:
  <input type="text" name="name" value="<? echo $name; ?>"/>
  <br/>
  Welcome page:<br/>
  <textarea rows="23" cols="75" name="welcome"><? echo nl2br($welcome); ?></textarea>
  <br/>
  <input type="submit" value="Update"/>
</form>
<?   
}
?>
