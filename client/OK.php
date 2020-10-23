<?php
require ("../include/config.php");

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}

$sxoixeia_par = $_SESSION['stoixeia_paragelias'];
$data = $_SESSION['paragelia'];
$kostos = $_SESSION['kostos'];
$id_kat_par = $_SESSION['id_kat_par'];
$tem = $_SESSION['temaxia'];
$times = $_SESSION['times'];
$myusername = $_SESSION['username'];
$kat_lat = $_SESSION['latitude'];
$kat_lon = $_SESSION['longitude'];
$stoixeia_apostasis_katastimatos = $_SESSION['katast_apost'];



if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	
	$temp = get_id_pel($db,$myusername);
	$id_pel = $temp[0];
	
	$dianomeis = get_diathesimous_dianomeis($db);	
	$apost_katast_dianomeis = get_apostaseis($dianomeis, $kat_lat, $kat_lon);	
	$sort_apost_katast_dianomeis = msort($apost_katast_dianomeis, $id="apostasi");
	
	$date = getdate();                                        //    $date['mday']       $date['mon']   $date['year']
	$dianomeas = $sort_apost_katast_dianomeis[0];

	update_dianomea_miDiathesimos($db, $sort_apost_katast_dianomeis[0]['id']);
		
	$metra = $stoixeia_apostasis_katastimatos + $sort_apost_katast_dianomeis[0]['apostasi'];
	$km = ($metra/1000);
	
	$now = getdate();
	$date = $now['year']."-".$now['mon']."-".$now['mday']." ".$now['hours'].":".$now['minutes'].":".$now['seconds'];

	insert_paragelia($db, $sxoixeia_par['onoma'], $sxoixeia_par['epwnumo'], $sxoixeia_par['tilefwno'], $kostos, $sxoixeia_par['Option'], $sxoixeia_par['address'], 			$sort_apost_katast_dianomeis[0]['id'], $km, $id_pel, $id_kat_par, $date);
	
	decrease_apothema($db,$id_kat_par,$data);
	insert_perilambanei($db, $id_pel, $date, $data);
			
	$_SESSION['msg'] = "Η παραγγελία σας καταχωρήθηκε επιτυχώς.";
	
	header("location: welcome.php");
}

?>




<!DOCTYPE html>
<html>
<head>
	<title>Ολοκλήρωση Παραγγελίας</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  <!-- gia eikona kalathiou -->

	<link rel="stylesheet" type="text/css" href="css/client_OK.css"> 
	<link rel="icon" type="image/gif/png" href="../images/coffee-cup.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 
	<ul> 
		<li><a class="active" href="oloklirwsi_paragelias.php"><img src="../images/back2.png" alt="" height="30" width="30"></a></li>  
		<li class="log_out" style="float:right"><a href="logout.php"><img src="../images/logout.png" alt="" height="30" width="25"> </a></li>
	</ul>		
	
	
	<div class="col-25">
		<div class="container2">			
			<table> 
			<tr><th>Στοιχεία</th></tr>
			<tr><td><span class="color2">test</span></td></tr>
			<tr><td>Όνομα: <span class="color"><?php echo $sxoixeia_par['onoma']; ?></span></td></tr> 	
			<tr><td>Επώνυμο: <span class="color"><?php echo $sxoixeia_par['epwnumo']; ?></span></td></tr> 
			<tr><td>Διεύθυνση: <span class="color"><?php echo $sxoixeia_par['address']; ?></span></td></tr> 
			<tr><td>Όροφος: <span class="color"><?php echo $sxoixeia_par['Option']; ?>ος</span></td></tr> 
			<tr><td>Τηλέφωνο: <span class="color"><?php echo $sxoixeia_par['tilefwno']; ?></span></td></tr> 
			</table>
		</div>
	
	
	
		<div class="container">
			<h4>Καλάθι <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b><?php echo $tem ?></b></span></h4>
			<?php if($data['Prosthiki1']) : ?>  <p><?php echo $data['Prosthiki1']." x ".$times[0]['perigrafi'] ?> <span class="price"><?php echo $times[0]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<?php if($data['Prosthiki2']) : ?>  <p><?php echo $data['Prosthiki2']." x ".$times[1]['perigrafi'] ?> <span class="price"><?php echo $times[1]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<?php if($data['Prosthiki3']) : ?>  <p><?php echo $data['Prosthiki3']." x ".$times[2]['perigrafi'] ?> <span class="price"><?php echo $times[2]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<?php if($data['Prosthiki4']) : ?>  <p><?php echo $data['Prosthiki4']." x ".$times[3]['perigrafi'] ?> <span class="price"><?php echo $times[3]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<?php if($data['Prosthiki5']) : ?>  <p><?php echo $data['Prosthiki5']." x ".$times[4]['perigrafi'] ?> <span class="price"><?php echo $times[4]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<?php if($data['Prosthiki6']) : ?>  <p><?php echo $data['Prosthiki6']." x ".$times[5]['perigrafi'] ?> <span class="price"><?php echo $times[5]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<?php if($data['Prosthiki7']) : ?>  <p><?php echo $data['Prosthiki7']." x ".$times[6]['perigrafi'] ?> <span class="price"><?php echo $times[6]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<?php if($data['Prosthiki8']) : ?>  <p><?php echo $data['Prosthiki8']." x ".$times[7]['perigrafi'] ?> <span class="price"><?php echo $times[7]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<?php if($data['Prosthiki9']) : ?>  <p><?php echo $data['Prosthiki9']." x ".$times[8]['perigrafi'] ?> <span class="price"><?php echo $times[8]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<?php if($data['Prosthiki10']) : ?>  <p><?php echo $data['Prosthiki10']." x ".$times[9]['perigrafi'] ?> <span class="price"><?php echo $times[9]['timi'] ?>&euro;</span></p> <?php endif; ?> 
			<hr>
			<p>Σύνολο <span class="price" style="color:black"><b><?php echo $kostos ?>&euro;</b></span></p>
		</div>
	</div>


	<form action="" method="post">
		<button class="button">Επιβεβαίωση</button> 
	</form>
	
	<br><br>

	<form action="welcome.php" method="get">
		<button class="button_red">Ακύρωση</button> 		
	</form>
	
</body>
</html>
