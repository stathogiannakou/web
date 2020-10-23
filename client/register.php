<?php
// Include config file
require_once '../include/config.php';
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = $telephone_err = "";



// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
	$email = trim($_POST["username"]);
	
    // Validate email
    if(empty($email)){
        $username_err = "Παρακαλώ εισάγετε ένα email.";
    } 
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		$username_err = "Λάθος μορφή email";
	}
	else{
        // Prepare a select statement
        $sql = "SELECT id FROM pelatis WHERE email = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Υπάρχει ήδη λογαριασμός με αυτό το email.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Κάτι πήγε στραβά. Δοκιμάστε ξανά αργότερα.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

	
	
	
	
    // Validate telephone
	$phone_number =trim($_POST['telephone']);
    if(empty($phone_number)){
        $telephone_err = "Παρακαλώ συμπληρώστε το τηλέφωνό σας.";     
    } elseif(!preg_match("/^[0-9]{10}$/", $phone_number)) {
		$telephone_err = "Το τηλέφωνο πρέπει να αποτελείται από 10 ψηφία.";
	}
	
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Παρακαλώ εισάγετε έναν κωδικό.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        $password_err = "Ο κωδικός πρέπει να έχει τουλάχιστον 6 χαρακτήρες.";
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = 'Παρακαλώ επιβεβαιώστε τον κωδικό σας.';     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = 'Ο κωδικός δεν ταυτίζεται.';
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($telephone_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO pelatis (email, tilefwno, password) VALUES (?, ?, ?)";

        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_telephone, $param_password);
            
            // Set parameters
            $param_username = $username;
			$param_telephone = $phone_number;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Κάτι πήγε στραβά. Παρακαλώ δοκιμάστε πάλι αργότερα.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($db);
}
?>
 



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Εγγραφή</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap_v3.3.7.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" type="text/css" href="css/client_register.css">
	<link rel="icon" type="image/gif/png" href="../images/coffee-cup.png">
</head>
<body>
	<center>	
		<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 	
		<div class="wrapper">
			<h2>Εγγραφή</h2>
			<p>Παρακαλώ συμπληρώστε τις πληροφορίες σας για να δημιουργήσετε λογαριασμού.</p>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<label>Email</label>
					<input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
					<span class="help-block"><?php echo $username_err; ?></span>
				</div>   
				<div class="form-group <?php echo (!empty($telephone_err)) ? 'has-error' : ''; ?>">
					<label>Τηλέφωνο</label>
					<input type="text" name="telephone"class="form-control" value="<?php echo $phone_number; ?>">
					<span class="help-block"><?php echo $telephone_err; ?></span>
				</div>   			
				<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					<label>Κωδικός</label>
					<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>
				<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
					<label>Επιβεβαίωση κωδικού</label>
					<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
					<span class="help-block"><?php echo $confirm_password_err; ?></span>
				</div>
				<div class="form-group">
					<center>
						<input id="butt" type="submit" class="btn btn-primary" value="Εγγραφή">
						<input id="reset" type="reset" class="btn btn-default" value="Επαναφορά">
					</center>
				</div>
				<p>Έχετε ήδη λογαριασμό; <a id ="link" href="login.php">Συνδεθείτε εδώ.</a></p>
			</form>
		</div>    
	</center>
</body>
</html>