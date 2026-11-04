<?php
include('lock.php');
include('config.php');

ob_implicit_flush(true);
set_time_limit(60); 
$group=$_REQUEST['group'] ; 
$type2=$_REQUEST['type2'] ;
$duration=$_REQUEST['duration'] ;

$STARTtime = date("U");

//get table contents
$sql = "update filter set type='$type2',duration='$duration' where name='$group'";
$rsd = mysql_query($sql);
echo 'Filter Updated Successfully';
?>


