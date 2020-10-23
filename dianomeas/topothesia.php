<?php
require ("../include/config.php");

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
 header("location: login.php");
  exit;
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	$id_dianomea = $_SESSION['id_dianomea'];
	$date = getdate();                      
	$time =  $date['hours'].":".$date['minutes'].":".$date['seconds'];
	insert_wrario($db, $date['mday'], $date['mon'], $date['year'], $time, $id_dianomea);
	update_katastasi_dianomea($db, $id_dianomea, $_POST['latitude'], $_POST['longitude']);
	$_SESSION['topothesia'] = $_POST;
	header("location: paragelies.php");
}

?>





<!DOCTYPE html>
<html>
    <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Τοποθεσία</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap_v3.3.7.css">
        <script src="js/jquery.min.js"></script> 
		<link rel="stylesheet" type="text/css" href="css/dianomeas_topothesia.css"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
		<div class="container-fluid">
				<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 
   				<li class="log_out"><a href="logout.php"><img src="../images/logout.png" alt="" height="25" width="20"> </a></li>

				<li class="dropdown">
    				<a href="javascript:void(0)" class="dropbtn"><img src="../images/available.png" alt="" height="12" width="12">&nbsp;Ενεργός</a>
    				<div class="dropdown-content">
      					<a href="welcome.php"><img src="../images/not_available.png" alt="" height="12" width="12"><?php $_SESSION['wrario']="liksi";?>&nbsp;Ανενεργός</a>
    				</div>
  				</li>
		</div>

        <br>
			
		<form class="rest" action="" method="post">
			<tr><p class="t">Επιλογή Τρέχουσας Τοποθεσίας</p></tr>
			<br>
                        
			<tr>
				<td class="input"><input name="address" id="address" required="required" type="text"  value=""></td>
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
        	<a><button class="button" id="button"> Επιβεβαίωση Τοποθεσίας  </button></a>
		</form>	
    </body>
</html>
