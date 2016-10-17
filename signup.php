<?php require('connection.php');?>
<?php
    session_start();
    $firstname;
    $lastname;
    $password;
    $dbName ='grocerylist';

    if($_POST['firstname'])
        $firstname = $_POST['firstname'];
    else
        echo "First name field is empty";
    if($_POST['lastname'])
        $lastname = $_POST['lastname'];
    else
        echo "Last name field is empty";
    if($_POST['password'])
        $password = $_POST['password'];
    else
        echo "Password field is empty";

    mysqli_select_db($conn, $dbName)or die("Cannot select DB");
    $sql = "INSERT INTO users (firstname, lastname, password) VALUES ('".$firstname."','".$lastname."','".$password."')";

    $query = mysqli_query($conn, $sql) or die("Wrong insert");

    if($query){
        if(!$firstname)
            $_SESSION['name']= $firstname;
        else
            echo "Name field is null";
        header('Location: index.php');
        //var_dump($_SESSION);
    }
    else{
        echo "Error with adding user";
    }

?>
