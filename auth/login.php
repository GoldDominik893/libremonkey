<?php
session_start();
$r_msg = $_GET['r'] ?? "";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../styles/main.css">
<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body class="loginbg-color">
<ul>
  <li><a href="../">LibreMonkey</a></li>
</ul>


<div class="loginbg">
<h1 class="center">Login</h1>
    <div class="center-container">
        <form method="post" action="loginsql.php">
        <?php if ($r_msg == "password_incorrect") { ?>
                The user or password is incorrect.<br>
            <?php } ?>
            <label for="username"><b>Username</b></label><br>
            <input class="loginform" type="text" placeholder="Enter Username" name="username" id="username" required><br>
            <label for="password"><b>Password</b></label><br>
            <input class="loginform" type="password" placeholder="Enter Password" name="password" id="password" required>

            <p>Don't have an account yet? <a href="signup.php">Signup</a></p>

            <button type="submit" class="registerbtn">Let me in</button>
        </form>
    </div>
</div>

</body>
</html>