<?php require_once('Connections/connection.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM wish_lifereminder WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_connection, $connection);
  $Result1 = mysql_query($deleteSQL, $connection) or die(mysql_error());

  $deleteGoTo = "wishes(view).php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Recordsetdelw = "-1";
if (isset($_GET['id'])) {
  $colname_Recordsetdelw = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_connection, $connection);
$query_Recordsetdelw = sprintf("SELECT * FROM wish_lifereminder WHERE id = %s", $colname_Recordsetdelw);
$Recordsetdelw = mysql_query($query_Recordsetdelw, $connection) or die(mysql_error());
$row_Recordsetdelw = mysql_fetch_assoc($Recordsetdelw);
$totalRows_Recordsetdelw = mysql_num_rows($Recordsetdelw);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<?php
mysql_free_result($Recordsetdelw);
?>
