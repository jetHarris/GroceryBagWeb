<?php require('connection.php');?>
<?php
    session_start();
    echo "inside signup";
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];
    $dbName ='grocerylist';

    mysqli_select_db($conn, $dbName)or die("Cannot select DB");
    $sql = "INSERT INTO users (firstname, lastname, password) VALUES ('".$firstname."','".$lastname."','".$password."')";

    $query = mysqli_query($conn, $sql) or die("Wrong insert");

    if($query){
        $_SESSION['name']= $name;
        //header('Location: index.php');
        var_dump($_SESSION);
    }
    else{
        echo "Error with adding user";
    }

?>
