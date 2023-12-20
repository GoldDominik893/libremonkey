<?php
// Start or resume the session
session_start();

// Include the configuration file
include('../config.php');

// Check if the user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    // Redirect to the login page or handle unauthorized access
    header('Location: ../../');
    exit;
}

// Validate and sanitize the form ID from the URL parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $form_id = $_GET['id']; // Assuming the form ID is passed in the URL
} else {
    // Handle invalid form ID, redirect, or display an error message
    echo "Invalid form ID";
    exit;
}

// Connect to the database
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the username from the session
$username = $_SESSION['logged_in_user'];

// Fetch the form details based on the form ID and the logged-in user
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
   <li style="float:right"><a href="../../logout.php">Logout</a></li>
  <?php } ?>
</ul>


<div class="loginbg">
<h1 class="center">Client Area</h1>
    <div class="center-container2 whitebg">
        <?php
    // Check if the form exists for the logged-in user
if ($row = $result_form->fetch_assoc()) {
    $form_title = $row['title'];

    // Fetch responses for this specific form
    $sql_fetch_responses = "SELECT response_id, user_id, submitted_time FROM responses WHERE form_id = ?";
    $stmt_fetch_responses = $conn->prepare($sql_fetch_responses);
    $stmt_fetch_responses->bind_param("i", $form_id);
    $stmt_fetch_responses->execute();
    $result_responses = $stmt_fetch_responses->get_result();

    // Display the form title
    echo '<h2 class="no-margin">Responses for: '.$form_title.'</h2><br>';

    // Display the responses for the form
    echo '<table class="table-wide" border="1">';
    echo "<tr><th>Response ID</th><th>User ID</th><th>Submitted Time</th><th>Actions</th></tr>";

    while ($response = $result_responses->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $response['response_id'] . "</td>";
        echo "<td>" . $response['user_id'] . "</td>";
        echo "<td>" . $response['submitted_time'] . "</td>";
        echo '<td><a style="color: black" href="../response-i.php/?id='.$response['response_id'].'">View</a> Delete</td>';
        echo "</tr>";
        // Fetch and display response data for each response if needed
    }

    echo "</table>";
} else {
    // No form found for the logged-in user with the specified ID
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