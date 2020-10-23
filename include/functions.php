<?php

function console($data){
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}



function print_array($arr)
{
	echo "<div><pre>";
	print_r($arr);
	echo "</pre>--------------------</div>";
}



function print_marray($arrayObject)
{
	foreach($arrayObject as $key=>$data)
	{
		if(is_array($data))
		{
			print_marray($data);
		}
		elseif(is_object($data))
		{
			print_marray($data);
		}
		else
			echo "Key: ".$key." Data: ".$data."<br />";
	}
}



function update_dianomea_dathesimos($db, $id_dianomea)
{
	$sql = "UPDATE `dianomeas` SET `diathesimos` = '1' WHERE `dianomeas`.`id` = '$id_dianomea'";
	$result = mysqli_query($db,$sql);
	
	return ;	
}



function update_dianomea_miDiathesimos($db, $id_dianomea)
{
	$sql = "UPDATE `dianomeas` SET `diathesimos` = '0' WHERE `dianomeas`.`id` = '$id_dianomea'";
	$result = mysqli_query($db,$sql);
	
	return ;
}



function get_data_paragelias($db, $id_dianomea)                                       //     Ekana allagi!!!!!!!!!!!!                   
{
	$sql = "SELECT `paragelia`.`id`, `paragelia`.`onoma` AS 'onoma_pelati', `paragelia`.`epwnumo` AS 'epwnumo_pelati', `paragelia`.`odos`, `orofos`, `paragelia`.`tilefwno`, `sunoliko_poso`, `katastima`.`onoma` AS 'onoma_katastimatos', `katastima`.`dieuthunsi` FROM `paragelia` INNER JOIN `katastima` ON `id_katastimatos` = `katastima`.`id` WHERE `paragelia`.`katastasi` = '0' AND `paragelia`.`id_dianomea` = '$id_dianomea'";
	
  // print "SQL = " .$sql."<br>";
	$result = mysqli_query($db,$sql);

	
	$usr = array();
  

    
	if($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{	
		$usr['id_paragelias'] = $row['id'];	  
		$usr['onoma_pelati'] = $row['onoma_pelati'];	  
		$usr['epwnumo_pelati'] = $row['epwnumo_pelati'];	  
		$od = explode(",", $row['odos']);		  
		$usr['odos'] = $od[0];
	
	
		// Get lat and long by address         
      
		$address = $row['odos']; // Google HQ      
		$prepAddr = str_replace(' ','+',$address);
            
		$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key=AIzaSyAhrM3O5Paznh9YVxOWo1DenUKyoIYcjNM&sensor=false');      
		$output= json_decode($geocode);      
		$latitude = $output->results[0]->geometry->location->lat;     
		$longitude = $output->results[0]->geometry->location->lng;

      	  
		$usr['lat'] = $latitude;	
		$usr['lon'] = $longitude;	
		$usr['orofos'] = $row['orofos'];	
		$usr['tilefwno_pelati'] = $row['tilefwno'];	
		$usr['sunoliko_poso'] = $row['sunoliko_poso'];	
		$usr['onoma_katastimatos'] = $row['onoma_katastimatos'];	
		$od1 = explode(",", $row['dieuthunsi']);		
		$usr['dieuthunsi_katastimatos'] = $od1[0];
	} 
	// echo "<pre>"; print_r($usr); echo "</pre>";

	return $usr;
}



function update_anenergos($db,$id_dianomea)
{
	$sql = "UPDATE `dianomeas` SET `energos` = '0', `diathesimos` = '0' WHERE `dianomeas`.`id` = '$id_dianomea'";
	$result = mysqli_query($db,$sql);
	
	return ;	
}



function get_wres_km_mina_dianomewn($db, $minas, $etos)            
{
	$sql = "SELECT `id_dianomea`, `mera`, `minas`, `etos`, `wra_enarksis`, `liksi`, `onoma`, `epwnumo`, `amka`, `afm`, `iban` FROM `wrario` INNER JOIN `dianomeas` ON `wrario`.`id_dianomea` = `dianomeas`.`id` WHERE `minas` = '$minas' AND `etos` = '$etos' ORDER BY(`wrario`.`id_dianomea`)";
	$result = mysqli_query($db,$sql);
	$arr = array();

	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$usr = array();	  
		$usr['id_dianomea'] = $row['id_dianomea'];
	  
		$temp1 = $row['etos']."-".$row['minas']."-".$row['mera']." ".$row['wra_enarksis'];
		$temp2 = $row['liksi'];
			  
		$usr['onoma'] = $row['onoma'];	  
		$usr['epwnumo'] = $row['epwnumo'];	  
		$usr['amka'] = $row['amka'];	  
		$usr['afm'] = $row['afm'];	  
		$usr['iban'] = $row['iban'];
	  
		$seconds = 0;		  
		$enarksi = new DateTime($temp1);	
		$liksi = new DateTime($temp2);
		
		$since_start = $enarksi->diff($liksi);
//		echo "<pre>"; print_r($since_start); echo "</pre>";
		
		$seconds += $since_start->s;	
		$seconds += $since_start->i * 60;	
		$seconds += $since_start->h * 60 * 60;
		$seconds += $since_start->d * 60 * 60 * 24;
			
		$usr['seconds'] = $seconds;
		
		array_push($arr,$usr);
	}

	$size = count($arr);
	$arrDianomea = array();

	if($size > 0)
	{
		$count = 0;
		$i = 1;
		$usr = array();
		$seconds = 0;

		while($count <= $size)
		{
			if ($arr[$count]['id_dianomea'] == $i)
			{
				$seconds = $seconds + $arr[$count]['seconds'];
				$count = $count + 1;
			}
			else if ($seconds != 0)
			{
				$h = $seconds/3600;
				$usr['id_dianomea'] = $arr[$count-1]['id_dianomea'];
				$usr['onoma'] = $arr[$count-1]['onoma'];
				$usr['epwnumo'] = $arr[$count-1]['epwnumo'];
				$usr['amka'] = $arr[$count-1]['amka'];
				$usr['afm'] = $arr[$count-1]['afm'];
				$usr['iban'] = $arr[$count-1]['iban'];
				$usr['hours'] = $h;
				$usr['km'] = 0;
				$seconds = 0;
				$i = $i + 1;
				array_push($arrDianomea,$usr);
				$usr = array();
				if ($count == $size){ $count = $count + 1;}
			}
			else
			{
				$i = $i + 1;
			}
		}


		$sql = "SELECT `paragelia`.`id_dianomea`, SUM(xiliometra) AS 'xiliometra' FROM `paragelia` WHERE `minas` = '$minas' AND `etos` = '$etos' AND `katastasi` = '1' GROUP BY(`id_dianomea`) ORDER BY(`id_dianomea`)";
		$result = mysqli_query($db,$sql);

		$count = 0;
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){

			if ($arrDianomea[$count]['id_dianomea'] == $row['id_dianomea'])
			{
				$arrDianomea[$count]['km'] = $row['xiliometra'];
				$count = $count + 1;
			}
			else 
			{
				while($arrDianomea[$count]['id_dianomea'] != $row['id_dianomea'])
				{
					$count = $count + 1;
				}
				$arrDianomea[$count]['km'] = $row['xiliometra'];
				$count = $count + 1;
			}
		}
	}
	return $arrDianomea;
}



