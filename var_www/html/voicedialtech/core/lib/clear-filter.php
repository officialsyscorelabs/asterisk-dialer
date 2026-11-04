<?php
include('lock.php');
include('config.php');

$STARTtime = date("U");

//get table contents
$sql = "TRUNCATE table topgear";
$rsd = mysql_query($sql);
echo "Filter data has been successfully Cleaned";

?>


