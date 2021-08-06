<?php

function showLinks() {
	// Include config file
	include "incl/config.php";
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// SQL to be executed
	$sql = "SELECT link_group_name, lid, link_uri, link_text, group_name FROM $TABLINK WHERE user_id = ? order by group_name, link_text";

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
	    printf("<tr><td><a href=\"%s\">%s</a></td></tr>\n", $row["link_uri"], $row["link_text"]);
	}

	mysqli_stmt_free_result($stmt);

	mysqli_stmt_close($stmt);

}

function showInsert() {
	
	?>
	<form action="link.php" method="post">
		<table>
		<tr><th><label for="linkGroup">Group:    </label></th>		<td><input type="text" size="30" name="linkGroup"  value="general"></td></tr>		
		<tr><th><label for="linkUri"  >Link:     </label></th>		<td><input type="text" size="50" name="linkUri"    value="https://www.heise.de"></td></tr>		
		<tr><th><label for="linkText" >Link-Text:</label></th>		<td><input type="text" size="50" name="linkText"   value="Heise-Verlag"></td></tr>		
		</table>
		<input type="hidden" name="action" value="insert">
		<input type="submit" value="create">
	</form>
	<?php
}

function insertLink() {
	// Include config file
	include "incl/config.php";
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// SQL to be executed
	$sqlInsert = "INSERT INTO $TABLINK (user_id, link_group_name, link_uri, link_text, group_name) value (?, ?, ?, ?, ?)";
	/* create a prepared statement */
	$stmt = $obj_mySqliConn->prepare($sqlInsert);

   // Set parameters
	$param_username  = $_SESSION['username'];
	$param_linkGroup = $_REQUEST['linkGroup'];
	$param_linkUri   = $_REQUEST['linkUri'];
	$param_linkText  = $_REQUEST['linkText'];
	$param_linkGroupName = "gen";        // to group the groups... e.g. gen, work, private ... for later usage

	/* bind parameters for markers (markers = the "?" in the sql-statement) */
	$stmt->bind_param("sssss", $param_username, $param_linkGroupName, $param_linkUri, $param_linkText, $param_linkGroup);

	/* execute query */
	$stmt->execute();

	mysqli_stmt_close($stmt);

}


?>