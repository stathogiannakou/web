<?php
require ("../include/config.php");

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: login.php");
	exit;
}


$times = $_SESSION['times'];
$orofos_err = $telephone_err = "";
$onoma = $epwnumo = "";
$orofos = "--Επιλογή--";
$myusername = htmlspecialchars($_SESSION['username']); 
$pel = get_id_til_pel($db,$myusername);
$tilefwno = $pel[1];

$kostos = $_SESSION['kostos'];
$data = $_SESSION['paragelia'];                     
$tem = temaxia($data);
$_SESSION['temaxia'] = $tem;



if($_SERVER["REQUEST_METHOD"] == "POST"){
	// Validate telephone
	$phone_number =trim($_POST['tilefwno']);
	if(!preg_match("/^[0-9]{10}$/", $phone_number)) {
		$telephone_err = "Το τηλέφωνο πρέπει να αποτελείται από 10 ψηφία.";
		$tilefwno = "";
	}
	else{
		$tilefwno = $phone_number;
	}
	
	if ($_POST['Option']){
		$orofos = $_POST['Option']."ος";
		echo "Orofos: ";
		echo $orofos;
	}
	else{
		$orofos_err = "Δεν έχετε επιλέξει όροφο.";
	}		
	$onoma = $_POST['onoma'];
	$epwnumo = $_POST['epwnumo'];
	

    if(empty($telephone_err) && empty($orofos_err) ){

		$_SESSION['latitude'] = $_POST['latitude'];
		$_SESSION['longitude'] = $_POST['longitude'];
		echo "latitude: ";
		echo $_POST['latitude'];
		echo "longitude:";
		echo $_POST['longitude'];
		
		$katastimata = get_katastimata($db);		
		$katast_apost = get_apostaseis($katastimata, $_POST['latitude'], $_POST['longitude']);		
		$sort_katast_apost = msort($katast_apost);

		if($data['Prosthiki6'] || $data['Prosthiki7'] || $data['Prosthiki8'] || $data['Prosthiki9'] || $data['Prosthiki10'])
		{
			$data_apost = get_id_kat_paragelias($db, $sort_katast_apost, $data);
			$id_kat_par = $data_apost['id'];
			$_SESSION['katast_apost'] = $data_apost['apostasi'];			
		}
		else
		{
			$id_kat_par = $sort_katast_apost[0]['id'];
			if ($id_kat_par == 0)
			{
				$a = 1;
			}
			else 
			{
				$_SESSION['katast_apost'] = $sort_katast_apost[0]['apostasi'];		
			}
		}
		
		if ($id_kat_par != 0){
			$_SESSION['stoixeia_paragelias'] = $_POST;
			$_SESSION['id_kat_par'] = $id_kat_par;
			header("location: OK.php");
		}
	
	}
}

?>





