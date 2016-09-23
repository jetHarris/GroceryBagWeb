<?php
$username= "root";
$password="onomatopeia";
$host="localhost";
$dbName ="grocerylist";

$conn = mysqli_connect( $host, $username, $password, $dbName);
mysqli_select_db($conn, $dbName);
/* if($conn->connect_error){
	die("Connection failed: " .$conn->connect_error );
	echo "Error Connecting <br>";
}
else
	echo "Connected to MySQL <br>"; */

?>
