<? include "header.php" ?>
    <?
//Display the welcome message
if($_GET['page'] == NULL){
echo nl2br($welcome);
}
else{
//Get the page they requested and include it
$page = $_GET['page'] . ".php";
include($page);	
}
?>
    <? include "footer.php" ?>
