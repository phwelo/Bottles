<?php
//put the tuff to get the new value from post here
$phe = $_POST['phe'];
$con = mysql_connect("localhost","root","ALsk1029");
mysql_select_db("bottles", $con);
$namequery="UPDATE settings SET TargetPhe = '$phe' WHERE ID=1";
mysql_query($namequery, $con);
header( 'Location: settings.php?p=1' ) ;
?>
