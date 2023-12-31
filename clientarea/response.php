<?php
session_start();
include('../config.php');

if (!isset($_SESSION['logged_in_user'])) {

    header('Location: ../../');
    exit;
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $form_id = $_GET['id'];
} else {
    echo "Invalid form ID";
    exit;
}


$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['logged_in_user'];

$sql_fetch_form = "SELECT form_id, title FROM forms WHERE creator_username = ? AND form_id = ?";
$stmt_fetch_form = $conn->prepare($sql_fetch_form);
$stmt_fetch_form->bind_param("si", $username, $form_id);
$stmt_fetch_form->execute();
$result_form = $stmt_fetch_form->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../../styles/main.css">
<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body class="loginbg-color">
<ul>
  <li><a href="../../">LibreMonkey</a></li>
  <?php 
  if ($_SESSION['logged_in'] == true) { ?>
   <li style="float:right"><div class="currentuser"><?php echo $_SESSION['logged_in_user']; ?></div></li>
   <li style="float:right"><a href="../../auth/logout.php">Logout</a></li>
  <?php } ?>
</ul>


<div class="loginbg">
<h1 class="center">Client Area</h1>
    <div class="center-container2 whitebg">
        <?php

if ($row = $result_form->fetch_assoc()) {
    $form_title = $row['title'];

    $sql_fetch_responses = "SELECT response_id, user_id, submitted_time FROM responses WHERE form_id = ?";
    $stmt_fetch_responses = $conn->prepare($sql_fetch_responses);
    $stmt_fetch_responses->bind_param("i", $form_id);
    $stmt_fetch_responses->execute();
    $result_responses = $stmt_fetch_responses->get_result();

    echo '<h2 class="no-margin">Responses for: '.$form_title.'</h2><br>';

    echo '<table class="table-wide" border="1">';
    echo "<tr><th>Response ID</th><th>User ID</th><th>Submitted Time</th><th>Actions</th></tr>";

    while ($response = $result_responses->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $response['response_id'] . "</td>";
        echo "<td>" . $response['user_id'] . "</td>";
        echo "<td>" . $response['submitted_time'] . "</td>";
        echo '<td><a style="color: black" href="../response-i.php/?id='.$response['response_id'].'">View</a> Delete</td>';
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Form not found for the logged-in user";
}

$stmt_fetch_form->close();
$stmt_fetch_responses->close();
$conn->close();
?>
    </div><br>
</div>
</body>
</html>