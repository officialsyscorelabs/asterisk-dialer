<?php
include("config.php");
//include("lock.php");
ob_implicit_flush(true);
set_time_limit(30);
 
$user=$_REQUEST['username'] ;
//$pass=$_REQUEST['password'] ;


$STARTtime = date("U");

$calltime=0;
$totalanswered=0;
$totalcalls=0;


$sql1 = "select id from sipusers where username='$user';";
$result=mysql_query($sql1);
$row1=mysql_fetch_array($result);

$count=mysql_num_rows($result);
//echo $count;

if($count == '1'){


//get table contents
$sql = "select count(*) as total,sum(duration) as dur,dialstatus from cdrtable where datetime1 > DATE_SUB(NOW(), INTERVAL 10 HOUR) and user='$user' group by dialstatus;";
$rsd = mysql_query($sql);
$a=array();

while($row = mysql_fetch_array($rsd))
{
        $totalcalls=$totalcalls+$row[0];
 
	if($row[2] =="ANSWER"){
		$totalanswered=$totalanswered+$row[0];
                $calltime=$calltime+$row[1];
	}
  	//array_push($a,$row[1]." : ".$jimmy);
}
//print_r($a);

$ACD=$calltime/$totalanswered;
$ACD=number_format((float)$ACD, 2, '.', '');
$action1=$user."-reload";
$action2=$user."-remove";

echo "<div id='".$user."'>
	<h4>User : ".$user."</h4>  
          <div class='table-responsive'>
            <table class='table table-striped table-sm'>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Params</th>
                  <th>Value</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Total Calls Last Hour</td>
                  <td>".$totalcalls."</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Total Answered</td>
                  <td>".$totalanswered."</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Total Duration (secs)</td>
                  <td>".$calltime."</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Generated ACD (secs)</td>
                  <td>".$ACD."</td>
                </tr>
              </tbody>
            </table>
          </div>
          <button type='button' class='btn btn-primary' id='".$action1."'>Reload</button>
          <button type='button' class='btn btn-danger' onclick='$(this).parent().remove();' id='".$action2."'>x Close</button>
     </div>";
}else{
    echo "failed";
}

?> 	 	


