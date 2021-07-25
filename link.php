<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if ( isset($_SESSION["loggedin"]) ) {
	require_once ('incl/session.control.php');
	if ( check_session_timeout() ) {
	  $_SESSION['lo_reason'] = "timeout";
     header("location: logout.php");		
	}
}

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    //header("location: login.php");
    header("location: index.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>linkSystem - yoursite.123 - Links</title>
	 <link rel="stylesheet" type="text/css" href="styles/styles.css" />
</head>
<body>
    <div class="userlogin">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
 	   <p>
 	       <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
   	     <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    	</p>
    	Timeout: <?php echo date('Y-m-d H:i:s', $_SESSION["timeout"]); ?><br>
    </div>
	Nu aber content bei die Fische!<br />
    <?php
    	require_once('incl/functions.php');
    	showLinks();
    ?>
</body>
</html>