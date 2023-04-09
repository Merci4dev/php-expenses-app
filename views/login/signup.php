<!-- Display the user signup form  -->
<!-- ==================================================== -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
    <title>Document</title>
</head>
<body>
    <?php require 'views/header.php'; ?>
    <?php $this->showMessages();?>

    <div id="login-main">

        <!-- Set the base url 'URL' -->
        <form action="<?php echo constant('URL'); ?>signup/newUser" method="POST">
        <div></div>
            <h2>Sign Up</h2>

                <label for="username">Username</label>
                <input type="text" name="username" id="username">

                <label for="password">Password</label>
                <input type="text" name="password" id="password">
                
                <input type="submit" value="Create Account" />

            <p>
                Have you already an account? <a href="<?php echo constant('URL'); ?>">Sign In</a>
            </p>
        </form>
    </div>
</body>
</html>