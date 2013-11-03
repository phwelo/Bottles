<?
$theID = $_POST['id'];
$SplitID = str_split($theID,1);
$girl = $theID{0};
$id = substr($theID, 1);

if($girl=="S")
   $dbname="stella";
if($girl=="Z")
   $dbname="zoe";


$conn = mysql_connect("localhost","root","ALsk1029");
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
$sql = "DELETE FROM $dbname WHERE id='$id'";
mysql_select_db("bottles", $conn);
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not delete data: ' . mysql_error());
}
header( 'Location: today.php?s=1' ) ;
mysql_close($conn);
?>
