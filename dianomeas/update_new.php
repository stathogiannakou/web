<?php
require_once '../include/config.php';

$dianomea_id = $_GET['id'];

  
$data_paragelias = get_data_paragelias($db, $dianomea_id);  

// echo "<pre>"; print_r($data_paragelias); echo "</pre>";

if(!(empty($data_paragelias)))
	update_dianomea_miDiathesimos($db, $dianomea_id);
		

$jsonarr = json_encode($data_paragelias);
print $jsonarr;

?>