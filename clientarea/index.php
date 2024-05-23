<?php
session_start();
if ($_SESSION['logged_in'] == true) {
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


<div class="loginbg">
<h1 class="center">Client Area</h1>
    <div class="center-container2 whitebg">
        <a class="button-form" href="createform.php"><span class="material-symbols-outlined">add</span></a>
        <h2 class="no-margin">Your forms:</h2>




            <?php
            include('../config.php');
            $connection = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            $targetUsername = $_SESSION['logged_in_user'];
            $sql = "SELECT form_id, creator_username, title, description, creation_date, last_modified_date, status, response_count FROM forms WHERE creator_username = ?";
            $stmt = $connection->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $targetUsername);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<br>";
                        echo "<b>" . $row['title'] . "</b> <i>#" . $row['form_id'] . "</i><br>";
                        echo "Created: " . $row['creation_date'] . "<br>";
                        echo "Last Modified: " . $row['last_modified_date'] . "<br>";
                        echo '<a class="icon-button" href="response.php/?id=' . $row['form_id'] . '"><span class="material-symbols-outlined">lists</span></a>';
                        echo '<a class="icon-button" href="../form?id=' . $row['form_id'] . '"><span class="material-symbols-outlined">share</span></a>';
                        echo '<a class="icon-button" href="edit_form.php?form_id=' . $row['form_id'] . '"><span class="material-symbols-outlined">edit</span></a><br>';
                    }
                } else {
                    echo '<br><p class="no-margin">You don\'t have any forms yet! <a href="createform.php" style="color: black;">Create one</a></p>';
                }
                $stmt->close();
            } else {
                echo "Error preparing the SQL statement: " . $connection->error;
            }
            $connection->close();
            ?>

        <br>
        
        <?php
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['user_id'];

$sql_fetch_user_responses = "SELECT response_id, form_id, submitted_time 
                            FROM responses 
                            WHERE user_id = ?";
$stmt_fetch_user_responses = $conn->prepare($sql_fetch_user_responses);
$stmt_fetch_user_responses->bind_param("s", $username);
$stmt_fetch_user_responses->execute();
$result_user_responses = $stmt_fetch_user_responses->get_result();

echo '<h2 class="no-margin">Your responses:</h2><br><table border="1">';
echo "<tr><th>Response ID</th><th>Form ID</th><th>Submitted Time</th><th>Actions</th></tr>";

while ($response = $result_user_responses->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $response['response_id'] . "</td>";
    echo "<td>" . $response['form_id'] . "</td>";
    echo "<td>" . $response['submitted_time'] . "</td>";
    echo '<td><a style="color: white" href="response-u.php/?id='.$response['response_id'].'">View</a> Delete</td>';
    echo "</tr>";
}

echo "</table>";

$stmt_fetch_user_responses->close();
$conn->close();
?>

        
    </div><br>
</div>
</body>
</html>
<?php
} else { 
    header('Location: ../auth/signup.php');
}
?>