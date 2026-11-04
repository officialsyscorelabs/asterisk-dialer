<?php
include ("lock.php");
include("config.php");


function get_current_date($id){
 return $id;
}

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Jimmy, IT consultant">
    <meta name="generator" content="Hugo 0.79.0">
    <title>Campaign from Smartpremium</title>
<!--https://pypi.org/project/asterisk-ami/-->
  


<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Kristi' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="css/dialpad.css">
<link rel="stylesheet" href="css/button.css">
<!--<link rel="stylesheet" href="css/pagination.css">-->

<script>
var auto_refresh = setInterval(
function ()
{
$("#loading").fadeIn(900,0);
$("#loading").html("<img src='images/loading.gif' />");
$('#cdr').load('lib/group-live.php').fadeIn("slow");
}, 5000); // refresh every 10000 milliseconds

</script>

  </head> 
<body class="bg-light">
  <div class="container py-5">
    <header class="text-center mb-5">
        <h1 class="display-4 font-weight-bold">Routing Dialer Dashboard</h1>
        <p class="font-italic text-muted mb-0">Dialer App</p>
    </header>  
    <h2 class="font-weight-bold mb-2">Realtime Callstats
		<a href="logout.php" class="scl-btn scl-crcl shadow fa fa-power-off float-right"></a>
    </h2>
    <p class="font-italic text-muted mb-4">Realtime Call Connectivity and User Status Display .</p>

<div class="card">
  <h5 class="card-header">Controls</h5>
  <div class="card-body">
      <a href="show-channels.php" class="font-weight-bold btn btn-link" role="button" aria-pressed="true">Show Channels</a>
      <a href="show-peers.php" class="font-weight-bold btn btn-link" role="button" aria-pressed="true">Show Peers</a>
      <a href="manage-filters.php" class="font-weight-bold btn btn-link" role="button" aria-pressed="true">Manage Filter</a>
      <a href="clear-cdr.php" class="font-weight-bold btn btn-link" role="button" aria-pressed="true">Clear CDR</a>
      <a href="clear-filter.php" class="font-weight-bold btn btn-link" role="button" aria-pressed="true">Clear Filter</a>
      <a href="restart-db.php" class="font-weight-bold btn btn-link" role="button" aria-pressed="true">Restart DB</a>
      <a href="restart-switch.php" class="font-weight-bold btn btn-link" role="button" aria-pressed="true">Restart Switch</a>
      <a href="reboot-server.php" class="font-weight-bold btn btn-danger" role="button" aria-pressed="true">Reboot</a>
  </div>
</div>

<div class="card">
  <h5 class="card-header">Online Agent Info</h5>
  <div class="card-body">
    <div id="cdr"></div> 
    <a href="agent-live.php" class="btn btn-primary">Realtime Agent Information</a>
    <a href="all-agent-live.php" class="btn btn-primary">Live Agent Compact view</a>
  </div>
</div>

<div class="card">
  <h5 class="card-header">Call Distribution</h5>
  <div class="card-body">
<table class="table">
  <thead>
    <tr>
      <th scope="col">Total Calls</th>
      <th scope="col">Allowed</th>
      <th scope="col">Up</th>
      <th scope="col">Setup</th>
      <th scope="col">Forward</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">80</th>
      <td>60</td>
      <td>50</td>
      <td>10</td>
      <td>20</td>
    </tr>
  </tbody>
</table>
    <a href="call-control.php" class="btn btn-primary">Map Call Controls</a>
    <a href="count-channels.php" class="btn btn-primary">Calls from Provider</a>
  </div>
</div>

<div class="card">
  <h5 class="card-header">Hardware Information</h5>
  <div class="card-body">

    <p class="card-text">Architecture:          x86_64</p>
    <p class="card-text">CPU op-mode(s):        32-bit, 64-bit</p>
    <p class="card-text">Byte Order:            Little Endian</p>
    <p class="card-text">CPU(s):                8</p>
    <p class="card-text">On-line CPU(s) list:   0-7</p>
    <p class="card-text">Thread(s) per core:    2</p>
    <p class="card-text">Core(s) per socket:    4</p>
    <p class="card-text">Socket(s):             1</p>
    <p class="card-text">Vendor ID:             GenuineIntel</p>
    <p class="card-text">CPU family:            6</p>
    <p class="card-text">Model:                 158</p>
    <p class="card-text">Model name:            Intel(R) Xeon(R) CPU E3-1275 v6 @ 3.80GHz</p>
  </div>
</div>
<!--
<div class="card">
  <h5 class="card-header">Network Information</h5>
  <div class="card-body">
    <h5 class="card-title">Special title treatment</h5>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Get Details</a>
  </div>
</div>
-->
	
 </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <!--
  <script type="text/javascript" src="js/functions.js"></script>
  <script type="text/javascript" src="js/refresh.js"></script>
  -->

  </body>
</html>