function get_id_paragelias($db, $id_pel, $date)
{
	$sql = "SELECT `id` FROM `paragelia` WHERE `paragelia`.`id_pelati` = '$id_pel' AND `paragelia`.`DateTime` = '$date'";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_NUM);
	
	return $row[0];
}



function insert_perilambanei($db, $id_pel, $date, $data)
{
	$id_paragelias = get_id_paragelias($db, $id_pel, $date);
	$count = 1;
	
	while( $count < 11){
		$d = "Prosthiki".$count;
		if ($data[$d] != 0)
		{
			$id_proiontos = $count;
			$sql = "INSERT INTO `perilambanei` (`id_paragelias`, `id_proiontos`, `posotita`) VALUES ('$id_paragelias', '$id_proiontos', '$data[$d]')";
			$result = mysqli_query($db,$sql);
		}
		$count = $count + 1;	
	}
	return ;
}



function get_tziro_katastimatwn($db, $minas, $etos)                           
{
	$sql = "SELECT `id`, `onoma_upeuthunou`, `epwnumo_upeuthunou`, `amka`, `afm`, `iban` FROM `katastima` ORDER BY(`id`)";
	$result = mysqli_query($db,$sql);
	$katastimataArray = array();
	 
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$usr = array();	  
		$usr['id_katastimatos'] = $row['id'];	  
		$usr['onoma_upeuthunou'] = $row['onoma_upeuthunou'];	  
		$usr['epwnumo_upeuthunou'] = $row['epwnumo_upeuthunou'];	  
		$usr['amka'] = $row['amka'];	  
		$usr['afm'] = $row['afm'];	  
		$usr['iban'] = $row['iban']; 
		$usr['tziros'] = 0;
	  array_push($katastimataArray,$usr);
	}
	

