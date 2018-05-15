<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Connect to MySQL */
$conn = new mysqli( "localhost", "root", "123456", "sochi" );

// Check connection
if ($conn->connect_error) {
    echo 'Error: ' . $conn->connect_error . '<br />';
	die();
};

echo "Connected.<br />";

$conn->set_charset("utf8");

$sql = "SELECT * FROM field_data_body";
$results = $conn->query( $sql );
	
while($row = $results->fetch_assoc()) {
	// echo $row['body_value'];
	
	// get title
	$sql_title = "SELECT title, changed FROM node WHERE vid=" . $row['entity_id'] . " LIMIT 1";
	$results_title = $conn->query( $sql_title );
	$title = $results_title->fetch_assoc();
	
	$fp = fopen( $row['entity_id'].'.html', 'w');
	fwrite($fp, '<html><head><meta charset="utf-8"><title>' . $title['title'] . '</title></head><body><h1>' . $title['title'] . '</h1><p><date>' . date( 'Y-m-d', $title['changed'] ) . '</date></p>'.$row['body_value'].'</body></html>');
	fclose($fp);
	
	echo 'File ' . $row['entity_id'] . '.html created.<br />';
};

$conn->close();