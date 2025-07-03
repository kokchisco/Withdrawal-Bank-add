<?php
	$conn = mysqli_connect('localhost', 'alutotra_betall1', 'alutotra_betall1', 'alutotra_betall1');
	
	if (!$conn) {
		echo "Error: " . mysqli_connect_error();
		exit();
	}
	
	date_default_timezone_set("Asia/Kolkata"); 
?>