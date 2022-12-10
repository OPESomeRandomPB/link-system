<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (isset($_SESSION["loggedin"]) && isset($_SESSION['system']) && $_SESSION['system'] === "linksystem" ) {

    require_once ('incl/session.control.php');
    if (check_session_timeout()) {
        $_SESSION['lo_reason'] = "timeout";
        header("location: logout.php");
    }
}

if (   ! isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true 
    || ! isset($_SESSION['system'])   || $_SESSION['system'] !== "linksystem" ) {
    //header("location: login.php");
    header("location: index.php");
    exit;
} else {

if ( isset($_REQUEST["action"]) && $_REQUEST["action"] == "insert" ){
    	require_once('incl/functions.php');
		insertLink();
    $_REQUEST["action"] == "show";
}
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
         <br>
         <form action="link.php" method="post">
       		<input type="hidden" name="action" value="show">
       		<input type="submit" value="refresh">
       	</form>

    	</p>
    	Timeout: <?php echo date('Y-m-d H:i:s', $_SESSION["timeout"]); ?><br>
    </div>
	now let's put some butter to the fishes!<br />
    <div class="insertTopRight">
    holla
    <?php
        require_once('incl/functions.php');
    	showInsert();
    	menuToEditMode();
    	?>
    </div>


    <?php
        if ( $_POST["action"] == "editGroupName" ) {
            editGroup();
            ;
        } elseif ($_POST["action"] == "editEntry") {
            editEntry();
            ;
        } elseif ($_POST["action"] == "deleteEntry") {
            deleteEntry();
            ;
        } else {
            require_once('incl/functions.php');
    	showLinks();
        }
    ?>
<br />thanks for using <?php print $_SESSION["system"]; ?> 
</body>
</html>
