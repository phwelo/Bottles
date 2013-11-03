<?php
//pull submitted values
$VName= "$_POST[VTitle]";
$unit= "Oz";
$VPhe= "$_POST[VPhe]";



	$con = mysql_connect("localhost","root","ALsk1029");
				mysql_select_db("bottles", $con);
				$namequery="SELECT Name FROM food";
				$nameresult= mysql_query($namequery, $con);
				while ($row = mysql_fetch_array($nameresult,MYSQL_ASSOC)) {
    if($row['Name']==$VName){
	session_start();
	$_SESSION['PassError'] = $VName." Is Already In The System!";
	header("Location: newfood.php");
	echo "<meta http-equiv='refresh' content='0;url=newfood.php'>";
	mysql_close($con);
	
	}
}
				//if any names = this name
				//post error back to newfood.php
				//<form method="post" action="form3.php">
				
				$sql="INSERT INTO food (Name, Unit, Phe)
				VALUES('$VName', '$unit', '$VPhe')";
				
			if (!mysql_query($sql,$con))
			{
				die('Ereor: ' . mysql_error());
			}
			$query="SELECT MAX(id) FROM food";
			$result = mysql_query($query, $con); 
			$max_id= mysql_result($result,0,"MAX(ID)"); 
			$update="UPDATE food SET Code='$max_id' WHERE ID='$max_id'";
			$updater = mysql_query($update, $con);
			mysql_close($con);
			
			header("Location: index.php");
	
			?>
