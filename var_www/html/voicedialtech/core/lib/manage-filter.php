<?php
//include('lock.php');
include('config.php');

$STARTtime = date("U");

//get table contents
$sql = "select * from filter  order by id";
$rsd = mysql_query($sql);

echo "<table class='table table-striped'>
				<th>ID</th>
				<th>GROUPNAME</th>
				<th>FILTER TYPE</th>
				<th>DURATION(MINS)</th>

</tr>";

while($row = mysql_fetch_array($rsd))
  {
  	echo "<tr>";
  	echo "<td>" . $row[0] . "</td>";
  	echo "<td>" . $row[1] . "</td>";
  	echo "<td>" . $row[2] . "</td>";
  	echo "<td>" . $row[3] . "</td>";
  	echo "</tr>";
}
echo "</table>";
?>


