<?php
	//page call string: www.homeinfo.dk/report_attendant.php?imei=&guard_lat=&guard_long=
	
	//Include database connection details
	require_once('includes/configure.php');
	
	
	//Sanitize the POST values
	//$basestation_sn = clean($_GET['basestation_sn']);
	$imei = $_POST['imei'];
	$guard_lat = $_POST['guard_lat'];
	$guard_long = $_POST['guard_long'];
	
	
	//Function to sanitize values received from the form. Prevents SQL injection
	if (!get_magic_quotes_gpc()){
		$imei = addslashes($imei);
		$guard_lat = addslashes($guard_lat);
		$guard_long = addslashes($guard_long);
		}
	
	//Input Validations	
	$missing_input = false;
	
	if($imei == '') {
		echo "imei missing <br>";
		$missing_input = true;
		}
	
	if($guard_lat == '') {
		echo "latitude missing <br>";
		$missing_input = true;
		}	
		
	if($guard_long == '') {
		echo "longitude missing <br>";
		$missing_input = true;
		}		
		
	if($missing_input == true) {
		exit;
		}
	
	
	//Connect to mysql server
	@ $db = new mysqli(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD, DB_DATABASE);
	
	if (mysqli_connect_errno()) {
		echo 'Error: Could not connect to database.';
		exit;
		}
	//else
	//	{
	//	echo "Connected to database.<br>";
	//	}


	//make query
	$query = "INSERT INTO PGuard_location(imei,guard_lat, guard_long) VALUES('$imei','$guard_lat', '$guard_long')";
	$result = $db->query($query);
	
	//tell how the insert went
	if ($result) {
		echo "Parking attendant reported";
		} 
	else {
		echo "An error has occurred. While inserting data into database";
		}
	
	//free result and close conection
	$result->free();
	$db->close();
	
?>