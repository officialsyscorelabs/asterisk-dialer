<?php
include('alock.php');
include('config.php');
$id=$_REQUEST['id'] ;

$sql = "update sipusers set active='active',status='free' where id='$id'";
$rsd = mysql_query($sql);
echo "Resume Successful"; 
?>