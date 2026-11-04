<?php
include('lock.php');
include('config.php');

$STARTtime = date("U");

//get table contents
$sql = "select * from sipusers  order by username";
$rsd = mysql_query($sql);

echo "<table class='table font-weight-bold'>
				<th>ID</th>
				<th>USERNAME</th>
				<th>ACTIVITY</th>
				<th>DURATION</th>
				<th>CURRENTSTATUS</th>
				<th>LASTNUMBER</th>
				<th>GROUP</th>
				<th>ACTION PAUSE</th>
				<th>ACTION RESUME</th>


</tr>";

while($row = mysql_fetch_array($rsd))
  {
if($row[6] =="busy"){
$jimmy=$STARTtime-$row[5];
}
else{
$jimmy=0;
}
  $pause="<a  href='lib/agent-pause.php?id=$row[0]' target='_blank' name='pause'>PAUSE</a>";
  $resume="<a href='lib/agent-resume.php?id=$row[0]' target='_blank' name='resume'>RESUME</a>";
  if ($jimmy < 10){ 
  	echo "<tr>";
  	echo "<td>" . $row[0] . "</td>";
  	echo "<td>" . $row[1] . "</td>";
  	echo "<td>" . $row[3] . "</td>";
  	echo "<td>" . $jimmy . "</td>";
  	echo "<td>" . $row[6] . "</td>";
  	echo "<td>" . $row[10] . "</td>";
  	echo "<td>" . $row[11] . "</td>";
  	echo "<td>" . $pause . "</td>";
  	echo "<td>" . $resume . "</td>";
  	echo "</tr>";
  }
  elseif(($jimmy > 11)&&($jimmy < 179)){ 
  	echo "<tr class='table-danger'>";
  	echo "<td>" . $row[0] . "</td>";
  	echo "<td>" . $row[1] . "</td>";
  	echo "<td>" . $row[3] . "</td>";
  	echo "<td>" . $jimmy . "</td>";
  	echo "<td>" . $row[6] . "</td>";
  	echo "<td>" . $row[10] . "</td>";
  	echo "<td>" . $row[11] . "</td>";
  	echo "<td>" . $pause . "</td>";
  	echo "<td>" . $resume . "</td>";
  	echo "</tr>";
  } 
  elseif(($jimmy > 180)&&($jimmy < 900)){ 
  	echo "<tr class='table-success'>";
  	echo "<td>" . $row[0] . "</td>";
  	echo "<td>" . $row[1] . "</td>";
  	echo "<td>" . $row[3] . "</td>";
  	echo "<td>" . $jimmy . "</td>";
  	echo "<td>" . $row[6] . "</td>";
  	echo "<td>" . $row[10] . "</td>";
  	echo "<td>" . $row[11] . "</td>";
  	echo "<td>" . $pause . "</td>";
  	echo "<td>" . $resume . "</td>";
  	echo "</tr>";
  }  
  elseif(($jimmy > 901)&&($jimmy < 1800)){ 
  	echo "<tr class='table-warning'>";
  	echo "<td>" . $row[0] . "</td>";
  	echo "<td>" . $row[1] . "</td>";
  	echo "<td>" . $row[3] . "</td>";
  	echo "<td>" . $jimmy . "</td>";
  	echo "<td>" . $row[6] . "</td>";
  	echo "<td>" . $row[10] . "</td>";
  	echo "<td>" . $row[11] . "</td>";
  	echo "<td>" . $pause . "</td>";
  	echo "<td>" . $resume . "</td>";
  	echo "</tr>";
  } 
  elseif(($jimmy > 1801)&&($jimmy < 2700)){ 
  	echo "<tr class='table-primary'>";
  	echo "<td>" . $row[0] . "</td>";
  	echo "<td>" . $row[1] . "</td>";
  	echo "<td>" . $row[3] . "</td>";
  	echo "<td>" . $jimmy . "</td>";
  	echo "<td>" . $row[6] . "</td>";
  	echo "<td>" . $row[10] . "</td>";
  	echo "<td>" . $row[11] . "</td>";
  	echo "<td>" . $pause . "</td>";
  	echo "<td>" . $resume . "</td>";
  	echo "</tr>";
  } 
  else{ 
  	echo "<tr class='table-secondary'>";
  	echo "<td>" . $row[0] . "</td>";
  	echo "<td>" . $row[1] . "</td>";
  	echo "<td>" . $row[3] . "</td>";
  	echo "<td>" . $jimmy . "</td>";
  	echo "<td>" . $row[6] . "</td>";
  	echo "<td>" . $row[10] . "</td>";
  	echo "<td>" . $row[11] . "</td>";
  	echo "<td>" . $pause . "</td>";
  	echo "<td>" . $resume . "</td>";
  	echo "</tr>";
  }  
}
echo "</table>";
?>


