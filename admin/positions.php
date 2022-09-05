<?php
    session_start();
    require('../connection.php');

    if(empty($_SESSION['admin_id'])){
    header("location:access-denied.php");
    }
    //retrive positions from the tbpositions table
    $result=mysqli_query($con, "SELECT * FROM tbPositions");
    if (mysqli_num_rows($result)<1){
        $result = null;
    }
?>

<?php
    // inserting sql query
    if (isset($_POST['Submit'])){
        $newPosition = addslashes( $_POST['position'] );

        $sql = mysqli_query($con, "INSERT INTO tbpositions (position_name) VALUES ('$newPosition')");
        header("Location: positions.php");
    }
?>


<?php
    if (isset($_GET['Fid'])){
        $id = $_GET['Fid'];
        $f = 1;
        $sql=mysqli_query($con, "SELECT * FROM tbfreeze WHERE position_id='$id'");
        $count = mysqli_num_rows($sql);
        if($count == 1){
            $result = mysqli_query($con, "UPDATE tbfreeze SET freeze= '$f' WHERE position_id='$id'");
        }
        else{
            $sql = mysqli_query($con, "INSERT INTO tbfreeze (position_id) VALUES ('$id')");
            $result = mysqli_query($con, "UPDATE tbfreeze SET freeze= '$f' WHERE position_id='$id'");
        }
        header("Location: positions.php");
    }
?>

<?php
    if (isset($_GET['UFid'])){
        $id = $_GET['UFid'];
        $f = 0;
        $sql=mysqli_query($con, "SELECT * FROM tbfreeze WHERE position_id='$id'");
        $count = mysqli_num_rows($sql);
        if($count == 1){
            $result = mysqli_query($con, "UPDATE tbfreeze SET freeze= '$f' WHERE position_id='$id'");
        }
        else{
            $sql = mysqli_query($con, "INSERT INTO tbfreeze (position_id) VALUES ('$id')");
            $result = mysqli_query($con, "UPDATE tbfreeze SET freeze= '$f' WHERE position_id='$id'");
        }
        
        header("Location: positions.php");
    }
?>

<?php
    if (isset($_GET['id'])){
        $id = $_GET['id'];
        
        $result = mysqli_query($con, "DELETE FROM tbPositions WHERE position_id='$id'");
        
        header("Location: positions.php");
    }
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Administration Control Panel:Positions</title>
    <link href="css/admin_styles.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="js/admin.js">
    </script>
</head>


<body bgcolor="tan">
    <center>
        <b><font color = "brown" size="6">Online Election System</font></b>
    </center>
    <br><br>
<div id="page">
<div id="header">
  <h1>MANAGE POSITIONS</h1>
  <a href="admin.php">Home</a> | <a href="positions.php">Manage Positions</a> | <a href="candidates.php">Manage Candidates</a> | <a href="refresh.php">Election Results</a> | <a href="manage-admins.php">Manage Account</a> | <a href="change-pass.php">Change Password</a>  | <a href="logout.php">Logout</a>
</div>
<div id="container">
<table width="380" align="center">
<CAPTION><h3>ADD NEW POSITION</h3></CAPTION>
<form name="fmPositions" id="fmPositions" action="positions.php" method="post" onsubmit="return positionValidate(this)">
<tr>
    <td>Position Name</td>
    <td><input type="text" name="position" /></td>
    <td><input type="submit" name="Submit" value="Add" /></td>
</tr>
</table>
<hr>
<table border="0" width="420" align="center">
<CAPTION><h3>AVAILABLE POSITIONS</h3></CAPTION>
<tr>
<th>Position ID</th>
<th>Position Name</th>
</tr>

<?php
//loop through all table rows
$inc=1;
while ($row=mysqli_fetch_array($result)){
echo "<tr>";
echo "<td>" .$inc."</td>";
echo "<td>" . $row['position_name']."</td>";
echo '<td><a href="positions.php?id=' . $row['position_id'] . '">Delete Position</a></td>';

echo '<td><a href="positions.php?Fid=' . $row['position_id'] . '">Freeze Election</a></td>';
echo '<td><a href="positions.php?UFid=' . $row['position_id'] . '">Unfreeze Election</a></td>';
echo "</tr>";
$inc++;
}

mysqli_free_result($result);
mysqli_close($con);
?>
</table>
<hr>
</div>
<div id="footer"> 
  <div class="bottom_addr">&copy; 2022 Online Election System. All Rights Reserved</div>
</div>
</div>
</body>
</html>