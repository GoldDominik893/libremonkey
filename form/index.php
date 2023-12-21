<?php
include('../config.php');
session_start();

// Fetch form details from the 'forms' table
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch form details
$form_id = $_GET['id']; // Retrieve the form ID from the URL or another source
$sql_fetch_form = "SELECT * FROM forms WHERE form_id = ?";
$stmt_form = $conn->prepare($sql_fetch_form);
$stmt_form->bind_param("i", $form_id);
$stmt_form->execute();
$result_form = $stmt_form->get_result();
$form_details = $result_form->fetch_assoc();

// Fetch fields related to the form from the 'fields' table
$sql_fetch_fields = "SELECT * FROM fields WHERE form_id = ?";
$stmt_fields = $conn->prepare($sql_fetch_fields);
$stmt_fields->bind_param("i", $form_id);
$stmt_fields->execute();
$result_fields = $stmt_fields->get_result();
$fields = $result_fields->fetch_all(MYSQLI_ASSOC);

$stmt_form->close();
$stmt_fields->close();
$conn->close();
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
   <li style="float:right"><a href="../logout.php">Logout</a></li>
  <?php } ?>
</ul>
<div class="loginbg">
<h1 class="center">Form</h1>
    <div class="center-container2 whitebg">
        <h1 class="no-margin"><?php echo $form_details['title']; ?></h1>
        <p class="no-margin"><?php echo nl2br($form_details['description']); ?></p>
        <!-- Display fetched form details and fields in an HTML form -->
        <form method="POST" action="process_response.php">
            <?php foreach ($fields as $field): ?>
                <label for="field_<?php echo $field['field_id']; ?>"><?php echo $field['field_label']; ?>:</label>
                <?php if ($field['field_type'] === 'text' or $field['field_type'] === 'default_value'): ?>
                    <input type="text" id="field_<?php echo $field['field_id']; ?>" name="field_<?php echo $field['field_id']; ?>"><br>
                <?php elseif ($field['field_type'] === 'textarea'): ?>
                    <textarea id="field_<?php echo $field['field_id']; ?>" name="field_<?php echo $field['field_id']; ?>"></textarea>
                <?php endif; ?>
            <?php endforeach; ?>
            <input type="hidden" name="form_id" value="<?php echo $form_id; ?>">
            <input type="submit" value="Submit Response">
        </form>
    </div>
</div>
</body>
</html>