//	echo "<pre>"; print_r($katastimataArray); echo "</pre>";
	
	
	$sql = "SELECT `id_katastimatos`, SUM(`sunoliko_poso`) AS 'tziros' FROM `paragelia` WHERE `paragelia`.`katastasi` = '1' AND `paragelia`.`minas` = '$minas' AND `paragelia`.`etos` = '$etos' GROUP BY(`id_katastimatos`) ORDER BY(`id_katastimatos`)";
	
	$result = mysqli_query($db,$sql);
	
	$count = 0;
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		
		if ($katastimataArray[$count]['id_katastimatos'] == $row['id_katastimatos'])
		{
			$katastimataArray[$count]['tziros'] = $row['tziros'];
			$count = $count + 1;
		}
		else 
		{
			while($katastimataArray[$count]['id_katastimatos'] != $row['id_katastimatos'])
			{
				$count = $count + 1;
			}
			$katastimataArray[$count]['tziros'] = $row['tziros'];
			$count = $count + 1;
		}
	}
	return $katastimataArray;
}



function get_km_diadromes_ana_mera($db, $id_dianomea, $minas, $etos)
{
	$sql = "SELECT `paragelia`.`mera`, COUNT(`mera`) AS 'plithos_diadromwn', SUM(`xiliometra`) AS 'xiliometra' FROM `paragelia` WHERE `id_dianomea` = '$id_dianomea' AND `minas` = '$minas' AND `etos` = '$etos' AND `katastasi` = '1' GROUP BY(`mera`)";
	$result = mysqli_query($db,$sql);
	$arr = array();
	 
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$usr = array();
		$usr['mera'] = $row['mera'];
		$usr['plithos_diadromwn'] = $row['plithos_diadromwn'];
		$usr['xiliometra'] = $row['xiliometra'];
		array_push($arr,$usr);
	}
	return $arr;
}



function get_wres_mina_dianomea($db, $id_dianomea, $minas, $etos)
{
	$sql = "SELECT `mera`, `minas`, `etos`, `wra_enarksis`, `liksi` FROM `wrario` WHERE `id_dianomea` = '$id_dianomea' AND `minas` = '$minas' AND `etos` = '$etos'";
	$result = mysqli_query($db,$sql);
	$arr = array();
	$seconds = 0;	
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){

		$temp1 = $row['etos']."-".$row['minas']."-".$row['mera']." ".$row['wra_enarksis'];
	  	$temp2 = $row['liksi'];
		
	  	$enarksi = new DateTime($temp1);
		$liksi = new DateTime($temp2);
		
		$since_start = $enarksi->diff($liksi);
//		echo "<pre>"; print_r($since_start); echo "</pre>";
		
		$seconds += $since_start->s;
		$seconds += $since_start->i * 60;
		$seconds += $since_start->h * 60 * 60;
		$seconds += $since_start->d * 60 * 60 * 24;
		
//		echo $seconds.' seconds'."   ";	
	}
	$hours = $seconds/3600;
	return $hours;
}



