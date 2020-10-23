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
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>Welcome</title>
	<link rel="stylesheet" type="text/css" href="css/manager_welcome.css"> 
	<link rel="icon" type="image/gif/png" href="../images/coffee-cup.png">
</head>
<body>
	<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 	
	<ul> 
		<li class="log_out" style="float:right"><a href="logout.php"><img src="../images/logout.png" alt="" height="30" width="25"> </a></li>
	</ul>		
	
	<br><br><br><br><br><br><br><br>
	<form action="apothemata.php">
	  <button class="button" type="submit">Ενημέρωση Αποθεμάτων</button>
	</form>	
	<form action="paragelies.php">	
		<button class="button" type="submit">Παρακολούθηση Παραγγελιών</button>
	</form>	
	<form action="misthodosia.php">
		<button class="button" type="submit">Εξαγωγή Μισθοδοσίας</button>
	</form>		

</body>
</html>
