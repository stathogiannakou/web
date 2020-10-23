<?php
require ("../include/config.php");

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: manager.php");
  exit;
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Εκρεμείς Παραγγελίες</title>  
	<script src="js/jquery.min.js"></script>
    <script src="js/paragelies.js"></script>  
	<link rel="stylesheet" type="text/css" href="css/bootstrap_v3.3.7.css">
	<link rel="stylesheet" type="text/css" href="css/order.css">
	<link rel="icon" type="image/gif/png" href="../images/coffee-cup.png">
</head>
<body>
	<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 	
	<ul> 
		<li><a class="active" href="welcome.php"><img src="../images/back2.png" alt="" height="30" width="30"></a></li>  
		<li class="log_out" style="float:right"><a href="logout.php"><img src="../images/logout.png" alt="" height="30" width="25"> </a></li>
	</ul>						
		
	<div id="links"></div>
    <center>
		<div class="page-header">
			<h1> Παρακολούθηση Παραγγελιών.</h1>
		</div>

		<br><br><br>


		<div class="container" style="width:900px;"> 
			<br>  
			<div id="orders"></div>  
		</div>
	
    </center>
  	<script type="text/javascript">
    	var JSession = <?php echo json_encode($_SESSION) ?>;
  	</script>
</body>
</html>