function get_km_mina_dianomea($db, $id_dianomea, $minas, $etos)
{
	$sql = "SELECT SUM(`xiliometra`) FROM `paragelia` WHERE `id_dianomea` = '$id_dianomea' AND `minas` = '$minas' AND `etos` = '$etos' AND `katastasi` = '1'";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_NUM);

	if($row[0])
		return $row[0];
	else
		return 0;
}



function update_wrario($db,$id_dianomea)
{
	$now = getdate();
	$liksi = $now['year']."-".$now['mon']."-".$now['mday']." ".$now['hours'].":".$now['minutes'].":".$now['seconds'];	
	
	$sql = "UPDATE `wrario` SET `liksi` = '$liksi' WHERE `wrario`.`id_dianomea` = '$id_dianomea' AND `liksi` IS NULL";
	$result = mysqli_query($db,$sql);
	
	return ;
}



function get_id_paragelias_dianomea($db, $id_dianomea)
{
	$sql = "SELECT `id` FROM `paragelia` WHERE `paragelia`.`id_dianomea` = '$id_dianomea' AND `paragelia`.`katastasi` = '0'";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_NUM);
	
	return $row[0];
}



function update_paragelia($db, $id_dianomea)
{
	$id_paragelias = get_id_paragelias_dianomea($db, $id_dianomea);
	$date = getdate();
//	echo "<pre>"; print_r($date); echo "</pre>";
	
	$day = $date['mday'];
	$year = $date['year'];
	$month = $date['mon'];
	
	$sql = "UPDATE `paragelia` SET `mera` = '$day', `minas` = '$month', `etos` = '$year', `katastasi` = '1' WHERE `paragelia`.`id` = '$id_paragelias'";
	$result = mysqli_query($db,$sql);
	
	return ;	
}



function insert_wrario($db, $mday, $mon, $year, $time, $id)
{
	$sql = "INSERT INTO `wrario` (`id`, `mera`, `minas`, `etos`, `wra_enarksis`, `id_dianomea`) VALUES (NULL, '$mday', '$mon', '$year', '$time', '$id')";
	$result = mysqli_query($db,$sql);
	return ;
}



function insert_paragelia($db, $onoma, $epwnumo, $tilefwno, $kostos, $orofos, $odos, $id_dianomea, $km, $id_pelati, $id_katastimatos, $date)
{
	$sql = "INSERT INTO `paragelia` (`id`, `onoma`, `epwnumo`, `odos`, `orofos`, `tilefwno`, `sunoliko_poso`, `mera`, `minas`, `etos`, `katastasi`, `id_dianomea`, `xiliometra`, `id_pelati`, `id_katastimatos`, `DateTime`) VALUES (NULL, '$onoma', '$epwnumo', '$odos', '$orofos', '$tilefwno', '$kostos', NULL, NULL, NULL, '0', '$id_dianomea', '$km', '$id_pelati', '$id_katastimatos', '$date')";
	
//	echo "|".$sql."|";
	$result = mysqli_query($db,$sql);
	
	return ;
}



function get_katastimata($db)
{
	$sql = "SELECT id, lat AS latitude, lon AS longitude FROM katastima";
	$result = mysqli_query($db,$sql);
	$arr = array();

	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){	  
		$usr = array();
		$usr['id'] = $row['id'];	  
		$usr['latitude'] = $row['latitude'];      
		$usr['longitude'] = $row['longitude'];	  
		array_push($arr,$usr);
	}

	return $arr;
}



