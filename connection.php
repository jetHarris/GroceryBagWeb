<?php
$username= "root";
$password="j4m6cd781";
$host="localhost";
$dbName ="grocerylist";

//echo("dbName: ".$dbName."<br>");
//echo "In connection <br>";
$conn = mysqli_connect( $host, $username, $password, $dbName) or die("Connection Failed; Check Connection");
mysqli_select_db($conn, $dbName);
/*if($conn->connect_error){
	die("Connection failed: " .$conn->connect_error );
	echo "Error Connecting <br>";
}
else
	echo "Connected to MySQL <br>";
*/
?>