<?php
	require('connection.php');

	session_start();
	//If session isn't valid, it returns to the login
	if(empty($_SESSION['member_id'])){
		header("location:access-denied.php");
	}
?>

<?php
	$positions=mysqli_query($con, "SELECT * FROM tbPositions");
?> 

<?php
	if (isset($_POST['Submit'])) {
		 $position = addslashes( $_POST['position'] ); //prevents types of SQL injection
		 
		 $result = mysqli_query($con,"SELECT * FROM tbCandidates WHERE candidate_position='$position'");
		 $result2 = mysqli_query($con,"SELECT * FROM tbpositions WHERE position_name='$position' LIMIT 1");
		 $value = mysqli_fetch_array($result2);
		 $value2= $value['position_id'];
		 
		 $result3 = mysqli_query($con,"SELECT * FROM tbfreeze WHERE position_id='$value2' LIMIT 1");
	 }
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Online Election System: Voting Page</title>
	<link href="css/user_styles.css" rel="stylesheet" type="text/css" />   
	<script language="JavaScript" src="js/user.js">
	</script>
	<script type="text/javascript">
	function getVote(int)
	{
	if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
	  	xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

		if(confirm("Your vote is for "+int))
		{
	  var pos=document.getElementById("str").value;
	  var id=document.getElementById("hidden").value;
	  xmlhttp.open("GET","save.php?vote="+int+"&user_id="+id+"&position="+pos,true);
	  xmlhttp.send();

	  xmlhttp.onreadystatechange =function()
	{
		if(xmlhttp.readyState ==4 && xmlhttp.status==200)
		{
	  //  alert("dfdfd");
		document.getElementById("error").innerHTML=xmlhttp.responseText;
		}
	}

	  }
		else
		{
		alert("Choose another candidate ");
		}
		
	}

	function getPosition(String)
	{
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }

	xmlhttp.open("GET","vote.php?position="+String,true);
	xmlhttp.send();
	}
	</script>

	<script type="text/javascript">
	$(document).ready(function(){
	   var j = jQuery.noConflict();
		j(document).ready(function()
		{
			j(".refresh").everyTime(1000,function(i){
				j.ajax({
				  url: "admin/refresh.php",
				  cache: false,
				  success: function(html){
					j(".refresh").html(html);
				  }
				})
			})
			
		});
	   j('.refresh').css({color:"green"});
	});
	</script>
</head>

<body bgcolor="tan">
	<center>
		<b><font color = "brown" size="6">Online Election System</font></b>
	</center>
	<br><br>
	
	
<body>
<div id="page">
<div id="header">
  <h1>CURRENT ELECTIONS</h1>
  <a href="student.php">Home</a> | <a href="vote.php">Current Elections</a> | <a href="manage-profile.php">Manage My Profile</a> | <a href="changepass.php">Change Password</a>| <a href="logout.php">Logout</a>
</div>
<div class="refresh">
</div>
<div id="container">
<table width="420" align="center">
<form name="fmNames" id="fmNames" method="post" action="vote.php" onSubmit="return positionValidate(this)">
<tr>
    <td>Choose Position</td>
    <td><SELECT NAME="position" id="position" onclick="getPosition(this.value)">
    <OPTION VALUE="select">select
    <?php 
		while ($row=mysqli_fetch_array($positions)){
			echo "<OPTION VALUE=$row[position_name]>$row[position_name]"; 
		}
    ?>
    </SELECT></td>
    <td><input type="hidden" id="hidden" value="<?php echo $_SESSION['member_id']; ?>" /></td>
    <td><input type="hidden" id="str" value="<?php echo $_REQUEST['position']; ?>" /></td>
    <td><input type="submit" name="Submit" value="See Candidates" /></td>
</tr>
<tr>
    <td>&nbsp;</td> 
    <td>&nbsp;</td>
</tr>
</form> 
</table>
<table width="270" align="center">
<form>
<tr>
    <th>Candidates:</th>
</tr>


<?php

  if (isset($_POST['Submit']))
  {
	$check = mysqli_fetch_array($result3);
	$check2 = $check['freeze'];
	
	if($check2==0){
		while ($row=mysqli_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . $row['candidate_name']."</td>";
			echo "<td><input type='radio' name='vote' value='$row[candidate_name]' onclick='getVote(this.value)' /></td>";
			echo "</tr>";
		}
	}
	else{
		echo "This Election is now Freezed!!";
	}
	mysqli_free_result($result);
	mysqli_close($con);

  }

?>
<tr>
    <h3>NB: Click a circle under a respective candidate to cast your vote.</h3>
    <td>&nbsp;</td>
</tr>
</form>
</table>
<center><span id="error"></span></center>
</div>
<div id="footer"> 
  <div class="bottom_addr">&copy; 2022 Online Election System. All Rights Reserved</div>
</div>
</div>
</body>
</html>