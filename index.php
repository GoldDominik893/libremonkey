<?php
$logged_in_user = false;
session_start();
$logged_in_user = $_SESSION['logged_in'];
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
  if ($logged_in_user == true) { ?>
   <li style="float:right"><div class="currentuser"><?php echo $_SESSION['logged_in_user']; ?></div></li>
   <li style="float:right"><a href="auth/logout.php">Logout</a></li>
   <li style="float:right"><a href="clientarea/">Client Area</a></li>
  <?php } else { ?>
    <li style="float:right"><a href="auth/login.php">Login / Signup</a></li>
  <?php } ?>
  
</ul>
<div class="welcome"><h1>Create forms without spyware.</h1><br>
<a href="clientarea/" class="button">Get Started</a>
</div>

<div class="center"><h1>LibreMonkey lets you create unlimited surveys at no cost, we have all sorts of<br> 
survey functions such as dropdowns, radio buttons, date and telephone numbers.<br>
</h1></div>

<br><br><br><h1 class="center">How we compare</h1>
<div style="overflow: auto; max-width: 100vw;" class="how-we-compare center">

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
    <td class="green-hl">No limit</td>
    <td>10</td>
    <td>200</td>
    <td>Unlimited</td>
  </tr>
  <tr>
    <td><b>Survey Limit</b></td>
    <td class="green-hl">No limit</td>
    <td>200</td>
    <td>Max 5GB</td>
    <td>Max 15GB</td>
  </tr>
  <tr>
    <td><b>Responses Limit</b></td>
    <td class="green-hl">No limit</td>
    <td>100</td>
    <td>Max 5GB</td>
    <td>Max 15GB</td>
  </tr>
  <tr>
    <td><b>Question Types</b></td>
    <td>12</td>
    <td>Limited</td>
    <td>A few</td>
    <td class="green-hl">Many</td>
  </tr>
  <tr>
    <td><b>Privacy</b></td>
    <td class="green-hl">No data collected or sold</td>
    <td><a style="color: black;" href="https://www.surveymonkey.com/mp/legal/privacy/">Privacy</a></td>
    <td><a style="color: black;" href="https://support.microsoft.com/en-us/office/security-and-privacy-in-microsoft-forms-7e57f9ba-4aeb-4b1b-9e21-b75318532cd9">Privacy</a></td>
    <td><a style="color: black;" href="https://policies.google.com/privacy">Privacy</a></td>
  </tr>
  <tr>
    <td><b>Speed</b></td>
    <td>Very fast</td>
    <td>Fast</td>
    <td>Fast</td>
    <td class="green-hl">Fastest</td>
  </tr>
</table><br><br>
</div>

<div class="welcome2">
<h1>Other cool things about LibreMonkey:</h1>
<p>
· It is Open Source on <a href="//github.com/golddominik893/libremonkey">GitHub</a>.<br>
· We don't sell or collect your data.<br>
· Cookies aren't used apart from the session cookie to keep you logged in.<br>
· Optimised for mobile use.<br>
· Easy to use.
</p>

</div>

<div class="footer">
<p>Created by Dominik Wajda (GoldDominik893)</p>
</div>

</body>
</html>