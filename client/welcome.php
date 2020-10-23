<?php
// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}

$msg = $_SESSION['msg'];

$hi = "";
$today = getdate();
//echo "<pre>"; print_r($today); echo "</pre>";

if($today['hours'] > 5 && $today['hours'] < 12)
{
	$hi = "Καλημέρα";
}
else
{
	$hi = "Καλησπέρα";
}

?>




 
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Αρχική</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap_v3.3.7.css">
	<link rel="stylesheet" type="text/css" href="css/client_welcome.css"> 
	<link rel="icon" type="image/gif/png" href="../images/coffee-cup.png">
</head>
<body>
	<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 
	<ul> 
		<li class="log_out" style="float:right"><a href="logout.php"><img src="../images/logout.png" alt="" height="30" width="25"> </a></li>
	</ul>	
    <div class="page-header">
        <span><?php echo $hi; ?>, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Καλωσήρθατε στο κατάστημά μας.</span>
    </div>

	<form action="paragelia.php">
		<button class="button" type="submit">Δημιουργία παραγγελίας</button>
	</form>	
</body>
</html>