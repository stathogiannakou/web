<?php
require ("../include/config.php");

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}


$id_dianomea = $_SESSION['id_dianomea'];

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (isset($_POST['order'])){
		$data_paragelias = get_data_paragelias($db, $id_dianomea);
//		echo "<pre>"; print_r($data_paragelias); echo "</pre>";
		$_SESSION['lat_par'] = $data_paragelias['lat'];
		$_SESSION['lon_par'] = $data_paragelias['lon'];
		$_SESSION['addr_par'] = $data_paragelias['odos'];
		
	  	update_paragelia($db, $id_dianomea);
		update_katastasi_dianomea($db, $id_dianomea, $_SESSION['lat_par'], $_SESSION['lon_par']);
		update_dianomea_dathesimos($db, $id_dianomea);          
	}
}
else
{
	$topothesia = $_SESSION['topothesia'];
	update_katastasi_dianomea($db, $id_dianomea, $topothesia['latitude'], $topothesia['longitude']);
}

?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Τρέχουσα παραγγελία</title>	
	<link rel="stylesheet" type="text/css" href="css/dianomeas_paragelies.css"> 
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhrM3O5Paznh9YVxOWo1DenUKyoIYcjNM&libraries=places"></script>
	<script src="js/jquery.min.js"></script>
	<script src="js/jquery.googlemap.js"></script>
	<script src="js/paragelies.js"></script>  
</head>
<body>
	<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""><?php $_SESSION['wrario']="liksi";?></a></span> 
	<ul>
	  <li class="dropdown">
		<a href="javascript:void(0)" class="dropbtn"><img src="../images/available.png" alt="" height="12" width="12">&nbsp;Ενεργός</a>
		<div class="dropdown-content">
		  <a href="welcome.php"><img src="../images/not_available.png" alt="" height="12" width="12"><?php $_SESSION['wrario']="liksi";?>&nbsp;Ανενεργός</a>
		</div>
	  </li>

	</ul>	
	<br><br>
	<div id="deliveras"></div>
  
	<br><br><br>
  
	<div id="myMap"></div>
  
	<br><br>

	<center><div id="but_complete"></div></center>  
	
	<script type="text/javascript">
    	var JSession = <?php echo json_encode($_SESSION) ?>;
	</script>

</body>	
</html>
