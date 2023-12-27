<?php
session_start();

$usr = $_POST['username'];
$pw = $_POST['password'];

include('config.php');

if ($usr&&$pw)
{
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$query = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$usr."'");
$numrows = mysqli_num_rows($query);


while ($row = mysqli_fetch_assoc($query))
{
    $dbusername = $row['username'];
    $dbpassword = $row['password'];
    $dbsalt1 = $row['salt1'];
    $dbsalt2 = $row['salt2'];
    $dbuserid = $row['user_id'];
    $hashsaltusergivenpassword = hash('sha512', $dbsalt1 . $pw . $dbsalt2);
}
if ($usr==$dbusername&&$hashsaltusergivenpassword==$dbpassword)
{
    $_SESSION['logged_in_user'] = $usr;
    $_SESSION['logged_in'] = true;
    $_SESSION['hashed_pass'] = $dbpassword;
    $_SESSION['user_id'] = $dbuserid;
    header("refresh:0;url=index.php");
}
else {
    echo "<h2>Invalid User or Password</h2>";
}

die();
}

?>