<?php

session_start();

include_once('db.php');

$errors = array();

if (isset($_POST['signin'])) {
    // receive all input values from the form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $retyped_password = $_POST['retyped_password'];

    // form validation: ensure that the form is correctly filled ...
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if ($password !== $retyped_password) {
        array_push($errors, "Passwords must match!");
    }


    if (mysqli_num_rows($username) > 0) {
        $name_error = "Sorry... username already taken";
    } else if (mysqli_num_rows($email) > 0) {
        $email_error = "Sorry... email already taken";
    } else {
        $query = "INSERT INTO users (username, email, password) 
      	    	  VALUES ('$username', '$email', '" . md5($password) . "')";
        $results = mysqli_query($conn, $query);
        header("Location: login.php");
        exit;
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="assets/CSS/style_register.css">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/twitter-icon-18-256.png">
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
    <title>Index Page</title>
</head>
<body id = "body">
<header>
    <div>
        <img src="assets/images/twitter-icon-18-256.png" class = "tweet-image">
    </div>
</header>




<div class="col-md">
    <div id="logbox">
        <form id="signup" method="post" action = "register.php">
            <h1>Create an Account</h1>
            <input name="username" type="text" placeholder="What's your username?" pattern="^[\w]{3,16}$" autofocus="autofocus" required="required" class="input pass"/>
            <input name="email" type="email" placeholder="Email address" class="input pass"/>
            <input name="password" type="password" placeholder="Choose a password" required="required" class="input pass"/>
            <input name="retyped_password" type="password" placeholder="Confirm password" required="required" class="input pass"/>
            <input type="submit" name="signin" value="Sign Up" class="inputButton">

            <div class="text-center">
                Already have an account? <a href="login.php" name="user-sign-in" id="login_id">Log In</a>
            </div>
        </form>
    </div>


</body>
</html>