<?php
session_start();
if ($_SESSION['logged_in'] == true) {
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../styles/main.css">
<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<ul>
  <li><a href="../">LibreMonkey</a></li>
  <?php 
  if ($_SESSION['logged_in'] == true) { ?>
   <li style="float:right"><div class="currentuser"><?php echo $_SESSION['logged_in_user']; ?></div></li>
   <li style="float:right"><a href="../logout.php">Logout</a></li>
  <?php } ?>
</ul>


<div class="loginbg">
<h1 class="center">Client Area</h1>
    <div class="center-container2 whitebg">
        <a class="button-form" style="color: black;" href="createform.php">Create a form</a>
        <h1 class="no-margin">All of your forms:</h1><br>
        <p class="no-margin">You don't have any forms yet! <a href="createform.php" style="color: black;">Create one</a></p>
    </div>
</div>
</body>
</html>
<?php
} else { 
    header('Location: ../');
}
?>