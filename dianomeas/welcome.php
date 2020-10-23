<?php
require ("../include/config.php");

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}

$myusername = $_SESSION['username'];
$temp = get_id_dianomea($db,$myusername);
$id_dianomea = $temp[0];	
$_SESSION['id_dianomea'] = $id_dianomea;


if ($_SESSION['wrario'] == "liksi")
{	
	update_anenergos($db,$id_dianomea);
	update_wrario($db,$id_dianomea);
}

?>
 



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>	
	<link rel="stylesheet" type="text/css" href="css/dianomeas_welcome.css">          
</head>
<body>
	<div class="container">
		<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 
		<ul>
  			<li class="log_out"><a href="logout.php"><img src="../images/logout.png" alt="" height="25" width="20"> </a></li>
	
  			<li class="dropdown">
    			<a href="javascript:void(0)" class="dropbtn"><img src="../images/not_available.png" alt="" height="12" width="12">&nbsp;Ανενεργός</a>
    			<div class="dropdown-content">
      				<a href="topothesia.php"><img src="../images/available.png" alt="" height="12" width="12">&nbsp;Ενεργός</a>
    			</div>
  			</li>
		</ul>

		<form action="plirofories.php" method="post">
			<button class="button">Μηνιαία δεδομένα</button> 
		</form>
    </div>
</body>
</html>