function msort($array, $id="apostasi") 
{  
	$temp_array = array();        
	while(count($array)>0) {           
		$lowest_id = 0;            
		$index=0;           
		foreach ($array as $item) {                
			if ($item[$id]<$array[$lowest_id][$id]) {                    
				$lowest_id = $index;               
			}               
			$index++;            
		}            
		$temp_array[] = $array[$lowest_id];            
		$array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));        
	}        
	return $temp_array;   
}



function get_apostaseis($katastimata, $pel_lat, $pel_lon)                        //gia dianomea $katastimata = dianomeis,     $pel_* = $kat_*
{
     $arr = array();
	 foreach ($katastimata as $val){			 
		 $details = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$val['latitude']},{$val['longitude']}&destinations={$pel_lat},{$pel_lon}&mode=driving&key=AIzaSyAhrM3O5Paznh9YVxOWo1DenUKyoIYcjNM";

    	$json = file_get_contents($details);
    	$details = json_decode($json, TRUE);
		 
		$usr = array();
	  	$usr['id'] = $val['id'];
//		 echo "<pre>"; print_r($details); echo "</pre>";
	  	$usr['apostasi'] = $details['rows'][0]['elements'][0]['distance']['value'];

	  	array_push($arr,$usr);	 
	}	
	return $arr;	
}



function kostos($data, $times)
{	
	$count = 1;
	$sum = 0;
	
	while( $count < 11){
		$d = "Prosthiki".$count;
		$sum = $sum + $data[$d]*$times[$count-1]['timi'];
		$count = $count + 1;
	}
	return $sum;			
}



function temaxia($data)
{	
	$count = 1;
	$sum = 0;
	
	while( $count < 11){
		$d = "Prosthiki".$count;
		$sum = $sum + $data[$d];
		$count = $count + 1;
	}
	return $sum;		
}



function get_id_kat($db,$myusername)
{
	$sql = "SELECT `id` FROM `katastima` WHERE `katastima`.`username` = '$myusername'";

	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_NUM);

	return $row; 
}



function get_id_pel($db,$myusername)
{
	$sql = "SELECT `id` FROM `pelatis` WHERE `pelatis`.`email` = '$myusername'";

	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_NUM);

	return $row; 
}



function get_id_dianomea($db,$myusername)
{
	$sql = "SELECT `id` FROM `dianomeas` WHERE `dianomeas`.`username` = '$myusername'";

	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_NUM);

	return $row; 
}



function update_katastasi_dianomea($db,$id_dianomea, $lat, $lon)
{
	$sql = "UPDATE `dianomeas` SET `energos` = '1', `diathesimos` = '1', `lat` = '$lat', `lon` = '$lon' WHERE `dianomeas`.`id` = '$id_dianomea'";
	$result = mysqli_query($db,$sql);
	
	return ;
}



function get_diathesimous_dianomeis($db)
{
	$sql = "SELECT `id`, `lat`, `lon` FROM `dianomeas` WHERE `dianomeas`.`diathesimos` = '1'";
	$result = mysqli_query($db,$sql);
	$arr = array();
	 
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	  	$usr = array();
	  	$usr['id'] = $row['id'];
	  	$usr['latitude'] = $row['lat'];
      	$usr['longitude'] = $row['lon'];
	  	array_push($arr,$usr);
	}
	return $arr;
}



function get_id_til_pel($db,$myusername)
{
	$sql = "SELECT `id`, `tilefwno` FROM `pelatis` WHERE `pelatis`.`email` = '$myusername'";

	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_NUM);

	return $row; 
}


