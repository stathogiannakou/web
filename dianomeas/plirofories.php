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

$date = getdate();
$minas = $date['mon'];
$etos = $date['year'];

$km_diadromes_ana_mera = get_km_diadromes_ana_mera($db, $id_dianomea, $minas, $etos);
// echo "<pre>"; print_r($km_diadromes_ana_mera); echo "</pre>";
$wres = get_wres_mina_dianomea($db, $id_dianomea, $minas, $etos);
$km = get_km_mina_dianomea($db, $id_dianomea, $minas, $etos);

$temp_sunolo = 5*$wres + $km*0.1;
$pos = strpos($temp_sunolo, '.');
$num = $pos+3;
$sunolo = substr($temp_sunolo, 0, $num); 
		
if ($minas == 2)
{
	$meres = 28;
}	
else if ($minas == 4 || $minas == 6 || $minas == 9 || $minas == 11)
{
	$meres = 30;
}
else
{
	$meres = 31;
}

if($minas == 1) $onoma_mina = "Ιανουάριος";
else if($minas == 2) $onoma_mina = "Φεβρουάριος";
else if($minas == 3) $onoma_mina = "Μάρτιος";
else if($minas == 4) $onoma_mina = "Απρίλιος";
else if($minas == 5) $onoma_mina = "Μάϊος";
else if($minas == 6) $onoma_mina = "Ιούνιος";
else if($minas == 7) $onoma_mina = "Ιούλιος";
else if($minas == 8) $onoma_mina = "Αύγουστος";
else if($minas == 9) $onoma_mina = "Σεπτέμβριος";
else if($minas == 10) $onoma_mina = "Οκτώβριος";
else if($minas == 11) $onoma_mina = "Νοέμβριος";
else if($minas == 12) $onoma_mina = "Δεκέμβριος";

?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Πληροφορίες</title>      
	<link rel="stylesheet" type="text/css" href="css/dianomeas_plirofories.css"> 
</head>
<body>
	<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 	
	<ul>
		 <li><a href="welcome.php"><img src="../images/back2.png" alt="" height="25" width="20"> </a>
			</li>
	  <li class="log_out"><a href="logout.php"><img src="../images/logout.png" alt="" height="25" width="20"> </a>
			</li>
	</ul>
	
	<br><br><br>
	<center>	
		<div class="container">	
			<?php echo " Σύνολο χρημάτων: ".$sunolo;?>&euro;
		</div>	
	</center>
		<br><br><br>
	
	<table id="customers">
		<tr>
			<th><?php echo "$onoma_mina"." $etos";?></th>
			<th>Διαδρομές</th>
			<th>Χιλιόμετρα</th>
	  	</tr>
		<?php  $count = 0; 
		  for($i=0; $i<$meres; $i++)
		  {   	if($km_diadromes_ana_mera[$count]['mera']==$i+1)
				{ $d = $km_diadromes_ana_mera[$count]['plithos_diadromwn']; 
				 $pos = strpos($km_diadromes_ana_mera[$count]['xiliometra'], '.');
				 $num = $pos+3;
				 $x = substr($km_diadromes_ana_mera[$count]['xiliometra'], 0, $num); 
				 $count = $count + 1;
				}
				else { $d = 0; $x = 0;}?>
		  <tr>
			<td><?php echo $i+1;?></td>
			<td><?php echo $d;?></td>
			<td><?php echo $x;?></td>
		  </tr>

		<?php } ?>

	</table>
</body>
</html>