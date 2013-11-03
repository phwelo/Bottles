<?php
$Recipe = 24;
//Target for Mixed Drink
$MPTarget = 245;
//Target for Food
$FPTarget = 0;
//Current Mix mgPhe/Oz
$MixPhe = 10.2;




$STgot = $_GET["ST"];
$SYgot = $_GET["SY"];
$SDgot = $_GET["SD"];

$ZTgot = $_GET["ZT"];
$ZYgot = $_GET["ZY"];
$ZDgot = $_GET["ZD"];

$SCgot = "none";
$ZCgot = "none";

if ($STgot>0) {
    $SCgot = "";
}

if ($ZTgot>0) {
    $ZCgot = "";
}


$con = mysql_connect("localhost","root","ALsk1029");
mysql_select_db("bottles", $con);

//Get sum of mixed values for the day for stella
//removed

//get current phe limit from settings table
$query = "SELECT TargetPhe FROM settings WHERE ID=1";
$result = mysql_query($query) or die (mysql_error());
$row = mysql_fetch_array($result);
$SFPTarget = $row['TargetPhe'];
$ZFPTarget = $row['TargetPhe'];

//Get sum of  everything else
$query = "SELECT type, SUM(amount) FROM stella WHERE (DATE_SUB(CURDATE(),INTERVAL 0 DAY) <= time AND type<>'M')"; 
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
	$SCTotal = $row['SUM(amount)'];
	}
	
if (empty($SCTotal)){
$SCTotal = 0;
}
	
//Get sum of mixed values for the day for zoe
//removed
	
//Get sum of cereal value for the day for zoe
$query = "SELECT type, SUM(amount) FROM zoe WHERE (DATE_SUB(CURDATE(),INTERVAL 0 DAY) <= time AND type<>'M')"; 
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
	$ZCTotal = $row['SUM(amount)'];
	}

if (empty($ZCTotal)){
$ZCTotal = 0;
}


	
//Calculate remaiining food and percentage
$SRemain2 = $SFPTarget - $SCTotal;	
$SPerc2 = 100 - ($SRemain2 / $SFPTarget * 100);
$SPerc2 = round($SPerc2, 0, PHP_ROUND_HALF_UP);
if($SPerc2 < 50){
   $SPercCSS = "progress-success";}
elseif($SPerc2 < 75){
   $SPercCSS = "progress-warning";}
else{
   $SPercCSS = "progress-danger";}

$ZRemain2 = $ZFPTarget - $ZCTotal;
$ZPerc2 = 100 - ($ZRemain2 / $ZFPTarget * 100);
$ZPerc2 = round($ZPerc2, 0, PHP_ROUND_HALF_UP);
if($ZPerc2 < 50){
   $ZPercCSS = "progress-success";}
elseif($ZPerc2 < 75){
   $ZPercCSS = "progress-warning";}
else{
   $ZPercCSS = "progress-danger";}


$query = "SELECT * FROM food ORDER BY Name";
$result = mysql_query($query) or die(mysql_error());
$varOptions = "";
while($row = mysql_fetch_array($result)){
	$varBuild ="<option  value=" . $row['Code']. ">". $row['Name']. "</option>";
	$varOptions = $varOptions . $varBuild;
	}
?>
<head>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta id="viewport" name="viewport" content="width=320; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
        <title>PKU Bottle Calculator</title>
        <link rel="stylesheet" type="text/css" href="metro/css/metro-bootstrap.css">
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
        <link rel="stylesheet" href="stylesheets/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    /* support: IE7 */
    *height: 1.7em;
    *top: 0.1em;
  }
  .custom-combobox-input {
    margin: 0;
    padding: 0.3em;
  }
  </style>

<script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
    $( "#combobox" ).combobox();
    $( "#combobox2" ).combobox();
    $( "#toggle" ).click(function() {
      $( "#combobox" ).toggle();
    });
  });
  </script>
</head><html><body>
<h2>PKU Calculator</h2>
                    <ul class="nav nav-tabs">
			<li class="active"><a href="#">Home</a></li>
                        <li class=""><a href="today.php">Today</a></li>
                        <li class=""><a href="newfood.php">Add</a></li>
                        <li class=""><a href="calculator.php">Calculate</a></li>
			<li class=""><a href="settings.php">&nbsp<img src="images/gearblue.png">&nbsp</a></li>
                    </ul>

