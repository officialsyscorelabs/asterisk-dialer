<?php
include("config.php");
ob_implicit_flush(true);
set_time_limit(30); 
$NOW_DATE = date("Y-m-d");
$NOW_TIME = date("Y-m-d H:i:s"); 
$NOW_TIME2 = date("H:i:s");
$STARTtime = date("U");
$sql = "UPDATE sessions_cnm  set flag='N' where (UNIX_TIMESTAMP(now())-end_epoch) > 60 and flag='Y';";
$rsd = mysql_query($sql);
?>