function get_id_kat_paragelias($db, $sort_katast_apost, $data)                             // & dianomeas
{
	$count = 0;
	$data_apost = array();
	$arithmos_katast = count($sort_katast_apost);
	while($id_kat == 0 && $count < $arithmos_katast)
	{
		$count = $count + 1;
		$usr = array();
		$usr = get_apothemata($db,$sort_katast_apost[$count-1][id]);
//		echo "<pre>"; print_r($usr); echo "</pre>";
		
		$i = 0;
		while($i < 5 && $id_kat == 0){
			$c = $i + 6;		
			$d = "Prosthiki".$c;

			if($usr[$i]['posotita'] <  $data[$d])
			{
				$i = 10;
			}
			else
			{
				$id_kat = $sort_katast_apost[$count-1][id];
				$data_apost['id'] = $sort_katast_apost[$count-1]['id'];
				$data_apost['apostasi'] = $sort_katast_apost[$count-1]['apostasi'];
			}
			
			$i = $i + 1;
			if ($i == 11 || $i < 5)
			{
				$id_kat = 0;
			}
		}
	}
	return $data_apost;
}



function get_apothemata($db,$id_kat)
{
	$sql = "SELECT posotita, perigrafi FROM `snak` INNER JOIN `proion` ON `snak`.`id_proiontos` = `proion`.`id` WHERE `snak`.`id_katastimatos` = '$id_kat'";
	$result = mysqli_query($db,$sql);
	$arr = array();
	 
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	  	$usr = array();
	  	$usr['posotita'] = $row['posotita'];
      	$usr['perigrafi'] = $row['perigrafi'];
	  	array_push($arr,$usr);
	}
	return $arr;
}



function get_times($db)
{
	$sql = "SELECT timi, perigrafi FROM `proion`";
	$result = mysqli_query($db,$sql);
	$arr = array();

	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	  	$usr = array();
	  	$usr['timi'] = $row['timi'];
      	$usr['perigrafi'] = $row['perigrafi'];
	  	array_push($arr,$usr);
	}
	return $arr;
}



function update_apothema($db,$id_kat,$data,$old_data)
{
	$j = 6;
	for ($i = 1; $i < 6; $i++) {
		$d = "Prosthiki".$i;
		$a = $data[$d] + $old_data[$i-1]['posotita'];
		
		$sql = "UPDATE snak SET posotita='$a' WHERE id_katastimatos='$id_kat' and id_proiontos='$j' ";
		$j = $j  + 1;
		$result = mysqli_query($db,$sql);
	}
	return ;
}



function decrease_apothema($db,$id_kat,$data)
{
	$apothema = get_apothemata($db,$id_kat);
	
	$j = 6;
	for ($i = 1; $i < 6; $i++) {

		$d = "Prosthiki".$j;
		$a = $apothema[$i-1]['posotita'] - $data[$d];
		$sql = "UPDATE snak SET posotita='$a' WHERE id_katastimatos='$id_kat' and id_proiontos='$j'";
		$j = $j  + 1;
		$result = mysqli_query($db,$sql);	
	}
	return ;
}



function get_paragelies($db,$id_kat)
{
    $sql = "SELECT `id` FROM `paragelia` WHERE  `katastasi` = '0' AND `id_katastimatos` = '$id_kat'";
	$result = mysqli_query($db,$sql);
	$arr = array();

	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
	  $usr = array();
	  $usr['id'] = $row['id'];
     
	  array_push($arr,$usr);
	}
	return $arr;
}



function check_paragelia($data)
{
	$c = 0;
	
	if($data['Prosthiki1'] || $data['Prosthiki2'] || $data['Prosthiki3'] || $data['Prosthiki4'] || $data['Prosthiki5'] || $data['Prosthiki6'] || $data['Prosthiki7'] || $data['Prosthiki8'] || $data['Prosthiki9'] || $data['Prosthiki10'])
	{
		$c = 1;
	}
	
/*	
	while($c == 0 && $count < 11){
		$d = "Prosthiki".$count;
		if ($data[$d] > 0) $c = 1;
		$count = $count + 1;
	}
*/
	return $c;
}


?>