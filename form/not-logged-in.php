<?php
session_start();
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
  <?php 
  if ($_SESSION['logged_in'] == true) {
   header('Location: ../');
   exit(0);
  } ?>
</ul>


<div class="loginbg">
<h1 class="center">Client Area</h1>
    <div class="center-container2 whitebg">
        401 Unauthorised - You may not fill out this form because you are not logged in.<br>
        <a style="color: black;" href="../auth/login.php?formid=<?php echo $_GET['formid']; ?>">Login / Signup</a>
    </div><br>
</div>
</body>
</html>