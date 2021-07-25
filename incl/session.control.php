<?php
function check_session_timeout () {
	
	include_once ('config.php');	
	
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		return true;
	}

	if ( !isset ($_SESSION['timeout']) || $_SESSION['timeout'] < time() ) {
		return true;	
	}
	// if no timeout, then set new timer
	// 10 * 60 = 10 Minutes
	$_SESSION['timeout'] = time() + $timeoutminutes;
	return false;	
}

?>