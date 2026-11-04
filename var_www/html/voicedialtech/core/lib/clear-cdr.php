<?php
include('lock.php');
include('config.php');

$STARTtime = date("U");

//get table contents
/$sql = "TRUNCATE table cdrtable";
//$rsd = mysql_query($sql);
echo "CDR data has been successfully Cleaned";

?>


