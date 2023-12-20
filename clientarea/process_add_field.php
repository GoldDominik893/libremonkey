<?php
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $form_id = $_POST['form_id'];
    $field_label = $_POST['field_label'];
    // Assuming field_type needs a default value, otherwise adjust accordingly

    // Connect to the database
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to insert the new field
    $sql_insert_field = "INSERT INTO fields (form_id, field_label, field_type) VALUES (?, ?, 'default_value')";
    $stmt = $conn->prepare($sql_insert_field);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("is", $form_id, $field_label);
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
