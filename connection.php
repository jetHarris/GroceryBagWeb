<?php
define (DB_USER, "root");
define (DB_PASS,"");
define (DB_HOST,"localhost");
define (DB_NAME, "grocerylist");

$conn = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME);
mysqli_select_db($conn, $dbName);
/* if($conn->connect_error){
	die("Connection failed: " .$conn->connect_error );
	echo "Error Connecting <br>";
}
else
	echo "Connected to MySQL <br>"; */

?>
