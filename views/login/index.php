<!-- loging file. This is the firs file which load in the application  -->
<!-- ==================================================== -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
</head>
<body>
    <?php require 'views/header.php'; ?>
    <?php $this->showMessages();?>
    <div id="login-main">
        <form action="<?php echo constant('URL'); ?>login/authenticate" method="POST">
        <div><?php (isset($this->errorMessage))?  $this->errorMessage : '' ?></div>
            <h2>Sign In</h2>
            
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off">

                <label for="password">Password</label>
                <input type="password" name="password" id="password" autocomplete="off">
                
                <input type="submit" value="Start Sesión" />

            <p>
                Don't you have an account? <a href="<?php echo constant('URL'); ?>signup">Sign Up</a>
            </p>
        </form>
    </div>
</body>
</html>