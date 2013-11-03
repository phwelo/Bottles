<?php
$con = mysql_connect("localhost","root","ALsk1029");
mysql_select_db("bottles", $con);

//This builds the list of food from database
$query = "SELECT * FROM food ORDER BY Name";
$result = mysql_query($query) or die(mysql_error());
$varOptions = "";
while($row = mysql_fetch_array($result)){
	$varBuild ="<option  value=" . $row['ID']. ">". $row['Name']. "</option>";
	$varOptions = $varOptions . $varBuild;
	}

//This gets stella's phe for today so far
$queryST = "SELECT type, SUM(amount) FROM stella WHERE (DATE_SUB(CURDATE(),INTERVAL 0 DAY) <= time AND type<>'M')"; 
$resultST = mysql_query($queryST) or die(mysql_error());
while($row = mysql_fetch_array($resultST)){
	$STotal = $row['SUM(amount)'];
	}
if (empty($STotal)){
$STotal = 0;
}

//This gets zoe's phe for the day so far
$queryZT = "SELECT type, SUM(amount) FROM zoe WHERE (DATE_SUB(CURDATE(),INTERVAL 0 DAY) <= time AND type<>'M')"; 
$resultZT = mysql_query($queryZT) or die(mysql_error());
while($row = mysql_fetch_array($resultZT)){
	$ZTotal = $row['SUM(amount)'];
	}
if (empty($ZTotal)){
$ZTotal = 0;
}

//Subtract from current limit for remaining
$ZRemain = 300 - $ZTotal;
$SRemain = 300 - $STotal;
?>

<html>
<head>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta id="viewport" name="viewport" content="width=320;initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
	<link rel="stylesheet" type="text/css" href="metro/css/metro-bootstrap.css">
	<title>Reference</title>
	<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
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
    $( "#toggle" ).click(function() {
      $( "#combobox" ).toggle();
    });
  });
  </script>


<script>
function getPhe(form)
{
var varFood = form.food.value;
var varFoodNum = form.foodnum.value;

if (varFood=="")
{
		document.getElementById("txtFood").innerHTML="Poop";
		return;
} 
if (window.XMLHttpRequest)
{
		xmlhttp=new XMLHttpRequest();
}
xmlhttp.onreadystatechange=function()
{
	if (xmlhttp.readyState==4 && xmlhttp.status==200)
	{
		varResult=xmlhttp.responseText;
		var varSplitted=varResult.split(" ");
		var varFoodPhe = parseFloat(varSplitted[0]) * parseFloat(varFoodNum);
		var varMathed = varFoodPhe;
		document.getElementById("span3").innerHTML =varFoodPhe.toFixed(1);
		document.getElementById("span5").innerHTML =varMathed.toFixed(1);
		var ZRemain = document.getElementById("ZRemain").innerHTML;
		var ZRemain = parseFloat(ZRemain);
		var SRemain = document.getElementById("SRemain").innerHTML;
		var SRemain = parseFloat(SRemain);
		document.getElementById("span10").innerHTML =varMathed.toFixed(1);
		document.getElementById("span6").innerHTML =ZRemain.toFixed(1)+"-"+varMathed+"=";
		document.getElementById("span7").innerHTML =(parseFloat(ZRemain).toFixed(1) - varMathed).toFixed(1);
		document.getElementById("span8").innerHTML =SRemain.toFixed(1)+"-"+varMathed+"=";
		document.getElementById("span9").innerHTML =(parseFloat(SRemain).toFixed(1) - varMathed).toFixed(1);
	}
}
xmlhttp.open("GET","getphe.php?q="+varFood,true);
xmlhttp.send();
}
</script>
</head>

<body>
<h2>Calculator</h2>
<ul class="nav nav-tabs">
	   <li class=""><a href="index.php">Home</a></li>
           <li class=""><a href="today.php">Today</a></li>
           <li class=""><a href="newfood.php">Add</a></li>
           <li class="active"><a href="calculator.php">Calculate</a></li>
           <li class=""><a href="settings.php">&nbsp<img src="images/gearblue.png">&nbsp</a></li>

         </ul>
<ul class="thumbnails">
    <li class="span3 tile tile-purple">
        <a href="#" >
            <img src="images/Zoe.jpg">
            <h2>Zoe:<?php echo $ZRemain;?></h2>
        </a>
    </li>
    <li class="span3 tile tile-lime">
        <a href="#" >
            <img src="images/Stella.jpg">
            <h2>Stella:<?php echo $SRemain;?></h2>
        </a>
    </li>
</ul>

<form autocorrect="off" autocapitalize="off" class="well" name="myform" action="" method="get">
	<label>Food</label>
        <div class="ui-widget">
	   <select id="combobox" name="food" onchange="getPhe(this.form)">
		<?php echo $varOptions;?>
	   </select>
        </div>
	<label>Amount</label>
	<select name="foodnum" onchange="getPhe(this.form)">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
	</select>
<br>
<button type="submit" class="btn btn-primary btn-large btn-warning"><span id="span3">Select Above</span></button>
</form>
</body>
</html>
