<?php
include('../config.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $form_id = $_POST['form_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql_update_form = "UPDATE forms SET title='$title', description='$description' WHERE form_id='$form_id'";

    if ($conn->query($sql_update_form) === FALSE) {
        echo "Error updating form: " . $conn->error;
        exit;
    }


    foreach ($_POST as $key => $value) {
        if (strpos($key, 'field_') === 0) {
            $field_id = substr($key, 6);

            $sql_update_field = "UPDATE fields SET field_value='$value' WHERE form_id='$form_id' AND field_id='$field_id'";
            if ($conn->query($sql_update_field) === FALSE) {
                echo "Error updating field $field_id: " . $conn->error;
                exit;
            }
        }
    }

    echo "Form updated successfully";
    $conn->close();
}
?>
