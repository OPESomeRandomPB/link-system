<?php

function showLinks() {
	// Include config file
	include "incl/config.php";
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// SQL to be executed
	$sql = "SELECT link_group_name, lid, link, comment, group_name FROM $TABLINK WHERE user_id = ? order by group_name, comment";

	/* create a prepared statement */
	$stmt = $obj_mySqliConn->prepare($sql);

   // Set parameters
	$param_username = $_SESSION['username'];

	/* bind parameters for markers (markers = the "?" in the sql-statement) */
	$stmt->bind_param("s", $param_username);

	/* execute query */
	$stmt->execute();

	// get result
	$result = $stmt->get_result();

	// print all
	$oldGroup = "";
	printf ("<table border=\"0\">");
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$NewGroup = $row["group_name"];
		if ( $oldGroup != $NewGroup ) {
			$oldGroup = $NewGroup;
			printf ("<tr><th colspan=\"3\">%s</th>", $row["group_name"] );
		}
	    printf("<tr><td><a href=\"%s\">%s</a></td></tr>\n", $row["link"], $row["comment"]);
	}

	mysqli_stmt_free_result($stmt);

	mysqli_stmt_close($stmt);

}


?>