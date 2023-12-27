<?php
session_start();
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
            <li style="float:right"><a href="../auth/logout.php">Logout</a></li>
        <?php } ?>
    </ul>

    <div class="loginbg">
        <h1 class="center">Client Area</h1>
        <div class="center-container2 whitebg">
            <?php
            // Include the configuration file
            include('../config.php');

            // Check if the user is logged in
            if (!isset($_SESSION['logged_in_user'])) {
                // Redirect to the login page or handle unauthorized access
                header('Location: ../../');
                exit;
            }

            // Check if the response ID is provided in the URL
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                // Handle invalid response ID, redirect, or display an error message
                echo "Invalid response ID";
                exit;
            }

            // Connect to the database
            $conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch the username and user ID from the session
            $username = $_SESSION['logged_in_user'];
            $user_id = $_SESSION['user_id']; // Assuming the user ID is stored in the session

            // Fetch the specific response details based on the response ID and the current user
            $response_id = $_GET['id'];
            $sql_fetch_response = "SELECT r.*, f.creator_username
                                    FROM responses r
                                    INNER JOIN forms f ON r.form_id = f.form_id
                                    WHERE r.response_id = ? AND (r.user_id = ? OR (f.creator_username = ? AND r.user_id = ?))";
            $stmt_fetch_response = $conn->prepare($sql_fetch_response);
            $stmt_fetch_response->bind_param("isss", $response_id, $user_id, $username, $user_id); // Assuming response_id and user_id are strings
            $stmt_fetch_response->execute();
            $result_response = $stmt_fetch_response->get_result();

            // Display the individual response details and associated response data
            if ($response = $result_response->fetch_assoc()) {
                echo "<h2>Response Details:</h2>";
                echo "<p>Response ID: " . $response['response_id'] . "</p>";
                echo "<p>Form ID: " . $response['form_id'] . "</p>";
                echo "<p>User ID: " . $response['user_id'] . "</p>";
                echo "<p>Submitted Time: " . $response['submitted_time'] . "</p>";

                // Fetch and display response data associated with the response ID
                $sql_fetch_response_data = "SELECT rd.user_input, f.field_label
                                            FROM response_data rd
                                            INNER JOIN fields f ON rd.field_id = f.field_id
                                            WHERE rd.response_id = ?";
                $stmt_fetch_response_data = $conn->prepare($sql_fetch_response_data);
                $stmt_fetch_response_data->bind_param("i", $response_id); // Assuming response_id is an integer
                $stmt_fetch_response_data->execute();
                $result_response_data = $stmt_fetch_response_data->get_result();

                echo "<h2>Response Data:</h2>";

                while ($response_data = $result_response_data->fetch_assoc()) {
                    echo "<b>" . $response_data['field_label'] . "</b><br>";
                    echo htmlspecialchars($response_data['user_input'])."<br>";
                }

                $stmt_fetch_response_data->close();
            } else {
                // No response found or unauthorized access to the response
                echo "Response not found or unauthorized access";
            }

            $stmt_fetch_response->close();
            $conn->close();
            ?>
        </div><br>
    </div>
</body>
</html>
