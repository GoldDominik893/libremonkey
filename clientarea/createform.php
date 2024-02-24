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
<body class="loginbg-color">
<ul>
  <li><a href="../">LibreMonkey</a></li>
  <?php 
  if ($_SESSION['logged_in'] == true) { ?>
   <li style="float:right"><div class="currentuser"><?php echo $_SESSION['logged_in_user']; ?></div></li>
   <li style="float:right"><a href="../auth/logout.php">Logout</a></li>
  <?php } ?>
</ul>

<div class="loginbg">
<h1 class="center">Form Creation</h1>
    <div class="center-container2 whitebg">
        <h1 class="no-margin">Form Creation</h1><br>
        <form action="createform.php">
            <input type="hidden" name="r" value="create">

            <label for="title">Title:</label><br>
            <input class="formcreationinput" type="text" id="title" name="title"><br>
            
            <label for="description">Description:</label><br>
            <textarea class="formcreationinput" id="description" name="description"></textarea><br>
            
            <input type="submit" value="Next">
        </form>
    </div>
</div>
</body>
</html>
<?php
if ($_GET['r'] == 'create') {
    include('../config.php');

    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $creator_username = $_SESSION['logged_in_user'];
    $title = $_GET['title'];
    $description = $_GET['description'];
    $status = "inactive";
    $response_count = 0;
    
    $sql = "INSERT INTO forms (creator_username, title, description, status, response_count) VALUES ('$creator_username', '$title', '$description', '$status', $response_count)";
    
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        echo "New record created successfully. Last inserted ID is: " . $last_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    header('Location: edit_form.php?form_id='.$last_id);
}
} else { 
    header('Location: ../');
}
?>
