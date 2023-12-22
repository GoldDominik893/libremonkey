<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles/main.css">
<meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<ul>
  <li><a href=".">LibreMonkey</a></li>
  <?php 
  if ($_SESSION['logged_in'] == true) { ?>
   <li style="float:right"><div class="currentuser"><?php echo $_SESSION['logged_in_user']; ?></div></li>
   <li style="float:right"><a href="logout.php">Logout</a></li>
   <li style="float:right"><a href="clientarea/">Client Area</a></li>
  <?php } else { ?>
    <li style="float:right"><a href="login.php">Login / Signup</a></li>
  <?php } ?>
  
</ul>
<div class="welcome"><h1>Create unlimited surveys for free.</h1><br>
<a href="#" class="button">Get Started</a>
</div>

<div class="center"><h1>LibreMonkey lets you create unlimited surveys at no cost, we have all sorts of<br> 
survey functions such as dropdowns, radio buttons, date and telephone numbers.<br>
</h1></div>

<div class="how-we-compare center">
<br><br><br><h1>How we compare</h1>

<table align="center">
  <tr>
    <th></th>
    <th>LibreMonkey</th>
    <th>SurveyMonkey(free)</th>
    <th>Microsoft Forms(free)</th>
    <th>Google Forms(free)</th>
  </tr>
  <tr>
    <td><b>Question Limit</b></td>
    <td>Unlimited</td>
    <td>10</td>
    <td>200</td>
    <td>Unlimited</td>
  </tr>
  <tr>
    <td><b>Survey Limit</b></td>
    <td>Unlimited</td>
    <td>200</td>
    <td>Max 5GB</td>
    <td>Max 15GB</td>
  </tr>
  <tr>
    <td><b>Responses Limit</b></td>
    <td>Unlimited</td>
    <td>100</td>
    <td>Max 5GB</td>
    <td>Max 15GB</td>
  </tr>
  <tr>
    <td><b>Question Types</b></td>
    <td>0</td>
    <td>Limited</td>
    <td>A few</td>
    <td>Many</td>
  </tr>
</table><br><br>
</div>

<div class="welcome2">
<h1>Other cool things about LibreMonkey:</h1>
<p>- It is Open Source on GitHub</p>
<p>- We don't sell or collect your data</p>
<p>- We don't use cookies apart from the session cookie to keep you logged in.</p>
</div>

<div class="footer">
<p>Created by Dominik Wajda (GoldDominik893)</p>
</div>

</body>
</html>