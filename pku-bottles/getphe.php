<?php
$q=$_GET["q"];

$con = mysql_connect('localhost', 'root', 'ALsk1029');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("bottles", $con);

$sql="SELECT * FROM food WHERE ID = '$q'";

$result= mysql_query($sql) or die($sql.mysql_error());

while($row = mysql_fetch_array($result))
  {
  echo $row['Phe'];
  }
echo " ";

mysql_close($con);
?>
