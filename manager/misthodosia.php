<?php
require ("../include/config.php");

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: manager.php");
  exit;
}


$now = getdate();
// echo "<pre>"; print_r($now); echo "</pre>";

	
function createXMLfile($managerArray, $dianomeaArray, $minas, $etos)
{
	$filePath = 'misthodosia.xml';
	$dom     = new DOMDocument('1.0', 'utf-8'); 
	
	$root = $dom->createElement('xml');  
	
		
	$header = $dom->createElement('header');   
  	$transactions = $dom->createElement('transaction');  
	$period = $dom->createElement('period');  
	$period->setAttribute("month", "$minas");
	$period->setAttribute("year", "$etos");		
	

   	$transactions->appendChild($period);
   	$header->appendChild($transactions);
   	$root->appendChild($header);	
	
	$body = $dom->createElement('body');  

	$employees = $dom->createElement('employees');  

	$count = count($managerArray);
	

	 for($i=0; $i<$count; $i++){	 
		 
     $managerOnoma = $managerArray[$i]['onoma_upeuthunou'];                      

     $managerEpwnumo = $managerArray[$i]['epwnumo_upeuthunou'];                     

     $managerAmka = $managerArray[$i]['amka'];                            

	 $managerAfm = $managerArray[$i]['afm'];                             
		 
     $managerIban = $managerArray[$i]['iban'];                           

     $managerAmmount = 800 + $managerArray[$i]['tziros']*0.02;                                       

     $employee = $dom->createElement('employee');                      

     $firstName = $dom->createElement('firstName', $managerOnoma);             
     $employee->appendChild($firstName); 

     $lastName = $dom->createElement('lastName', $managerEpwnumo);               
     $employee->appendChild($lastName); 

     $amka = $dom->createElement('amka', $managerAmka); 
     $employee->appendChild($amka); 

     $afm = $dom->createElement('afm', $managerAfm); 
     $employee->appendChild($afm); 
     
     $iban = $dom->createElement('iban', $managerIban); 
     $employee->appendChild($iban);
	
	 $ammount = $dom->createElement('ammount', $managerAmmount); 
     $employee->appendChild($ammount);	 
 
     $employees->appendChild($employee);

   }
	
	 $count = count($dianomeaArray);
     
	 for($i=0; $i<$count; $i++){
     
	 $a = $dianomeaArray[$i]['hours']*5 + $dianomeaArray[$i]['km']*0.1; 	 
		 
     $dianomeaOnoma =  $dianomeaArray[$i]['onoma'];                     

     $dianomeaEpwnumo = $dianomeaArray[$i]['epwnumo'];                      

     $dianomeaAmka = $dianomeaArray[$i]['amka'];                           

	 $dianomeaAfm = $dianomeaArray[$i]['afm'];                          
		 
     $dianomeaIban = $dianomeaArray[$i]['iban'];                           

     $dianomeaAmmount = $a;                                         

     $employee = $dom->createElement('employee');                     

     $firstName = $dom->createElement('firstName', $dianomeaOnoma);             
     $employee->appendChild($firstName); 

     $lastName = $dom->createElement('lastName', $dianomeaEpwnumo);               
     $employee->appendChild($lastName); 

     $amka = $dom->createElement('amka', $dianomeaAmka); 
     $employee->appendChild($amka); 

     $afm = $dom->createElement('afm', $dianomeaAfm); 
     $employee->appendChild($afm); 
     
     $iban = $dom->createElement('iban', $dianomeaIban); 
     $employee->appendChild($iban);
	
	 $ammount = $dom->createElement('ammount', $dianomeaAmmount); 
     $employee->appendChild($ammount);	 
 
     $employees->appendChild($employee);

   }
	
	$body->appendChild($employees);	
	$root->appendChild($body); 	
	$dom->appendChild($root); 
	
	$dom->save($filePath); 	
 } 	




if($_SERVER["REQUEST_METHOD"] == "POST"){

	$minas = $_POST['month'];	
	$etos = $_POST['year'];	
	$managerArray = get_tziro_katastimatwn($db, $minas, $etos); 	   
	$dianomeaArray = get_wres_km_mina_dianomewn($db, $minas, $etos);	
   	
	createXMLfile( $managerArray, $dianomeaArray,  $minas, $etos);
}

?>





<html>
<head>
	<meta charset="UTF-8">
    <title>Μισθοδοσία</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap_v3.3.7.css">
	<link rel="stylesheet" type="text/css" href="css/manager_misthodosia.css">
	<link rel="icon" type="image/gif/png" href="../images/coffee-cup.png">
</head>
<body>
	<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 	
	<ul> 
		<li><a class="active" href="welcome.php"><img src="../images/back2.png" alt="" height="30" width="30"></a></li>  
		<li class="log_out" style="float:right"><a href="logout.php"><img src="../images/logout.png" alt="" height="30" width="25"> </a></li>
	</ul>						
	<center>
		<br><br><br><br><br>
	
		<div class="wrapper">
			<h2>Μισθοδοσία</h2>
			<br><br><br><br>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="form-group">
					<label>Μήνας</label>
					<input type="number" name="month" class="form-control" min="1" max="12" value="<?php echo $now['mon']; ?>">
				</div>    
				<div class="form-group">
					<label>Έτος</label>
					<input type="number" name="year" class="form-control" min="2000" max="<?php echo $now['year']; ?>" value="<?php echo $now['year']; ?>">
				</div>
				<div class="form-group">
					<input id="butt" type="submit" class="btn btn-primary" value="Εξαγωγή">
				</div>
			</form>
		</div>    
	</center>	

</body>
</html> 