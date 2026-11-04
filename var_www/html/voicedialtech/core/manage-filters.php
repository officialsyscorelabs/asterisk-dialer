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
$('#cdr').load('lib/manage-filter.php').fadeIn("slow");
}, 2000); // refresh every 10000 milliseconds

function updatefilter(){
 var grp = document.getElementById("filtergroup");
 var group= grp.options[grp.selectedIndex].text;

 var type1 = document.getElementById("filtertype");
 var type2= type1.options[type1.selectedIndex].text;

 var dur = document.getElementById("filterduration");
 var duration= dur.options[dur.selectedIndex].text;
 if ((group =='Choose...')||(type2 =='Choose...')||(duration =='Choose...')){
    alert("Error: Please select all Filters");
 }else{
    alert("Filter Selection Perfct");
    $.get("lib/manage-filter-update.php", {group: group, duration: duration , type2: type2 } ); 
 }
}
</script>

  </head> 
<body class="bg-light">
  <div class="container py-5">
    <header class="text-center mb-5">
        <h1 class="display-4 font-weight-bold">Smart Premium Dashboard</h1>
        <p class="font-italic text-muted mb-0">Automatic AI Based Call Distribution App</p>
    </header>  
    <h2 class="font-weight-bold mb-2">Manage Filters
		<a href="logout.php" class="scl-btn scl-crcl shadow fa fa-power-off float-right"></a>
    </h2>
    <p class="font-italic text-muted mb-4">Realtime Call Connectivity and User Status Display .</p>

<div class="card">
  <h5 class="card-header">Controls</h5>
  <div class="card-body">
      <a href="dashboard.php" class="font-weight-bold btn btn-link" role="button" aria-pressed="true">Dashboard</a>
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
  <h5 class="card-header">Filter Manager</h5>
  <div class="card-body">
    <h5 class="card-title">Select Custom Filters</h5>
	<form class="form-inline">
  		<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Select Group</label>
  		<select class="custom-select my-1 mr-sm-2" id="filtergroup">
    			<option selected>Choose...</option>
    			<option value="1">Group1</option>
    			<option value="2">Group2</option>
    			<option value="3">Group3</option>
    			<option value="4">Group4</option>
    			<option value="5">Group5</option>
    			<option value="6">Group6</option>
    			<option value="7">Group7</option>
    			<option value="8">Group8</option>
  		</select>
  		<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Filter By</label>
  		<select class="custom-select my-1 mr-sm-2" id="filtertype">
    			<option selected>Choose...</option>
    			<option value="1">Off</option>
    			<option value="2">CallerID</option>
    			<option value="3">CalleeID</option>
    			<option value="4">Both</option>
  		</select>
  		<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Duration</label>
  		<select class="custom-select my-1 mr-sm-2" id="filterduration">
    			<option selected>Choose...</option>
    			<option value="1">0</option>
    			<option value="2">1</option>
    			<option value="3">2</option>
    			<option value="4">3</option>
    			<option value="5">4</option>
    			<option value="6">5</option>
    			<option value="7">10</option>
    			<option value="8">15</option>
    			<option value="9">20</option>
    			<option value="10">24</option>
    			<option value="11">48</option>
    			<option value="12">72</option>
  		</select>

  		<button type="submit" id="filterSubmit" class="btn btn-primary my-1" onclick="updatefilter()">Submit</button>
	</form>  
  </div>
</div>
	
<div class="card">
  <h5 class="card-header">Existing Filter Details</h5>
  <div class="card-body">
     <div id="cdr"></div>
  </div>
</div>

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