<!DOCTYPE html>
<html>
    <head>
        <title>Στοιχεία Παράδοσης</title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   <!-- gia eikona kalathiou -->
		<link rel="stylesheet" type="text/css" href="css/client_olokl_paragelias.css">
		<link rel="icon" type="image/gif/png" href="../images/coffee-cup.png">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>

	<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 	
	<ul>
		<li><a class="active" href="paragelia.php"><img src="../images/back2.png" alt="" height="30" width="30"></a></li>
		<li class="log_out" style="float:right"><a href="logout.php"><img src="../images/logout.png" alt="" height="30" width="25"> </a></li>
	</ul>		
							
	<br><br><br>
					
	<div class="row">
		<div class="container2">
			<div class="col-75">             
   
				<form class="rest" action="" method="post">
					<tr><p style="font-size:25px; color:#333;">Στοιχεία Παράδοσης</p></tr>
					<br>
					<tr>
						<p>Όνομα</p>
						<td class="input"><input name="onoma" id="onoma" required="required" size="40" type="text" value="<?php echo $onoma; ?>"></td>
					</tr>
					<tr>
						<p>Επίθετο</p>
						<td class="input"><input name="epwnumo" id="epwnumo" required="required" size="40" type="text" value="<?php echo $epwnumo; ?>"></td>
					</tr>
					<tr>
						<p>Τηλέφωνο</p>
						<td class="input"><input name="tilefwno" id="tilefwno" required="required" size="40" type="text" value="<?php echo $tilefwno; ?>"></td>
						<?php echo "<span style=color:red>$telephone_err</span>";?>
					</tr>
					<tr>
						<p>Όροφος</p>

							<select name="Option" id="Option" onchange=""> 
							<option value="0"><?php echo "<span>$orofos</span>";?></option>
							<option value="10">Ισόγειο</option>
							<option value="1">1ος</option>
							<option value="2">2ος</option>
							<option value="3">3ος</option>
							<option value="4">4ος</option>
							<option value="5">5ος</option>
							<option value="6">6ος</option>
							<option value="7">7ος</option>
							<option value="8">8ος</option>
							<option value="9">9ος</option>
							  </select> <?php echo "<span style=color:red>$orofos_err</span>";?>
					</tr>

					<tr>
						<p>Διεύθυνση</p>
						<td class="input"><input name="address" id="address" required="required" size="37" type="text"  value=""></td>
					</tr>

					<br><br>

					<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
					<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhrM3O5Paznh9YVxOWo1DenUKyoIYcjNM&libraries=places"></script>
					<script type="text/javascript"> 
						var map;
						var marker;
						var myLatlng = new google.maps.LatLng(38.24647278987824,21.73501110177881);
						var geocoder = new google.maps.Geocoder();
						var infowindow = new google.maps.InfoWindow();

						function initialize(){
							var mapOptions = {
								zoom: 16,
								center: myLatlng,
								mapTypeId: google.maps.MapTypeId.ROADMAP
							};

							map = new google.maps.Map(document.getElementById("myMap"), mapOptions);


							marker = new google.maps.Marker({
								map: map,
								position: myLatlng,
								draggable: true 
							}); 

							geocoder.geocode({'latLng': myLatlng }, function(results, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									if (results[0]) {
										$('#latitude,#longitude').show();
										$('#address').val(results[0].formatted_address);
										$('#latitude').val(marker.getPosition().lat());
										$('#longitude').val(marker.getPosition().lng());
										infowindow.setContent(results[0].formatted_address);
										infowindow.open(map, marker);
									}
								}
							});

							google.maps.event.addListener(marker, 'dragend', function() {
								geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
									if (status == google.maps.GeocoderStatus.OK) {
										if (results[0]) {
											$('#address').val(results[0].formatted_address);
											$('#latitude').val(marker.getPosition().lat());
											$('#longitude').val(marker.getPosition().lng());
											infowindow.setContent(results[0].formatted_address);
											infowindow.open(map, marker);
										}
									}
								});
							});

							var search = document.getElementById('address');
							var autocomplete = new google.maps.places.Autocomplete(search);
							autocomplete.bindTo('bounds', map);

							google.maps.event.addListener(autocomplete, 'place_changed', function () {   
								geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) { 
									if (status == google.maps.GeocoderStatus.OK) {
										if (results[0]) {                 
											var place = autocomplete.getPlace();

											if (place.geometry.viewport) {
												map.fitBounds(place.geometry.viewport);
											} else {
												map.setCenter(place.geometry.location);
											}

											completeAddress = document.getElementById('address').value;
											document.getElementById('latitude').value = place.geometry.location.lat();
											document.getElementById('longitude').value = place.geometry.location.lng();

											marker.setPosition(place.geometry.location);
											marker.setVisible(true);

											infowindow.setContent(completeAddress);
											infowindow.open(map, marker);
										}
									}
								});
							});
						}
						google.maps.event.addDomListener(window, 'load', initialize);
					</script>


					<div id="myMap"></div>
					<input type="hidden" name="latitude" id="latitude" placeholder="Latitude"/>
					<input type="hidden" name="longitude" id="longitude" placeholder="Longitude"/>

					<br><br>

					<a><button class="button" id="button"> Ολοκλήρωση παραγγελίας  </button></a>    
				</form>
			</div>
		</div>                              
	
		<br><br><br><br>	
 
		
		<div class="col-25">
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
	</div>	
	<br>
</body>
</html>