<?php
//include('lock.php');
include('config.php');

$STARTtime = date("U");

//get table contents
$sql = "SELECT * FROM filter_timer;";
$rsd = mysql_query($sql);


while($row = mysql_fetch_array($rsd))
  {
   //$sql = "select count(*) from topgear where mydate > DATE_SUB(NOW(), INTERVAL $row[2] MINUTE) and useragent='$row[1]';";
   $sql1 = "delete from topgear where mydate < DATE_SUB(NOW(), INTERVAL $row[2] MINUTE) and useragent='$row[1]';";

   $rsd1 = mysql_query($sql1);
   echo $row[1];
  }
?>


