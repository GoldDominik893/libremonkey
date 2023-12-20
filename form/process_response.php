<?php
include('../config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $form_id = $_POST['form_id'];

    // Connect to the database
    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert response details into 'responses' table
    $sql_insert_response = "INSERT INTO responses (form_id, user_id, submitted_time) VALUES (?, ?, CURRENT_TIMESTAMP)";
    // Assuming you have a user authentication mechanism to retrieve user_id
    $user_id = $_SESSION['user_id']; // Replace with the actual user ID
    $stmt_response = $conn->prepare($sql_insert_response);
    $stmt_response->bind_param("ii", $form_id, $user_id);
    $stmt_response->execute();
    $response_id = $stmt_response->insert_id;

    // Insert response data into 'response_data' table for each field
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'field_') === 0) {
            $field_id = substr($key, strlen('field_'));
            $sql_insert_response_data = "INSERT INTO response_data (response_id, field_id, user_input) VALUES (?, ?, ?)";
            $stmt_response_data = $conn->prepare($sql_insert_response_data);
            $stmt_response_data->bind_param("iis", $response_id, $field_id, $value);
            $stmt_response_data->execute();
        }
    }

    $stmt_response->close();
    $stmt_response_data->close();
    $conn->close();

    // Redirect or display success message
    header("Location: submitted.php"); // Redirect to a success page
    exit;
}
?>
