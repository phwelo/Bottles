<?php
$con = mysql_connect("localhost","root","ALsk1029");
mysql_select_db("bottles", $con);

$query = "SELECT TargetPhe FROM settings WHERE ID=1";
$result = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($result);
$phelimit = $row['TargetPhe'];

$phecss = "none";
if (isset($_GET['p'])) {
  $phecss = "";
}
?>

<?
//print_r($_POST);

if($_POST["action"] == "Upload Image")
{
unset($imagename);

if(!isset($_FILES) && isset($HTTP_POST_FILES))
$_FILES = $HTTP_POST_FILES;

if(!isset($_FILES['image_file']))
$error["image_file"] = "An image was not found.";

$imagename = basename($_FILES['image_file']['name']);
//echo $imagename;

if(empty($imagename))
$error["imagename"] = "The name of the image was not found.";

if(empty($error))
{
$newimage = "images/" . $imagename;
//echo $newimage;
$result = @move_uploaded_file($_FILES['image_file']['tmp_name'], $newimage);
if(empty($result))
$error["result"] = "There was an error moving the uploaded file.";
}

}

?>
<head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
        <title>Today's Food</title>
        <link rel="stylesheet" href="metro/css/metro-bootstrap.css" />
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
</head><body>
<h2>Settings</h2>
                    <ul class="nav nav-tabs">
                        <li class=""><a href="index.php">Home</a></li>
                        <li class=""><a href="today.php">Today</a></li>
                        <li class=""><a href="newfood.php">Add</a></li>
                        <li class=""><a href="calculator.php">Calculate</a></li>
                        <li class="active"><a href="">&nbsp<img src="images/gear.png">&nbsp</a></li>
                    </ul>

<div class="alert alert-success" style="display:<?php echo $phecss ?>;">
  <a class="close" data-dismiss="alert" href="settings.php">x</a>
  <strong>Success!</strong> Phe limit was update to <?php echo $phelimit ?></strong>
</div>

 <form action="phelim.php" method="post">
   <label>Phe Limit</label>
   <input class="span3" type="tel" class="span3" name="phe" placeholder="<?php echo $phelimit ?>">
   <input type="submit" value="Save" class="btn-small btn">
 </form>
   <label>Pictures</label>
   <ul class="thumbnails">
    <li style="height:auto;" class="span3 tile">
      <form method="POST" enctype="multipart/form-data" name="image_upload_form" action="<? $_SERVER["PHP_SELF"];?>">>  
        <a href="#" >
          <img width="130px" height="130px" src="images/Stella.jpg">
          <h2>Stella Pic</h2>
          <div style="margin-left:20px; overflow:hidden;">
            <input type="file" name="image_file" onchange="this.form.submit();">
          </div>
        </a>
       </form>
     </li>
   </ul>
 <br>
   <ul class="thumbnails">
     <li style="height:auto;" class="span3 tile">
       <form>
         <a href="#">
           <img src="images/Zoe.jpg">
           <h2>Zoe Pic</h2>
           <div style="margin-left:20px; overflow:hidden;">
             <input class="" type="file" accept="image/*" onchange="this.form.submit();">
           </div>
         </a>
       </form>
     </li>
   </ul>
<?
if(is_array($error))
{
while(list($key, $val) = each($error))
{
echo $val;
echo "<br>\n";
}
}
?>
</body>
</html>
