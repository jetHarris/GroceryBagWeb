<?php require('connection.php');?>

<?php
session_start();

$firstname='';
$lastname='';
$password='';
$password='';
$dbName = 'grocerylist';

//var_dump($_POST);
if(isset($_POST['firstname'])){
    if(empty($_POST['firstname']) || empty($_POST['lastname'])|| empty($_POST['password'])){
        echo 'Names or Password is empty!!';
    }else{
        $firstname = mysqli_escape_string($conn, $_POST['firstname']);
        $lastname= mysqli_escape_string($conn, $_POST['lastname']);
        $password = mysqli_escape_string($conn, $_POST['password']);
    }
    if($firstname && $password){
        mysqli_select_db($conn, $dbName) or die("Could not find the database");
        $query = mysqli_query($conn, "Select * from users where firstname='$firstname' AND lastname='$lastname' ") or die("Bad Select statement");
        $numrows = mysqli_num_rows($query);// or die("done messed up");
        if($numrows !==0){
           while($row = mysqli_fetch_assoc($query)){
               print_r($row);
               $dbFirst= $row['firstname'];
               $dbLast = $row['lastname'];
               $dbPass = $row['password'];
               $user_id = $row['id'];
           }
           if($firstname == $dbFirst && $lastname==$dbLast && $password=$dbPass){
               echo "You are logged in";
               $_SESSION['name']= $firstname;
               $_SESSION['user_id'] = $user_id;
               echo "<br>Welcome ".$_SESSION['name']."!";
               header('Location: index.php');
               //echo "<br><a href='index.php'>Redirect to Index Page</a>";
           }else{
               echo "Your credentials do not match";
               echo "<br><a href='login.html'>Try and Sign In Again</a>";
           }
        }//end numrows
        else if($numrows ==0){
            echo "User does not exist, please go Sign Up";
            echo "<br><a href='signup.html'>Sign up</a>";
        }
    }
    else{
        echo "<br>That User does not exist";
        echo "<br>Please Register a New USer";
    }
}//end $_POST['submit']
?>
