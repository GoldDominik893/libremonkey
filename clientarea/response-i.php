<?php
session_start();
include('../config.php');
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
if (!isset($_SESSION['logged_in_user'])) {
    header('Location: ../../');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid response ID";
    exit;
}

$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['logged_in_user'];
$response_id = $_GET['id'];

$sql_fetch_response = "SELECT r.*, f.creator_username
                        FROM responses r
                        INNER JOIN forms f ON r.form_id = f.form_id
                        WHERE r.response_id = ? AND (r.user_id = ? OR f.creator_username = ?)";
$stmt_fetch_response = $conn->prepare($sql_fetch_response);
$stmt_fetch_response->bind_param("iss", $response_id, $username, $username);
$stmt_fetch_response->execute();
$result_response = $stmt_fetch_response->get_result();

if ($response = $result_response->fetch_assoc()) {
    echo "<p>Response <i>#" . $response['response_id'] . "</i> ";
    
    $form_id = $response['form_id'];
    $sql_fetch_form_title = "SELECT title FROM forms WHERE form_id = ?";
    $stmt_fetch_form_title = $conn->prepare($sql_fetch_form_title);
    $stmt_fetch_form_title->bind_param("i", $form_id);
    $stmt_fetch_form_title->execute();
    $result_form_title = $stmt_fetch_form_title->get_result();

    if ($form_row = $result_form_title->fetch_assoc()) {
        echo "for form titled: " . htmlspecialchars($form_row['title']);
    }
    
    // Fetch the username based on the user_id from the login table
    $user_id = $response['user_id'];
    $sql_fetch_username = "SELECT username FROM login WHERE user_id = ?";
    $stmt_fetch_username = $conn->prepare($sql_fetch_username);
    $stmt_fetch_username->bind_param("i", $user_id);
    $stmt_fetch_username->execute();
    $result_username = $stmt_fetch_username->get_result();

    if ($username_row = $result_username->fetch_assoc()) {
        echo ", submitted by: " . htmlspecialchars($username_row['username']);
    }

    echo ", submitted at: " . $response['submitted_time'] . "</p>";

    // Fetch the response data and field labels
    $sql_fetch_response_data = "SELECT rd.user_input, f.field_label
                                FROM response_data rd
                                INNER JOIN fields f ON rd.field_id = f.field_id
                                WHERE rd.response_id = ?";
    $stmt_fetch_response_data = $conn->prepare($sql_fetch_response_data);
    $stmt_fetch_response_data->bind_param("i", $response['response_id']);
    $stmt_fetch_response_data->execute();
    $result_response_data = $stmt_fetch_response_data->get_result();

    echo "<h2>Response Data:</h2>";

    while ($response_data = $result_response_data->fetch_assoc()) {
        echo "<b>" . htmlspecialchars($response_data['field_label']) . "</b><br>";
        echo htmlspecialchars($response_data['user_input'])."<br>";
    }

    // Close statements
    $stmt_fetch_response_data->close();
    $stmt_fetch_username->close();
    $stmt_fetch_form_title->close();
} else {
    echo "Response not found or unauthorized access";
}




$stmt_fetch_response->close();
$conn->close();
?>
    </div><br>
</div>
</body>
</html>