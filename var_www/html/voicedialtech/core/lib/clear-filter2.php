<?php
include('lock.php');
include('config.php');

$STARTtime = date("U");

//get table contents
$sql = "delete from topgear where useragent='group2'";
$rsd = mysql_query($sql);
echo "Filter data has been successfully Cleaned";

?>


