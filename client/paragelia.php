<?php
require ("../include/config.php");

// Initialize the session
session_start();
 
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}

$myusername = htmlspecialchars($_SESSION['username']); 
$times = get_times($db);
$_SESSION['times'] = $times;  


   
if($_SERVER["REQUEST_METHOD"] == "POST") {

	// username and password sent from form 
	$c = check_paragelia($_POST);
	if ($c == 0){ ?>
		<script> alert("Δεν έχετε επιλέξει κανένα προιόν."); </script> 
<?php	
	}
	else
	{ 
		$sum = kostos($_POST, $times);
		$_SESSION['kostos'] = $sum;  
		$_SESSION['paragelia'] = $_POST;
	   	header("location: oloklirwsi_paragelias.php");
	} 
}

?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Επιλογή προϊόντων</title>
    <link rel="stylesheet" href="css/shopping_cart.css" media="screen" title="no title" charset="utf-8">
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
				<center>        Επιλογή προϊόντων   </center>
			</div>

			<!-- Product #1 -->
			<div class="item">
				<div class="image">
					<img src="../images/greek-coffee.png" alt="" height="80" width="100"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $times[0]['perigrafi']; ?></span>
					<span></span>			
				</div>

				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki1" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>
				<div class="total-price"><?php echo $times[0]['timi'] ?>&euro;</div>
			</div>

			<!-- Product #2 -->
			<div class="item">
				<div class="image">
					<img src="../images/frapes.jpg" alt="" height="100" width="80"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $times[1]['perigrafi']; ?></span>
					<span></span>
				</div>

				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki2" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>
				<div class="total-price"><?php echo $times[1]['timi'] ?>&euro;</div>
			</div>

			<!-- Product #3 -->
			<div class="item">
				<div class="image">
					<img src="../images/espresso.png" alt="" height="80" width="100"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $times[2]['perigrafi']; ?></span>
					<span></span>
				</div>

				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki3" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>
				<div class="total-price"><?php echo $times[2]['timi'] ?>&euro;</div>
			</div>


			<!-- Product #4 -->
			<div class="item">
				<div class="image">
					<img src="../images/cappuccino.jpeg" alt="" height="100" width="80"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $times[3]['perigrafi']; ?></span>
					<span></span>
				</div>

				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki4" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>

				<div class="total-price"><?php echo $times[3]['timi'] ?>&euro;</div>
			</div>	
			
			<!-- Product #5 -->
			<div class="item">
				<div class="image">
					<img src="../images/filter-coffee.jpg" alt="" height="80" width="100"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $times[4]['perigrafi']; ?></span>
					<span></span>
				</div>

				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki5" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>
				<div class="total-price"><?php echo $times[4]['timi'] ?>&euro;</div>
			</div>			

			<!-- Product #6 -->
			<div class="item">
				<div class="image">
					<img src="../images/tiropita.jpg" alt="" height="100" width="80"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $times[5]['perigrafi']; ?></span>
					<span></span>
				</div>

				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki6" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>
				<div class="total-price"><?php echo $times[5]['timi'] ?>&euro;</div>
			</div>	
			
			<!-- Product #7 -->
			<div class="item">
				<div class="image">
					<img src="../images/spanakopita.jpg" alt="" height="100" width="80"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $times[6]['perigrafi']; ?></span>
					<span></span>
				</div>

				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki7" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>
				<div class="total-price"><?php echo $times[6]['timi'] ?>&euro;</div>
			</div>
			
			<!-- Product #8 -->
			<div class="item">
				<div class="image">
					<img src="../images/koulouri.jpg" alt="" height="70" width="70"/>
				</div>

				<div class="description">
					<span></span>
					<span><?php echo $times[7]['perigrafi']; ?></span>
					<span></span>
				</div>

				<div class="quantity">
					<button class="plus-btn" type="button" name="button">
						<img src="../images/plus.svg" alt="" />
					</button>
					<input type="text" name="Prosthiki8" value="0">
					<button class="minus-btn" type="button" name="button">
						<img src="../images/minus.svg" alt="" />
					</button>
				</div>

			<div class="total-price"><?php echo $times[7]['timi'] ?>&euro;</div>
		  </div>	
		  <!-- Product #9 -->
		  	<div class="item">
				<div class="image">
			  		<img src="../images/tost.jpg" alt="" height="70" width="70"/>
				</div>

				<div class="description">
			  		<span></span>
					  <span><?php echo $times[8]['perigrafi']; ?></span>
					  <span></span>
				</div>

				<div class="quantity">
				  <button class="plus-btn" type="button" name="button">
					<img src="../images/plus.svg" alt="" />
				  </button>
				  <input type="text" name="Prosthiki9" value="0">
				  <button class="minus-btn" type="button" name="button">
					<img src="../images/minus.svg" alt="" />
				  </button>
				</div>

			<div class="total-price"><?php echo $times[8]['timi'] ?>&euro;</div>
		  </div>
		  <!-- Product #10 -->
		  <div class="item">
				<div class="image">
			  		<img src="../images/cake.jpg" alt="" height="70" width="70"/>
				</div>

				<div class="description">
				  <span></span>
				  <span><?php echo $times[9]['perigrafi']; ?></span>
				  <span></span>
				</div>

				<div class="quantity">
				  <button class="plus-btn" type="button" name="button">
					<img src="../images/plus.svg" alt="" />
				  </button>
				  <input type="text" name="Prosthiki10" value="0">
				  <button class="minus-btn" type="button" name="button">
					<img src="../images/minus.svg" alt="" />
				  </button>
				</div>

				<div class="total-price"><?php echo $times[9]['timi'] ?>&euro;</div>
		  	</div>			
		</div>
		<center><button class="but_submit">Συνέχεια</button></center>
	</form>
	<br><br>


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











