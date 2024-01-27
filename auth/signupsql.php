<?php
session_start();

$n=8;
function getName($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
 
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
 
    return $randomString;
}

$usr = $_POST['username'];
$salt1 = getName($n);
$salt2 = getName($n);
$pw = hash('sha512', $salt1.$_POST['password'].$salt2);
include('../config.php');
$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DATABASE);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$select = mysqli_query($conn, "SELECT * FROM login WHERE username = '".$_POST['username']."'");
if(mysqli_num_rows($select)) {
    header('refresh:0;url=signup.php?r=user_exists');
    exit(0);
}

$select = mysqli_query($conn, "SELECT MAX(user_id) AS max_user_id FROM login");
if ($row = mysqli_fetch_assoc($select)) {
    $max_user_id = $row['max_user_id'];
}

$sql = "INSERT INTO login (username, password, salt1, salt2)
VALUES ('$usr', '$pw', '$salt1', '$salt2')";

if ($conn->query($sql) === TRUE) {
      echo "<h2>Welcome $usr. Redirecting Soon...</h2>";
    $_SESSION['logged_in_user'] = $usr;
    $_SESSION['logged_in'] = true;
    $_SESSION['hashed_pass'] = $pw;
    $_SESSION['user_id'] = $max_user_id + 1;
} else {
  echo "Error: <br>" . $conn->error;
}

$conn->close();

if ($_GET['formid']) {
  header('refresh:0;url=../form/?id='.$_GET['formid']);
  exit(0);
}

header('refresh:0;url=../index.php');
