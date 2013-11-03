<?php
//pull submitted values from previous page
$Samount = "$_POST[Samount]";
$Zamount = "$_POST[Zamount]";

//date as YYYY-mm-dd
$NowDate = date('Y-m-d');
//date as m/d
$NowDateDisp = date ('n/j');

//set default values for showing the CSS hiding properties
$ZCSS="display:none;";
$SCSS="display:none;";

try{
	if ($Samount>0) 
	{
		$user_name = "root";
		$password = "ALsk1029";
		$database = "bottles";
		$server = "localhost";
		$db_handle = mysql_connect($server, $user_name, $password);
		$db_found = mysql_select_db($database, $db_handle);
		
		$Stype = "$_POST[Stype]";
		$SQL2 = 'SELECT * FROM food WHERE Code="'. $Stype.'"';
		$result2 = mysql_query($SQL2) or die(mysql_error());
		while($db_field2 = mysql_fetch_assoc($result2)){
		$StypeD = $db_field2['Name'];
		$SPhe = $db_field2['Phe'];
		$STotal2 = $SPhe * $Samount;
		}
		//Convert shorthand to displayed names
		
		$Stime = "$_POST[Stime]";
		$SCSS="";
			//begin time code
			$Sdate = $NowDate.' '.$Stime.':00';
			//convert 24 to 12 hr time string
			$Stime12  = DATE("g:i a", STRTOTIME($Stime));
			$SdateDisplay = $Stime12.' on '.$NowDateDisp;
			//end time code
				$con = mysql_connect("localhost","root","ALsk1029");
				mysql_select_db("bottles", $con);
				$sql="INSERT INTO stella (type, amount, time, grams)
				VALUES('$Stype','$STotal2', '$Sdate','$Samount')";
			if (!mysql_query($sql,$con))
			{
				die('Error: ' . mysql_error());
			}
			mysql_close($con);
	}
	else
	{
		$SCSS="display:none;";
	}
	
		if ($Zamount>0) 
	{
		
		$user_name = "root";
		$password = "ALsk1029";
		$database = "bottles";
		$server = "localhost";
		$db_handle = mysql_connect($server, $user_name, $password);
		$db_found = mysql_select_db($database, $db_handle);
		
		$Ztype = "$_POST[Ztype]";
		$SQL2 = 'SELECT * FROM food WHERE Code="'. $Ztype.'"';
		$result2 = mysql_query($SQL2) or die(mysql_error());
		while($db_field2 = mysql_fetch_assoc($result2)){
		$ZtypeD = $db_field2['Name'];
		$ZPhe = $db_field2['Phe'];
		$ZTotal2 = $ZPhe * $Zamount;
		}
		//Convert shorthand to displayed names
	
	$Ztime = "$_POST[Ztime]";
	$ZCSS="";
	$Zdate = $NowDate.' '.$Ztime.':00';
	//convert 24 to 12 hr time string
	$Ztime12  = DATE("g:i a", STRTOTIME($Ztime));
	$ZdateDisplay = $Ztime12.' on '.$NowDateDisp;
	$con = mysql_connect("localhost","root","ALsk1029");
	mysql_select_db("bottles", $con);
	$sql="INSERT INTO zoe (type, amount, time, grams)
	VALUES('$Ztype','$ZTotal2', '$Zdate','$Zamount')";
		if (!mysql_query($sql,$con))
		{
		die('Error: ' . mysql_error());
		}
	mysql_close($con);
	}
	else{
	$ZCSS="display:none;";
	}
} catch (Exception $e ) {
			//Meh
			}

//instead of catching the error i'm going to validate whether either form is shown with the CSS variables i create above
//and then if nothing else is visible i can maybe check the database to see if anything was written

//going to rewrite this as a simple redirect with URL for passing variables
//do isset for all four possibilities (zoe, stella, stella&zoe, neither
//for isset repurpose the css variables 
//then we can just use all of the queries that we've already run for this page
header( 'Location: index.php?ST=' . $STotal2 . '&SY=' . $StypeD . '&SD=' . $Stime12 . '&ZT=' . $ZTotal2 . '&ZY=' . $ZtypeD . '&ZD=' . $Ztime12) ;
?>

