<?php
session_start();
include('../config.php');
if ($_SESSION['logged_in'] == true) {

$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch $form_id (You might fetch this from somewhere)
$form_id = $_GET['form_id']; // Replace this with your method to fetch form_id

// Fetch fields associated with the $form_id
$sql_fetch_fields = "SELECT * FROM fields WHERE form_id = $form_id";
$result_fields = $conn->query($sql_fetch_fields);

if (!$result_fields) {
    die("Error fetching fields: " . $conn->error);
}
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



    

<?php
// Fetch current form details to prefill the form fields
$sql_fetch_form_details = "SELECT title, description, status, creator_username FROM forms WHERE form_id='$form_id'";
$result_form_details = $conn->query($sql_fetch_form_details);

if ($result_form_details->num_rows > 0) {
    $row = $result_form_details->fetch_assoc();
    $current_title = $_POST['form_title'] ?? $row['title'];
    $current_description = $_POST['form_description'] ?? $row['description'];
    $current_status = $_POST['form_status'] ?? $row['status'];
    $creator_username = $row['creator_username'];
} else {
    // Handle if no form details are found
    $current_title = '';
    $current_description = '';
    $current_status = '';
}

if ($_SESSION['logged_in_user'] == $creator_username) {

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_form'])) {
        $new_title = $_POST['form_title'];
        $new_description = $_POST['form_description'];

        // Update the form details in the forms table
        $sql_update_form = "UPDATE forms SET title='$new_title', description='$new_description' WHERE form_id='$form_id'";
        if ($conn->query($sql_update_form) === FALSE) {
            echo "Error updating form: " . $conn->error;
        } else {

            $formupdatemessage = "Form updated successfully";
        }
    } elseif (isset($_POST['delete_form'])) {
        // Delete the entire form and associated fields
        $sql_delete_form = "DELETE FROM forms WHERE form_id='$form_id'";
        if ($conn->query($sql_delete_form) === FALSE) {
            echo '<div class="loginbg">
            <h1 class="center">Edit Form</h1>
                <div class="center-container2 whitebg">Error deleting form: ' . $conn->error;
        } else {

            echo '<div class="loginbg">
            <h1 class="center">Edit Form</h1>
                <div class="center-container2 whitebg">Form deleted successfully';
            exit;
        }
    }
}
?>


<div class="loginbg">
<h1 class="center">Edit Form</h1>
    <div class="center-container2 whitebg">
    <form method="POST" action="">
        <?php if ($creator_username != "") {?><input class="button-form" style="color: black; border: none; font-size: 17px;" type="submit" name="delete_form" value="Delete Form" onclick="return confirm('Are you sure you want to delete this form? This action cannot be undone.');"><?php } ?>
    </form>
    <h1 class="no-margin">Edit Form</h1>
    <?php echo htmlspecialchars($formupdatemessage); ?>



    <!-- Edit Form Details Section -->
    <form id="form" method="POST" action="">
        <label for="form_title">Title:</label>
        <input class="formcreationinput" type="text" id="form_title" name="form_title" value="<?php echo htmlspecialchars($current_title); ?>"><br>

        <label for="form_description">Description:</label><br>
        <textarea class="formcreationinput" id="form_description" name="form_description"><?php echo htmlspecialchars($current_description); ?></textarea>

        <input type="submit" name="update_form" value="Update Form">
    </form>




<!-- Display existing fields -->
<?php

if ($result_fields->num_rows > 0) {
    while ($field = $result_fields->fetch_assoc()) {
        echo '<label for="' . $field['field_id'] . '">' . $field['field_label'] . '</label><br>';
        // Delete button for each field
        echo '<form method="POST" action="">';
        echo '<input type="hidden" name="delete_field_id" value="' . $field['field_id'] . '">';
        echo '<input type="submit" name="delete_field" value="Delete">';
        echo '</form><br>';
    }
}
?>



    <!-- Add Field Form -->
    <button id="addFieldBtn">Add Field</button><br><br>

    <div id="addFieldForm" style="display: none;">
    <input type="hidden" id="formId" value="<?php echo $form_id; ?>">
    
    <label for="fieldLabel">Field Label:</label><br>
    <input type="text" id="fieldLabel"><br><br>
    
    <label for="fieldType">Field Type:</label><br>
    <select id="fieldType">
        <option value="text">Text</option>
        <option value="date">Date</option>
        <option value="tel">Telephone Number</option>
        <option value="color">Hex Color</option>
    </select><br><br>
    
    <!-- Other field details specific to certain types -->
    <div id="additionalFields" style="display: none;">
        
        <!-- For date -->
        <label for="dateField">Date:</label><br>
        <input type="date" id="dateField"><br><br>
        
        <!-- For tel -->
        <label for="telField">Tel:</label><br>
        <input type="tel" id="telField"><br><br>
        
        <!-- For color -->
        <label for="colorField">Color:</label><br>
        <input type="color" id="colorField"><br><br>
    </div>
    
    <button id="submitFieldBtn">Submit</button>
</div>


    <script>
document.getElementById('addFieldBtn').addEventListener('click', function() {
    document.getElementById('addFieldForm').style.display = 'block';
});

document.getElementById('fieldType').addEventListener('change', function() {
    var selectedType = this.value;
    var additionalFields = document.getElementById('additionalFields');
    
    if (selectedType === 'image' || selectedType === 'date' || selectedType === 'tel' || selectedType === 'color') {
        additionalFields.style.display = 'block';
    } else {
        additionalFields.style.display = 'none';
    }
});

document.getElementById('submitFieldBtn').addEventListener('click', function() {
    var formId = document.getElementById('formId').value;
    var fieldLabel = document.getElementById('fieldLabel').value;
    var fieldType = document.getElementById('fieldType').value;
    // Get other field details based on the selected type
    
    // AJAX request to process adding the field
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                // Successful response
                location.reload(); // Reload the page after successful addition
            } else {
                // Error response
                alert("Error adding field");
            }
        }
    };
    xhr.open("POST", "process_add_field.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("form_id=" + formId + "&field_label=" + fieldLabel + "&field_type=" + fieldType);
});

    </script>

    <!-- PHP code to handle field deletion -->
    <?php
    if (isset($_POST['delete_field'])) {
        $delete_field_id = $_POST['delete_field_id'];

        // Connect to your database - Replace with your database credentials

        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Delete the specified field from the fields table
        $sql_delete_field = "DELETE FROM fields WHERE field_id='$delete_field_id'";
        if ($conn->query($sql_delete_field) === FALSE) {
            echo "Error deleting field: " . $conn->error;
        } else {
            header("Location: edit_form.php?form_id=$form_id"); // Redirect to refresh the page after deletion
        }

        $conn->close();
    }
    ?>
    </div>
</div>
</body>
</html>
<?php

} else {
    if ($creator_username) {
        echo '<div class="loginbg">
        <h1 class="center">Edit Form</h1>
            <div class="center-container2 whitebg">Error 401 - you do not have permission to edit this form';
    } else {
        echo '<div class="loginbg">
        <h1 class="center">Edit Form</h1>
            <div class="center-container2 whitebg">Error 404 - this form does not exist';
    }
    
} 
} else {
    header('Location: ../');
}
?>