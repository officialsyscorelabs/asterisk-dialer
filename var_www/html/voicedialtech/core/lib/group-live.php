<?php
//include('lock.php');
include('config.php');

$STARTtime = date("U");

//get table contents
$sql = "select groups, count(active),count(status),status from sipusers where groups='group1'  group by status union 
        select groups, count(active),count(status),status from sipusers where groups='group2'  group by status union
        select groups, count(active),count(status),status from sipusers where groups='group3'  group by status union
        select groups, count(active),count(status),status from sipusers where groups='group4'  group by status union
        select groups, count(active),count(status),status from sipusers where groups='group5'  group by status union
        select groups, count(active),count(status),status from sipusers where groups='group6'  group by status";

$rsd = mysql_query($sql);

echo "<table class='table font-weight-bold'>
				<th>Group</th>
				<th>Active Count</th>
				<th>Status</th>
</tr>";

while($row = mysql_fetch_array($rsd))
  {
        if($row[3] ==""){$row[3] = "Inactive";} 
 	echo "<tr>";
  	echo "<td>" . $row[0] . "</td>";
  	echo "<td>" . $row[2] . "</td>";
  	echo "<td>" . $row[3] . "</td>";
  	echo "</tr>";
  }

echo "</table>";
?>