<div class="alert alert-success" style="display:<?php echo $SCgot ?>;">
<strong>Success!</strong> Succesfully entered <?PHP echo $SYgot ?> totalling <?php echo $STgot ?>mg Phe for Stella at <?php echo $SDgot ?>
</div>

<div class="alert alert-success" style="display:<?php echo $ZCgot ?>;">
<strong>Success!</strong> Succesfully entered <?PHP echo $ZYgot ?> totalling <?php echo $ZTgot ?>mg Phe for Zoe at <?php echo $ZDgot ?>
</div>

<div class="alert alert-error" style="display:none;">
<strong>Error!</strong> Tell Daniel that something is messed up
</div>

<ul class="thumbnails">
 <li class="span3 tile ">
        <a href="#" >
            <img src="images/Stella.jpg">
            <h2>Stella</h2>
        </a>
 </li>

 <li class="span3 tile tile-teal">
	<h2>Totals</h2>
	<span class="label">Food:<?php echo "$SFPTarget"; ?>-<?php echo "$SCTotal"; ?>=<font color="blue"><?php echo "$SRemain2"; ?></font></span>
        <?php echo "<div class=\"progress active progress-striped " . $SPercCSS . "\">"; ?>
        <?php echo "<div class=\"bar\" style=\"width:". $SPerc2 ."\";>"; ?>
        </div>
        </div>
</li>

<li class="span3 tile tile-double tile-pink">
 
<form autocorrect="off" autocapitalize="off" action="insert.php" method="post" name="form1">
  <div class="ui-widget">
    <select id="combobox" name="Stype">
      <?php echo "$varOptions"; ?>
    </select>
  </div>
  <div class="control-group">
    <div class="controls">
      <div class="input-prepend">
        <input placeholder="Amount" type="tel" class="span3" name="Samount"><br>
        <input class="span3" type="time" name="Stime">
</li>
</ul>

<ul class="thumbnails">
    
    <li class="span3 tile">
      <a href="#" >
        <img src="images/Zoe.jpg">
        <h2>Zoe</h2>
      </a>
    </li>
    
    <li class="span3 tile tile-teal">
      <h2>Totals</h2>
      <span class="label">Food:<?php echo "$ZFPTarget"; ?>-<?php echo "$ZCTotal";?>=<font color="blue"><?php echo "$ZRemain2"; ?></font></span>
        <?php echo "<div class=\"progress active progress-striped " . $ZPercCSS . "\">"; ?>
        <?php echo "<div class=\"bar\" style=\"width:". $ZPerc2 ."\";>"; ?>
        </div>
      </div>
    </li>
    
    <li class="span3 tile tile-double tile-pink">
        <div class="ui-widget">
          <select id="combobox2" name="Ztype">
            <?php echo "$varOptions"; ?>
          </select>
        </div>
        <div class="control-group">
          <div class="controls">
            <div class="input-prepend">
             <input placeholder="Amount" type="tel" class="span3" name="Zamount"><br>
             <input class="span3" type="time" name="Ztime">
            </div>
          </div>
        <div>
      </a>
    </li>
</ul>
</form>
<a class="btn btn-primary btn-large" href="#" onclick="document.forms['form1'].submit(); return false;" class="button white">Submit</a>
<div class="alert alert-info">
Twins' target mixed mg/phe per day: <?php echo "$MPTarget"; ?></strong><br />Current recipe amount makes <?php echo "$Recipe"; ?> ounces of formula.
</div>
</body>
<script type="text/javascript" src="metro/docs/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-alert.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-button.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-carousel.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-collapse.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-dropdown.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-modal.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-popover.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-scrollspy.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-tab.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-transition.js"></script>
<script type="text/javascript" src="metro/docs/bootstrap-typeahead.js"></script>
<script type="text/javascript" src="metro/docs/jquery.validate.js"></script>
<script type="text/javascript" src="metro/docs/jquery.validate.unobtrusive.js"></script>
<script type="text/javascript" src="metro/docs/jquery.unobtrusive-ajax.js"></script>
<script type="text/javascript" src="metro/docs/metro-bootstrap/metro-docs.js"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36060270-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</html>
