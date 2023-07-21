<?php
session_start();
require_once 'php/DB.php';
require_once 'php/User.php';

if (User::isLoggedIn()) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == 'admin' && $password == 'admin') {
        header('Location: php/admin.php');
    }
    $user = User::login($username, $password);
    if ($user) {

        $_SESSION['u'] = base64_encode(serialize($user));



        header("Location: index.php");
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/loginStyles.css">
    <title>Car Parking Vault - Login</title>
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <input style="margin-left:40%" type="submit" value="Login">
        </form>
        <br>
        <?php if (isset($error)) : ?>
            <p style="border:2px solid red;padding: 2px"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>



    <div class="container-2">
        <p>If you havent signed up</p>
        <a style="text-decoration: none" href="php/signup.php">signup</a>
    </div>
</body>

</html>