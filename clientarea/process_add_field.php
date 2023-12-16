<?php
include('../config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $form_id = $_POST['form_id'];
    $field_label = $_POST['field_label'];
    // Get other field details

    // Connect to your database - Replace with your database credentials

    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert new field into the fields table
    $sql_insert_field = "INSERT INTO fields (form_id, field_label) VALUES ('$form_id', '$field_label')";
    if ($conn->query($sql_insert_field) === FALSE) {
        echo "Error adding field: " . $conn->error;
        exit;
    }

    // If successful, echo a success message or any desired output
    echo "Field added successfully";

    $conn->close();
}
?>
