<?php
// ====================================
// getMessages
// ====================================
// Gets 10 latest comments from DB 
// and displays them.
//
// Author: Michael Walton
// Updated: 06/06/2013
// ====================================

// connect to the db, include the user session manager
include $_SERVER['DOCUMENT_ROOT'].'/utils/db.php';
include $_SERVER['DOCUMENT_ROOT'].'/utils/user.php';

// db query
$sql = "SELECT m.member_email, m.member_firstname, m.member_lastname, ms.message_content, DATE_FORMAT(ms.message_posted, '%H:%i %W %D %M %Y') AS message_posted
		FROM Messages ms
		INNER JOIN Members m ON ms.member_id = m.member_id
		ORDER BY ms.message_posted DESC
		LIMIT 10;";

// run the query
$result = $pdo->query($sql);

// error handling
if(!$result) die("Error getting messages: " . $pdo->errorInfo()[2]);

// display results if any
if ($result->rowCount() > 0) {
	// create the html for each message directly
	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		echo('							<div>');
		echo('								<p>' . $row['message_posted'] .' - '. $row['member_firstname'] . ' ' . $row['member_lastname'] . '</p>');
		echo('								<p class="focus-content">' . $row['message_content'] . '</p>');
		echo('								<hr>');
		echo('							</div>');
	}	
}else{
	// no messages in db
	echo('<p>No messages have been posted.</p>');
}
?>
