<?php
include('alock.php');
include('config.php');
$id=$_REQUEST['id'] ;

$sql = "update sipusers set active='inactive',status='paused' where id='$id'";
$rsd = mysql_query($sql);
echo "Paused Successfully";
 
?>