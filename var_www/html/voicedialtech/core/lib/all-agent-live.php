<?php
include('lock.php');
include('config.php');

$STARTtime = date("U");

//get table contents
$sql = "select * from sipusers where active='active' order by username";
$rsd = mysql_query($sql);
$a=array();

while($row = mysql_fetch_array($rsd))
{
	if($row[6] =="busy"){
		$jimmy=$STARTtime-$row[5];
	}
	else{
		$jimmy=0;
	}
  	array_push($a,$row[1]." : ".$jimmy);
}
//print_r($a);

echo "<table class='table table-striped'>
  <thead>
  <tr>
    <th>1</th>
    <th>2</th>
    <th>3</th>
    <th>4</th>
    <th>5</th>
    <th>6</th>
    <th>7</th>
    <th>8</th>
    <th>9</th>
    <th>10</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td>".$a[0]."</td>
    <td>".$a[1]."</td>
    <td>".$a[2]."</td>
    <td>".$a[3]."</td>
    <td>".$a[4]."</td>
    <td>".$a[5]."</td>
    <td>".$a[6]."</td>
    <td>".$a[7]."</td>
    <td>".$a[8]."</td>
    <td>".$a[9]."</td>
  </tr>
  <tr>
    <td>".$a[10]."</td>
    <td>".$a[11]."</td>
    <td>".$a[12]."</td>
    <td>".$a[13]."</td>
    <td>".$a[14]."</td>
    <td>".$a[15]."</td>
    <td>".$a[16]."</td>
    <td>".$a[17]."</td>
    <td>".$a[18]."</td>
    <td>".$a[19]."</td>
  </tr>
  <tr>
    <td>".$a[20]."</td>
    <td>".$a[21]."</td>
    <td>".$a[22]."</td>
    <td>".$a[23]."</td>
    <td>".$a[24]."</td>
    <td>".$a[25]."</td>
    <td>".$a[26]."</td>
    <td>".$a[27]."</td>
    <td>".$a[28]."</td>
    <td>".$a[29]."</td>
  </tr>
  <tr>
    <td>".$a[30]."</td>
    <td>".$a[31]."</td>
    <td>".$a[32]."</td>
    <td>".$a[33]."</td>
    <td>".$a[34]."</td>
    <td>".$a[35]."</td>
    <td>".$a[36]."</td>
    <td>".$a[37]."</td>
    <td>".$a[38]."</td>
    <td>".$a[39]."</td>
  </tr>
  <tr>
    <td>".$a[40]."</td>
    <td>".$a[41]."</td>
    <td>".$a[42]."</td>
    <td>".$a[43]."</td>
    <td>".$a[44]."</td>
    <td>".$a[45]."</td>
    <td>".$a[46]."</td>
    <td>".$a[47]."</td>
    <td>".$a[48]."</td>
    <td>".$a[49]."</td>
  </tr>
  <tr>
    <td>".$a[50]."</td>
    <td>".$a[51]."</td>
    <td>".$a[52]."</td>
    <td>".$a[53]."</td>
    <td>".$a[54]."</td>
    <td>".$a[55]."</td>
    <td>".$a[56]."</td>
    <td>".$a[57]."</td>
    <td>".$a[58]."</td>
    <td>".$a[59]."</td>
  </tr>
 </tbody>
</table>";
?> 	 	


