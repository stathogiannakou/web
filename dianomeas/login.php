<?php
// Include config file
require_once '../include/config.php';
session_start();

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
$_SESSION['wrario'] = "enarksi"; 


// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = 'Please enter username.';
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        $password_err = 'Παρακαλώ συμπληρώστε τον κωδικό σας.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password FROM dianomeas WHERE username = ?";
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)){
	
						$param_password = password_hash($password, PASSWORD_DEFAULT);
						$hash = password_hash($password, PASSWORD_DEFAULT);
                        if(password_verify($hashed_password, $hash)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            $_SESSION['username'] = $username;      
                            header("location: welcome.php");
                        } 
						else{
                            // Display an error message if password is not valid
                            $password_err = 'Ο κωδικός δεν είναι σωστός.';
                        }
                    }
                } 
				else{
                    // Display an error message if username doesn't exist
                    $username_err = 'Δεν βρέθηκε λογαριασμός με αυτό το όνομα χρήστη.';
                }
            } 
			else{
                echo "Κάτι πήγε στραβά. Δοκιμάστε ξανά αργότερα.";
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
    <title>Σύνδεση</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap_v3.3.7.css">
	<link rel="stylesheet" type="text/css" href="css/dianomeas_login.css"> 
</head>
<body>
	<center>	
		<span class="logo"><a href="welcome.php"><img src="../images/2cca12aa-b167-4bc3-9bbc-d9cf4067513b.png" alt=""> </a></span> 		
		<div class="wrapper">
			<h2>Σύνδεση</h2>
			<p>Συμπληρώστε τα στοιχεία σας για να συνδεθείτε.</p>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<label>Όνομα χρήστη</label>
					<input type="text" name="username"class="form-control" value="<?php echo $username; ?>">
					<span class="help-block"><?php echo $username_err; ?></span>
				</div>    
				<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					<label>Κωδικός</label>
					<input type="password" name="password" class="form-control">
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>
				<div class="form-group">
					<center>  <input id="butt" type="submit" class="btn btn-primary" value="Σύνδεση">    </center>
				</div>
			</form>
		</div>   
	</center>		
</body>
</html>