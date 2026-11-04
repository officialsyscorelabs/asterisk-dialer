<?php

include("config.php");
session_start();
error_reporting(E_ALL);
error_reporting(-1);
ini_set('error_reporting', E_ALL);

if($_SERVER["REQUEST_METHOD"] == "POST")
{
// username and password sent from form 

$myusername=addslashes($_POST['username']); 
$mypassword=addslashes($_POST['password']); 


$sql="SELECT id FROM dialme WHERE username='$myusername' and passcode='$mypassword' and usertype='Administrator';";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$active=$row['active'];

$count=mysql_num_rows($result);

 
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1)
{
//session_register("myusername");
$_SESSION['login_user']=$myusername;

header("location: core/dashboard.php");
}
else 
{
$error="Your Login Name or Password is invalid";
}
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
    <title>Smart Dialer</title>
<!--https://pypi.org/project/asterisk-ami/-->
  

<link href="style/partition.css" media="screen" rel="stylesheet" type="text/css" />
<link href="style/csschart.css" media="screen" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Kristi' rel='stylesheet'>
<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="css/button.css">
 
  </head>
<body class="bg-light">
	<div class="container">
    <!-- For Demo Purpose-->
 	  <div class="row mt-5">
        <div class="col-12 col-md-8 my-auto mx-auto" >
			<header class="text-center">
				<h1 class="display-4 font-weight-bold">Routing</h1>
				<p class="font-italic text-muted mb-0">Dialer</p>
			</header>
		</div>
	  </div>	
	  <div class="row mt-5">
        <!--<div class="col-sm-4 my-auto mx-auto">
	    <div class="card rounded shadow border-0">
                <div class="card-body">
                   <img src="core/img/mata.jpg" width="300" height="360" class="rounded mx-auto d-block" alt="">
                </div> 
            </div>
        -->
 
	</div>

        <div class="col-sm-4 my-auto mx-auto">
	    <div class="card rounded shadow border-0">
                <div class="card-body">
                    <h5><a href="#" class="text-dark">Sign in</a></h5>
					<form method="post" action="">
						<div class="form-group">
							<label for="exampleInputEmail1">Email address</label>
							<input type="email" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-sm btn-custom-white font-weight-bold">Login</button>
					</form>
                </div>
            </div>
 
	</div>
     </div>
	
 </div>
	
	  
</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  </body>
</html>

