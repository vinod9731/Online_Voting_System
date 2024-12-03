<?php 
include 'connect.php';

if(isset($_POST['signUp'])){
    $username = $_POST['fName'];
    $email = $_POST['email'];
    $phone_number = $_POST['tPhone'];
    $password = $_POST['password'];
    $password = md5($password);
    $user_role = "voter"; // Default role is 'voter'

    // Check if the email already exists
    $checkEmail = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "Email Address Already Exists!";
    } else {
        $insertQuery = "INSERT INTO user (username, email, phone_number, password, user_role)
                        VALUES ('$username', '$email', '$phone_number', '$password', '$user_role')";
        if($conn->query($insertQuery) === TRUE){
            header("Location: login.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
    
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['user_role'] = $row['user_role'];
        $_SESSION['user_id'] = $row['id'];
        
        // Redirect based on user role
        if($row['user_role'] == 'voter'){

          //  $_SESSION['key'] = "voterskey";
            header("Location: voters/index.php");
        } elseif($row['user_role'] == 'Admin'){

         //   $_SESSION['key'] = "Adminkey";
            header("Location: adminDash.php?homepage=1");
        } else {
            echo "Invalid User Role!";
        }
        exit();
    } else {
        echo "Not Found, Incorrect Email or Password";
    }
}
?>
