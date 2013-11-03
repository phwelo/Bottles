<?PHP

$user_name = "root";
$password = "ALsk1029";
$database = "bottles";
$server = "localhost";
$db_handle = mysql_connect($server, $user_name, $password);
$db_found = mysql_select_db($database, $db_handle);

if ($db_found) {

$SQL = 'SELECT * FROM stella WHERE time BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW() ORDER BY time ASC';
$result = mysql_query($SQL);
$varentries = "";
$vcounter1 = 1;
while ($db_field = mysql_fetch_assoc($result)) {
	$Stype = $db_field['type'];
		$SQL2 = 'SELECT * FROM food WHERE Code="'. $Stype.'"';
		$result2 = mysql_query($SQL2) or die(mysql_error());
		while($db_field2 = mysql_fetch_assoc($result2)){
		$db_field['type'] = $db_field2['Name'];
		$unit = $db_field2['Unit'];
		}

$vcounter1 = $vcounter1 + 1;
	if ($vcounter1&1){
		$varcolor = ' bgcolor="#FFFFFF " ';}
	else{
		$varcolor = ' bgcolor="#F0F0F0 " ';}
$tdright = ' class="far" ';
$varentries = $varentries . "<tr".$varcolor."><td>" . $db_field['time'] . "</td><td>" . $db_field['amount'] . " mg/phe</td><td ".$tdright .">" . $db_field['type'] . "</td></tr>";
}


$SQL = 'SELECT * FROM zoe WHERE time BETWEEN DATE_SUB(NOW(), INTERVAL 15 DAY) AND NOW() ORDER BY time ASC';
$result = mysql_query($SQL);
$varentries2 = "";
$vcounter2 = 1;
$varCSSb = "";
while ($db_field = mysql_fetch_assoc($result)) {
	$Ztype = $db_field['type'];
		$SQL2 = 'SELECT * FROM food WHERE Code="'. $Ztype.'"';
		$result2 = mysql_query($SQL2) or die(mysql_error());
		while($db_field2 = mysql_fetch_assoc($result2)){
		$db_field['type'] = $db_field2['Name'];
		$unit = $db_field2['Unit'];
		}
$vcounter2 = $vcounter2 +1;
if ($vcounter2&1){
		$varcolor = ' bgcolor="#FFFFFF " ';}
	else{
		$varcolor = ' bgcolor="#F0F0F0 " ';}
$varentries2 = $varentries2 . "<tr width='100%'".$varcolor."><td>" . $db_field['time'] . "</td><td>" . $db_field['amount'] . " mg/phe</td><td id='".$db_field2['Code']."'>" . $db_field['type'] . "</td></tr>";
}

$varfinal = "Stella:<br><table>" . $varentries . "</table><br>";
$varfinal2 = "Zoe:<br><table>" . $varentries2."</table>";
mysql_close($db_handle);

}
else {
print "Database NOT Found ";
mysql_close($db_handle);
}

$date = new DateTime();
$date->add(DateInterval::createFromDateString('yesterday'));
?>
