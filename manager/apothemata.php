<?php
require ("../include/config.php");

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	header("location: manager.php");
	exit;
}
	

$myusername = htmlspecialchars($_SESSION['username']); 
$id_kat = get_id_kat($db,$myusername);
$apothemata = get_apothemata($db,$id_kat[0]);
	

if ($_POST['Prosthiki1'] || $_POST['Prosthiki2'] || $_POST['Prosthiki3'] || $_POST['Prosthiki4'] || $_POST['Prosthiki5']){	
	update_apothema($db,$id_kat[0],$_POST,$apothemata);
	$apothemata = get_apothemata($db,$id_kat[0]);
}

?>	



<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8"> 
    <title>Welcome</title>
	<link rel="stylesheet" href="css/manager_shopping_cart.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/manager_apothemata.css">
	<link rel="icon" type="image/gif/png" href="../images/coffee-cup.png">
	<script src="js/jquery.min.js"></script> 
    <meta name="robots" content="noindex,follow" />
</head>
<body>
	<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 	
	<ul> 
		<li><a class="active" href="welcome.php"><img src="../images/back2.png" alt="" height="30" width="30"></a></li>  
		<li class="log_out" style="float:right"><a href="logout.php"><img src="../images/logout.png" alt="" height="30" width="25"> </a></li>
	</ul>		
		
	<form ACTION="" method="post">
		<div class="shopping-cart">
		  <!-- Title -->
			<div class="title">
				<center>        Ενημέρωση αποθεμάτων   </center>
			</div>


			<!-- Snack #1 -->
			<div class="item">
				<div class="image">
					<img src="../images/tiropita.jpg" alt="" height="100" width="80"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $apothemata[0]['perigrafi']; ?></span>
					<span></span>
				</div>
				<div class="total-price"><?php echo $apothemata[0]['posotita'] ?></div>
				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki1" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>
				
			</div>	
			
			<!-- Snack #2 -->
			<div class="item">
				<div class="image">
					<img src="../images/spanakopita.jpg" alt="" height="100" width="80"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $apothemata[1]['perigrafi']; ?></span>
					<span></span>
				</div>
				<div class="total-price"><?php echo $apothemata[1]['posotita'] ?></div>
				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki2" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>
				
			</div>
			
			<!-- Snack #3 -->
			<div class="item">
				<div class="image">
					<img src="../images/koulouri.jpg" alt="" height="70" width="70"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $apothemata[2]['perigrafi']; ?></span>
					<span></span>
				</div>
				<div class="total-price"><?php echo $apothemata[2]['posotita'] ?></div>
				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki3" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>

			
		  </div>	
		  <!-- Snack #4 -->
		  <div class="item">
			<div class="image">
			  <img src="../images/tost.jpg" alt="" height="70" width="70"/>
			</div>

			<div class="description">
			  <span></span>
			  <span><?php echo $apothemata[3]['perigrafi']; ?></span>
			  <span></span>
			</div>
			<div class="total-price"><?php echo $apothemata[3]['posotita'] ?></div>
			<div class="quantity">
			  <button class="plus-btn" type="button" name="button">
				<img src="../images/plus.svg" alt="" />
			  </button>
			  <input type="text" name="Prosthiki4" value="0">
			  <button class="minus-btn" type="button" name="button">
				<img src="../images/minus.svg" alt="" />
			  </button>
			</div>

			
		  </div>
		  <!-- Snack #5 -->
		  <div class="item">
			<div class="image">
			  <img src="../images/cake.jpg" alt="" height="70" width="70"/>
			</div>

			<div class="description">
			  <span></span>
			  <span><?php echo $apothemata[4]['perigrafi']; ?></span>
			  <span></span>
			</div>
			<div class="total-price"><?php echo $apothemata[4]['posotita'] ?></div>
			<div class="quantity">
			  <button class="plus-btn" type="button" name="button">
				<img src="../images/plus.svg" alt="" />
			  </button>
			  <input type="text" name="Prosthiki5" value="0">
			  <button class="minus-btn" type="button" name="button">
				<img src="../images/minus.svg" alt="" />
			  </button>
			</div>

			
		  </div>			
		</div>
			<button class="button" type="submit">Ενημέρωση </button>
		<br><br><br>
	</form>
	

    <script type="text/javascript">
      $('.minus-btn').on('click', function(e) {
    		e.preventDefault();
    		var $this = $(this);
    		var $input = $this.closest('div').find('input');
    		var value = parseInt($input.val());

    		if (value > 1) {
    			value = value - 1;
    		} else {
    			value = 0;
    		}

        	$input.val(value);

    		});

    	$('.plus-btn').on('click', function(e) {
    		e.preventDefault();
    		var $this = $(this);
    		var $input = $this.closest('div').find('input');
    		var value = parseInt($input.val());

    		if (value < 100) {
      		value = value + 1;
    		} else {
    			value =100;
    		}

    		$input.val(value);
    	});

      $('.like-btn').on('click', function() {
        $(this).toggleClass('is-active');
      });
    </script>
	
</body>
</html>


