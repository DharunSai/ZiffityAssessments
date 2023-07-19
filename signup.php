<?php
session_start();
require_once 'DB.php';
require_once 'User.php';

if (User::isLoggedIn()) {
    header("Location: index.php");
    exit();
}

function validateUsername($username) {
    $pattern = '/^[a-zA-Z0-9_]+$/';
    return preg_match($pattern, $username);
}

function validatePassword($password) {
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
    return preg_match($pattern, $password);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (!validateUsername($username)) {
        
        $error = "Username is not valid.";
    } 
    elseif(!validatePassword($password)) {
       
        $error= "Password doesnt satisfy the norms";
    }
    // Perform signup
    elseif (User::isUsernameAvailable($username)) {
       
        if (User::signup($username, $password)) {
            header('Location: index.php');
            $success = "Signup successful! Please login.";
            
        } else {
            $error = "Error while signing up. Please try again.";
        }
    } else {
        $error = "Username is already taken. Please choose a different username.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="signupStyles.css">
    <title>Car Parking Vault - Signup</title>
</head>
<body>
    <h1 style="text-align: center">Signup</h1>
    <div class="container">
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input id="submitBtn" type="submit" value="Signup">
    </form>
    <br>
  
    <?php if (isset($error)) : ?>
        <p style="border: 2px solid red;padding: 2px;"><?php echo $error; ?></p>
    <?php endif; ?>
    <?php if (isset($success)) : ?>
        <p><?php echo $success; ?></p>
    <?php endif; ?>
    </div>
     
    <div class="container-2">
    <p>If you have already signed in...</p>
    <a href="login.php">login</a>
    </div>
</body>
</html>
