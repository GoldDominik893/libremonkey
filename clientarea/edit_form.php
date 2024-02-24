<?php
session_start();
include('../config.php');
if ($_SESSION['logged_in'] == true) {

$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$form_id = $_GET['form_id']; 

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
<link rel="stylesheet" href="../styles/googlesymbols.css" />
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

    

<?php
$sql_fetch_form_details = "SELECT title, description, status, creator_username FROM forms WHERE form_id='$form_id'";
$result_form_details = $conn->query($sql_fetch_form_details);

if ($result_form_details->num_rows > 0) {
    $row = $result_form_details->fetch_assoc();
    $current_title = $_POST['form_title'] ?? $row['title'];
    $current_description = $_POST['form_description'] ?? $row['description'];
    $current_status = $_POST['form_status'] ?? $row['status'];
    $creator_username = $row['creator_username'];
} else {

    $current_title = '';
    $current_description = '';
    $current_status = '';
}

if ($_SESSION['logged_in_user'] == $creator_username) {

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_form'])) {
        $new_title = $_POST['form_title'];
        $new_description = $_POST['form_description'];

        $sql_update_form = "UPDATE forms SET title='$new_title', description='$new_description' WHERE form_id='$form_id'";
        if ($conn->query($sql_update_form) === FALSE) {
            echo "Error updating form: " . $conn->error;
        } else {

            $formupdatemessage = "Form updated successfully";
        }
    } elseif (isset($_POST['delete_form'])) {

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
    <form id="deleteForm" method="POST" action="">
    <?php if ($creator_username != ""): ?>
        <a href="#" class="button-form warning-button" onclick="confirmDelete();"><span class="material-symbols-outlined">delete</span></a>
        <button type="submit" name="delete_form" style="display: none;"></button>
    <?php endif; ?>
</form>
<script>
    function confirmDelete() {
        if (confirm('Are you sure you want to delete this form? This action cannot be undone.')) {
            document.querySelector('form button[name="delete_form"]').click();
        }
        return false;
    }
</script>








    <h1 class="no-margin">Edit Form</h1>
    <?php echo htmlspecialchars($formupdatemessage); ?>



    <form id="form" method="POST" action="">
        <label for="form_title">Title:</label>
        <input class="formcreationinput" type="text" id="form_title" name="form_title" value="<?php echo htmlspecialchars($current_title); ?>"><br>

        <label for="form_description">Description:</label><br>
        <textarea class="formcreationinput" id="form_description" name="form_description"><?php echo htmlspecialchars($current_description); ?></textarea>

        <input type="submit" name="update_form" value="Update Form">
    </form>





<?php

if ($result_fields->num_rows > 0) {
    while ($field = $result_fields->fetch_assoc()) {
        echo '<label class="inline" for="' . $field['field_id'] . '">' . $field['field_label'] . '</label><div class="field_type_icon inline">type: ' . $field['field_type'] . '</div>';

        echo '<form class="inline" method="POST">';
        echo '<input class="inline" type="submit" name="delete_field" value="Delete">';
        echo '<input type="hidden" name="delete_field_id" value="' . $field['field_id'] . '">';
        echo '</form><br>';
    }
}
?>

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
        <option value="textarea">Textarea</option>
        <option value="email">Email</option>
        <option value="month">Month</option>
        <option value="number">Number</option>
        <option value="range">Range</option>
        <option value="time">Time</option>
        <option value="url">URL</option>
        <option value="week">Week</option>
    </select><br><br>
    
    <button id="submitFieldBtn">Submit</button>
</div>


    <script>
document.getElementById('addFieldBtn').addEventListener('click', function() {
    document.getElementById('addFieldForm').style.display = 'block';
});

document.getElementById('submitFieldBtn').addEventListener('click', function() {
    var formId = document.getElementById('formId').value;
    var fieldLabel = document.getElementById('fieldLabel').value;
    var fieldType = document.getElementById('fieldType').value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                location.reload();
            } else {
                alert("Error adding field");
            }
        }
    };
    xhr.open("POST", "process_add_field.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("form_id=" + formId + "&field_label=" + fieldLabel + "&field_type=" + fieldType);
});

    </script>

    <?php
    if (isset($_POST['delete_field'])) {
        $delete_field_id = $_POST['delete_field_id'];

        $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql_delete_field = "DELETE FROM fields WHERE field_id='$delete_field_id'";
        if ($conn->query($sql_delete_field) === FALSE) {
            echo "Error deleting field: " . $conn->error;
        } else {
            header("Location: edit_form.php?form_id=$form_id"); 
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