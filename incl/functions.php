<?php

function showLinks() {
	// Include config file
	include "incl/config.php";
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// SQL to be executed
	if ( $_POST["action"] == "toEditMode" ) {
	    // in case of "edit" -> one wants to see upper and lower case groups
	    $sql = "SELECT link_group_name, lid, link_uri, link_text, group_name FROM $TABLINK WHERE user_id = ? order by group_name COLLATE latin1_bin, link_text";
	} else {
	    // in case of "no edit" -> one does not want to see upper and lower case groups
	    $sql = "SELECT link_group_name, lid, link_uri, link_text, group_name FROM $TABLINK WHERE user_id = ? order by group_name, link_text";
	}

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

	    if ( $_POST["action"] == "toEditMode" ) {
	        // in case of "edit" -> one wants to see upper and lower case groups
	        $NewGroup = $row["group_name"];
	    } else {
	        // in case of "no edit" -> one does not want to see upper and lower case groups
	        $NewGroup = strtoupper( $row["group_name"]);
	    }
	    
	    
		if ( $oldGroup != $NewGroup ) {
			$oldGroup = $NewGroup;
			printf ("<tr><th>%s", htmlspecialchars($row["group_name"] ) );
			if ( $_POST["action"] == "toEditMode") {
			    ?>
			    </th><th>
				<form action="link.php" method="post">
					<input type="hidden" name="action" value="<?php print htmlspecialchars($row["group_name"]); ?>">
					<input type="hidden" name="action" value="editGroupName">
					<input type="submit" value="edit group">
				</form>
				<?php
			}			
			print "</th>";
		}
	    printf("<tr><td><a href=\"%s\">%s</a>\n", htmlspecialchars($row["link_uri"] ), htmlspecialchars($row["link_text"] ) );
	    if ( $_POST["action"] == "toEditMode") {
	        ?>
			    </td><td>
			<form action="link.php" method="post">
				<input type="hidden" name="action" value="<?php print $row["LID"]; ?>">
				<input type="hidden" name="action" value="editEntry">
				<input type="submit" value="edit entry">
			</form>
			    </td><td>
			<form action="link.php" method="post">
				<input type="hidden" name="action" value="<?php print $row["LID"]; ?>">
				<input type="hidden" name="action" value="deleteEntry">
				<input type="submit" value="delete entry">
			</form>
			
			<?php
			print "</td></tr>";
	    }
	}

	mysqli_stmt_free_result($stmt);

	mysqli_stmt_close($stmt);

}

function showInsert() {

	?>
	<form action="link.php" method="post">
		<table>
		<tr><th><label for="linkGroup">Group:    </label></th>		<td><input type="text" size="30" name="linkGroup"  placeholder="general"></td></tr>
		<tr><th><label for="linkUri"  >Link:     </label></th>		<td><input type="text" size="50" name="linkUri"    placeholder="https://www.heise.de"></td></tr>
		<tr><th><label for="linkText" >Link-Text:</label></th>		<td><input type="text" size="50" name="linkText"   placeholder="Heise-Verlag"></td></tr>
		</table>
		<input type="hidden" name="action" value="insert">
		<input type="submit" value="create">
	</form>
	<?php
}

function menuToEditMode()
{
    if ( $_POST["action"] != "toEditMode" ) {
    ?>
        <form action="link.php" method="post">
       		<input type="hidden" name="action" value="toEditMode">
       		<input type="submit" value="to edit mode">
		</form>
	<?php } else { ?>
        <form action="link.php" method="post">
       		<input type="hidden" name="action" value="noEditMode"> 
       		<input type="submit" value="exit edit mode">
       	</form>
	<?php
    }
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
