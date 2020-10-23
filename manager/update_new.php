<?php

require_once '../include/config.php';

$store_id = $_GET['id'];


$sql = "SELECT `paragelia`.`id` AS id, `sunoliko_poso` AS poso, `epwnumo`, `tilefwno`,`odos`, `perigrafi`, `posotita`, `DateTime` FROM `paragelia` INNER JOIN `perilambanei` ON `perilambanei`.`id_paragelias` = `paragelia`.`id`  INNER JOIN `proion` ON `perilambanei`.`id_proiontos` = `proion`.`id` WHERE  `katastasi` = '0' AND `id_katastimatos` = ". $store_id;

//print($sql);
  
    
$data["ParageliesData"] = array();
  
$result = mysqli_query($db,$sql);
$arr = array();

$s = 0;
$count = 0;
$temp = "";

while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){

	if($s == 0)
	{
		$arr['id'] = $row['id'];
		$arr['poso'] = $row['poso'].' &euro; ';
		$t = explode(" ", $row['DateTime']);
		$arr['time'] = substr($t[1], 0, 5);;
		$arr['epwnumo'] = $row['epwnumo'];
		$arr['tilefwno'] = $row['tilefwno'];
			
		$od = explode(",", $row['odos']);
		$arr['odos'] = $od[0];
			
		$temp = $row['posotita']."x".$row['perigrafi'];
		$s = 1;
	}
    elseif ($arr['id'] == $row['id'])
    {
		$temp = $temp.", ".$row['posotita']."x".$row['perigrafi'];			
    }
    else 
    {
        $arr['proionta'] = $temp;
        
        array_push($data["ParageliesData"],$arr);
        
        $arr = array();
        $arr['id'] = $row['id'];
        $arr['poso'] = $row['poso'].' &euro; ';
        
        $t = explode(" ", $row['DateTime']);
        $arr['time'] = substr($t[1], 0, 5);
        $arr['epwnumo'] = $row['epwnumo'];
        $arr['tilefwno'] = $row['tilefwno'];
        
        $od = explode(",", $row['odos']);
        $arr['odos'] = $od[0];
              
        $temp = $row['posotita']."x".$row['perigrafi'];
    }
}


if (strlen($temp) > 1){
	$arr['proionta'] = $temp;
    array_push($data["ParageliesData"],$arr);		
}
  
$jsonarr = json_encode($data);
print $jsonarr;

?>