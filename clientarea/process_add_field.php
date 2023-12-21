<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and perform basic validation or sanitization
    $form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
    $field_label = isset($_POST['field_label']) ? $_POST['field_label'] : '';
    $field_type = isset($_POST['field_type']) ? $_POST['field_type'] : '';

    // Validate or sanitize the form inputs further if needed

    // Connect to the database
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to insert the new field
    $sql_insert_field = "INSERT INTO fields (form_id, field_label, field_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_insert_field);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("iss", $form_id, $field_label, $field_type);
    $stmt_executed = $stmt->execute();

    if ($stmt_executed === TRUE) {
        echo "Field added successfully";
    } else {
        echo "Error adding field: " . $stmt->error;
        error_log("Error adding field: " . $stmt->error); // Log the error
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
