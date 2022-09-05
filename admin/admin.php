<?php
    session_start();
    require('../connection.php');

    if(empty($_SESSION['admin_id'])){
        header("location:access-denied.php");
    }
?>

<html>
<head>
    <link href="css/admin_styles.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="tan">
    <center>
        <b><font color = "brown" size="6">Online Election System</font></b>
    </center>
    <br><br>
<div id="page">
<div id="header">
<h1>ADMINISTRATION CONTROL PANEL </h1>
<a href="admin.php">Home</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Election Results</a> | <a href="manage-admins.php">Manage Account</a> | <a href="change-pass.php">Change Password</a>  | <a href="logout.php">Logout</a>
</div>
<p align="center">&nbsp;</p>
<div id="container">

<p>Click a link above to perform an administrative operation.</p>


</div>
<div id="footer">
<div class="bottom_addr">&copy; 2022 Online Election System. All Rights Reserved</div>
</div>
</div>
</body></html>