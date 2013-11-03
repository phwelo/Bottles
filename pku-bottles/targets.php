<?php
$Target=0;
if (isset($_POST['Target'])) { 
	$Target = "$_POST[Target]"; 
}  

try{
	if (isset($_POST['Target'])) { 
	$Target = "$_POST[Target]";
	$con = mysql_connect("localhost","root","ALsk1029");
	mysql_select_db("bottles", $con);
    $sql="INSERT INTO target (Target)
	VALUES('$Target')";
		if (!mysql_query($sql,$con))
		{
		die('Error: ' . mysql_error());
		}
	mysql_close($con);
} 
	} catch (Exception $e) {}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title>Information Fields</title>

<link rel="stylesheet" href="stylesheets/iphone.css" />
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
	<script type="text/javascript">
	function clickclear(thisfield, defaulttext) {
	if (thisfield.value == defaulttext) {
	thisfield.value = "";
	}
	}
	function clickrecall(thisfield, defaulttext) {
	if (thisfield.value == "") {
	thisfield.value = defaulttext;
	}
	}
	
	</script>
	<script language="javascript"> 
	<!--
	var state = 'none';

	function showhide(layer_ref) {

	if (state == 'block') { 
	state = 'none'; 
	} 
	else { 
	state = 'block'; 
	} 
	if (document.getElementById &&!document.all) { 
	hza = document.getElementById(layer_ref); 
	hza.style.display = state; 
	} 
	} 
	//--> 
	</script>
	
	<script type="text/javascript" charset="utf-8">
		window.onload = function() {
		  setTimeout(function(){window.scrollTo(0, 1);}, 100);
		}
	</script>
	</script>
</head>
<body>
	
	<div id="header">
		<h1>Basic form</h1>
		<a href="index.php" id="backButton">Back</a>
	</div>


<h1>Mixed Target Ounces</h1>
<form action="targets.php" method="post" name="form1">
<ul class="form">
	<li><input type="text" name="phone" value="<?php echo "$Target"; ?>" id="some_name" onclick="clickclear(this, 'Phone')" onblur="clickrecall(this,'Phone')"  /></li>
</ul>
</form>
<p><a href="#" onclick="document.forms['form1'].submit(); return false;" class="button white" >Submit</a></p>
<div id="optionpanel" style="display: none">
	
<p><a class="white button" href="today.php">Today's Feedings</a>
<a href="pdfreport.php" class="white button">Create Report</a>
<a href="targets.php" class="white button">Set Targets</a>
<a href="#" class="red button" onclick="showhide('optionpanel');">Hide Panel</a>


</div>
</body>
</html>
