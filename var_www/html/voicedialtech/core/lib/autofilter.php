<?php
include('alock.php');
include('config.php');

$id=$_REQUEST['listid'] ;
$cleartimedb=$_REQUEST['cleardata'];
$sql = "update filter_timer set cleartime='$cleartimedb' where id='$id'";
$rsd = mysql_query($sql);
echo "Updated Successfully";
 
?>