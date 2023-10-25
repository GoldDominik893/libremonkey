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
<h1 class="center">Client Area - Create a form</h1>
    <div class="center-container2 whitebg">
        <h1 class="no-margin">Form Creation</h1><br>
        <p class="no-margin"><a href="createform.php?r=test" style="color: black;">TEST(this will create a blank form)</a></p>
    </div>
</div>
</body>
</html>
<?php
if ($_GET['r'] == 'test') {
    include('../config.php');

    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $creator_username = $_SESSION['logged_in_user'];
    $title = "Untitled Form";
    $description = "This is a description";
    $status = "inactive";
    $form_url = "https://example.com/form";
    $response_count = 0;
    
    $sql = "INSERT INTO forms (creator_username, title, description, status, form_url, response_count) VALUES ('$creator_username', '$title', '$description', '$status', '$form_url', $response_count)";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    header('Location: createform.php');
}
} else { 
    header('Location: ../');
}
?>