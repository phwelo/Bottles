<?php
session_start();
if (isset($_SESSION['PassError'])) {
    $PassError = $_SESSION['PassError'];
    $Display = "display:block;";
}else{
	$PassError = "";
        $Display = "display:none;";
	}
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
?>
<html><body>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<title>PKU Bottle Calculator</title>
	 <link rel="stylesheet" href="metro/css/metro-bootstrap.css" />
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
</head>
		<h2>Add Item</h2>
		    <ul class="nav nav-tabs">
			<li class=""><a href="index.php">Home</a></li>
                        <li class=""><a href="today.php">Today</a></li>
                        <li class="active"><a href="newfood.php">Add</a></li>
			<li class=""><a href="calculator.php">Calculate</a></li>
                        <li class=""><a href="settings.php">&nbsp<img src="images/gearblue.png">&nbsp</a></li>
                    </ul>
<div class="alert alert-error" style="<?php echo $Display?>">
  <a class="close" data-dismiss="alert" href="#">x</a>
  <h4 class="alert-heading">Error!</h4>
  <?php echo $PassError?>
</div>
<form class="form-horizontal" action="submitfood.php" method="post" name="form1">
  <fieldset>
      <div class="control-group">
         <label class="control-label" for="input01">Name</label>
         <div class="controls">
           <input type="text"  class="input-xlarge" id="input01" name="VTitle" placeholder="Name of Food">
         </div>
      </div>
      <div class="control-group">
         <label class="control-label" for="input02">Phe</label>
         <div class="controls">
           <input type="text" class="input-xlarge" id="input02" name="VPhe" placeholder="Amount of Phe">
         </div>
      </div>
  </fieldset>
<button type="submit" class="btn btn-primary">Save changes</button>
<button onclick="location.href='index.php'" class="btn">Cancel</button>
</form>
</html>
