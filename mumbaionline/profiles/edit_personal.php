<?php require_once('../Connections/conn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../users/login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if($_POST['MM_Insert']=="personal") {
	include("../Classes/db.php");
	$db = new db;
	$db->phpedit("profile1","user_id",$_POST,$_SESSION['user_id']);
	$db->phpedit("profile2","user_id",$_POST,$_SESSION['user_id']);
}
?>
<?php
$coluserid_rsEdit = "1";
if (isset($_SESSION['user_id'])) {
  $coluserid_rsEdit = (get_magic_quotes_gpc()) ? $_SESSION['user_id'] : addslashes($_SESSION['user_id']);
}
mysql_select_db($database_conn, $conn);
$query_rsEdit = sprintf("SELECT * FROM users LEFT JOIN profile1 ON users.user_id = profile1.user_id LEFT JOIN profile2 ON users.user_id = profile2.user_id WHERE users.user_id = %s", $coluserid_rsEdit);
$rsEdit = mysql_query($query_rsEdit, $conn) or die(mysql_error());
$row_rsEdit = mysql_fetch_assoc($rsEdit);
$totalRows_rsEdit = mysql_num_rows($rsEdit);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/mumbaionline.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Edit Profile: Personal</title>
<!-- InstanceEndEditable -->
<link href="../default.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../js/script.js"></script>
<script src="../js/jquery-1.2.6.js" type="text/javascript"></script>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a href="http://www.mumbaionline.org.in"><span>Mumbai</span>Online<span>.org</span>.in</a></h1>
	</div>
</div>
	<div id="menu">
		<ul id="main">
			<li class="current_page_item"><a href="http://www.mumbaionline.org.in">Homepage</a></li>
		</ul>
	</div>
	
<!-- end header -->
<div id="wrapper">
	<!-- start page -->
	<div id="page">
		<div id="sidebar1" class="sidebar">
			<ul>
				<li>
					<h2>Users</h2>
					<ul>
						<?php if($_SESSION['user_id']) { ?>
							<li><a href="#">My Actions</a></li>	
							<li><a href="../users/logout.php">Logout</a></li>						
						<?php } else { ?>
							<li><a href="../users/login.php">Login</a></li>
							<li><a href="../users/register.php">Register</a></li>
						<?php } ?>
					</ul>
				</li>
				<li>
					<h2>Profiles</h2>
					<ul>
						<?php if($_SESSION['user_id']) { ?>
						<li><a href="index.php">My Profile</a></li>	
						<?php } ?>
						<li><a href="browse.php">Browse Profiles</a></li>	
					</ul>
				</li>
				<?php if($_SESSION['user_id']) { ?>
				<li>
					<h2>Edit Profile</h2>
					<ul>
						<li><a href="edit_general.php">General</a></li>	
						<li><a href="edit_social.php">Social</a></li>	
						<li><a href="edit_personal.php">Personal</a></li>	
						<li><a href="edit_professional.php">Professional</a></li>	
						<li><a href="edit_contact.php">Contact</a></li>	
						<li><a href="edit_photo.php">Photo</a></li>		
					</ul>
				</li>
				<?php } ?>
				<li>
					<h2>Confession Room</h2>
					<ul>
						<li><a href="../confession/index.php">Intro</a></li>
						<li><a href="../confession/list.php">List All Confessions</a></li>
						<?php if($_SESSION['user_id']) { ?>
						<li><a href="../confession/add.php">Add Confession</a></li>
						<li><a href="../confession/myconfessions.php">My Confessions</a></li>
						<?php } ?>
					</ul>
				</li>
				<li>
					<h2>Life Reminder</h2>
					<ul>
						<li></li>
					</ul>
				</li>
				<li>
					<h2>Communities</h2>
					<ul>
						<li></li>
					</ul>
				</li>
				<li>
					<h2>Polls</h2>
					<ul>
						<li></li>
					</ul>
				</li>
				<li>
					<h2>Website Sell/Purchase</h2>
					<ul>
						<li></li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- start content -->
		<div id="content">
<!-- InstanceBeginEditable name="EditRegion3" -->
		  <div class="post">
            <h1 class="title"><a href="#">Edit Profile: Personal</a></h1>
		    <p class="byline"><small>Posted on July 26th, 2009 by <a href="#">Admin</a></small></p>
		    <div class="entry">
<form action="" method="post" name="formPersonal" id="formPersonal">
  <table cellspacing="1" cellpadding="5" border="0">
    <tbody>
      <tr>
        <td valign="top" align="right">Headline:</td>
        <td valign="top"><input type="text" value="<?php echo $row_rsEdit['headline']; ?>" maxlength="200" id="headline" name="headline"/></td>
      </tr>
      <tr>
        <td valign="top" align="right">First thing you will notice about me:</td>
        <td valign="top"><input type="text" value="<?php echo $row_rsEdit['firstthing']; ?>" maxlength="255" id="firstthing" name="firstthing"/></td>
      </tr>
      <tr>
        <td valign="top" align="right">Height:</td>
        <td valign="top"><select id="height" name="height">
          <option value="53" <?php if (!(strcmp(53, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>4ft 5in - 134cm</option>
          <option value="54" <?php if (!(strcmp(54, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>4ft 6in - 137cm</option>
          <option value="55" <?php if (!(strcmp(55, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>4ft 7in - 139cm</option>
          <option value="56" <?php if (!(strcmp(56, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>4ft 8in - 142cm</option>
          <option value="57" <?php if (!(strcmp(57, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>4ft 9in - 144cm</option>
          <option value="58" <?php if (!(strcmp(58, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>4ft 10in - 147cm</option>
          <option value="59" <?php if (!(strcmp(59, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>4ft 11in - 149cm</option>
          <option value="60" <?php if (!(strcmp(60, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 0in - 152cm</option>
          <option value="61" <?php if (!(strcmp(61, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 1in - 154cm</option>
          <option value="62" <?php if (!(strcmp(62, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 2in - 157cm</option>
          <option value="63" <?php if (!(strcmp(63, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 3in - 160cm</option>
          <option value="64" <?php if (!(strcmp(64, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 4in - 162cm</option>
          <option value="65" <?php if (!(strcmp(65, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 5in - 165cm</option>
          <option value="66" <?php if (!(strcmp(66, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 6in - 167cm</option>
          <option value="67" <?php if (!(strcmp(67, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 7in - 170cm</option>
          <option value="68" <?php if (!(strcmp(68, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 8in - 172cm</option>
          <option value="69" <?php if (!(strcmp(69, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 9in - 175cm</option>
          <option value="70" <?php if (!(strcmp(70, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 10in - 177cm</option>
          <option value="71" <?php if (!(strcmp(71, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>5ft 11in - 180cm</option>
          <option value="72" <?php if (!(strcmp(72, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 0in - 182cm</option>
          <option value="73" <?php if (!(strcmp(73, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 1in - 185cm</option>
          <option value="74" <?php if (!(strcmp(74, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 2in - 187cm</option>
          <option value="75" <?php if (!(strcmp(75, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 3in - 190cm</option>
          <option value="76" <?php if (!(strcmp(76, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 4in - 193cm</option>
          <option value="77" <?php if (!(strcmp(77, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 5in - 195cm</option>
          <option value="78" <?php if (!(strcmp(78, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 6in - 198cm</option>
          <option value="79" <?php if (!(strcmp(79, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 7in - 200cm</option>
          <option value="80" <?php if (!(strcmp(80, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 8in - 203cm</option>
          <option value="81" <?php if (!(strcmp(81, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 9in - 205cm</option>
          <option value="82" <?php if (!(strcmp(82, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 10in - 208cm</option>
          <option value="83" <?php if (!(strcmp(83, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>6ft 11in - 210cm</option>
          <option value="84" <?php if (!(strcmp(84, $row_rsEdit['height']))) {echo "selected=\"selected\"";} ?>>7ft 0in - 213cm</option>
        </select></td>
      </tr>
      <tr>
        <td valign="top" align="right">Eye Color: </td>
        <td valign="top"><select id="eyecolor" name="eyecolor">
          <option value="0" <?php if (!(strcmp(0, $row_rsEdit['eyecolor']))) {echo "selected=\"selected\"";} ?>>no answer</option>
          <option value="1" <?php if (!(strcmp(1, $row_rsEdit['eyecolor']))) {echo "selected=\"selected\"";} ?>>black</option>
<option value="2" <?php if (!(strcmp(2, $row_rsEdit['eyecolor']))) {echo "selected=\"selected\"";} ?>>blue</option>
          <option value="3" <?php if (!(strcmp(3, $row_rsEdit['eyecolor']))) {echo "selected=\"selected\"";} ?>>brown</option>
          <option value="4" <?php if (!(strcmp(4, $row_rsEdit['eyecolor']))) {echo "selected=\"selected\"";} ?>>gray</option>
<option value="5" <?php if (!(strcmp(5, $row_rsEdit['eyecolor']))) {echo "selected=\"selected\"";} ?>>green</option>
          <option value="6" <?php if (!(strcmp(6, $row_rsEdit['eyecolor']))) {echo "selected=\"selected\"";} ?>>hazel</option>
        </select></td>
      </tr>
      <tr>
        <td valign="top" align="right">Hair Color: </td>
        <td valign="top"><select id="haircolor" name="haircolor">
          <option value="0" <?php if (!(strcmp(0, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>no answer</option>
<option value="1" <?php if (!(strcmp(1, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>auburn</option>
          <option value="2" <?php if (!(strcmp(2, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>black</option>
<option value="3" <?php if (!(strcmp(3, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>blonde</option>
          <option value="4" <?php if (!(strcmp(4, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>light brown</option>
          <option value="5" <?php if (!(strcmp(5, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>dark brown</option>
          <option value="6" <?php if (!(strcmp(6, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>red</option>
          <option value="7" <?php if (!(strcmp(7, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>gray</option>
<option value="8" <?php if (!(strcmp(8, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>salt &amp; pepper</option>
          <option value="9" <?php if (!(strcmp(9, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>bald</option>
          <option value="10" <?php if (!(strcmp(10, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>changes often</option>
          <option value="11" <?php if (!(strcmp(11, $row_rsEdit['haircolor']))) {echo "selected=\"selected\"";} ?>>other</option>
        </select></td>
      </tr>
      <tr>
        <td valign="top" align="right">Build:</td>
        <td valign="top"><select id="build" name="build">
          <option value="0" <?php if (!(strcmp(0, $row_rsEdit['build']))) {echo "selected=\"selected\"";} ?>>no answer</option>
<option value="1" <?php if (!(strcmp(1, $row_rsEdit['build']))) {echo "selected=\"selected\"";} ?>>slim</option>
          <option value="2" <?php if (!(strcmp(2, $row_rsEdit['build']))) {echo "selected=\"selected\"";} ?>>athletic</option>
          <option value="3" <?php if (!(strcmp(3, $row_rsEdit['build']))) {echo "selected=\"selected\"";} ?>>about average</option>
          <option value="4" <?php if (!(strcmp(4, $row_rsEdit['build']))) {echo "selected=\"selected\"";} ?>>a few extra pounds</option>
          <option value="5" <?php if (!(strcmp(5, $row_rsEdit['build']))) {echo "selected=\"selected\"";} ?>>large</option>
        </select></td>
      </tr>
      <tr>
        <td valign="top" align="right">Looks:</td>
        <td valign="top"><select id="looks" name="looks">
          <option value="0" <?php if (!(strcmp(0, $row_rsEdit['looks']))) {echo "selected=\"selected\"";} ?>>no answer</option>
<option value="1" <?php if (!(strcmp(1, $row_rsEdit['looks']))) {echo "selected=\"selected\"";} ?>>beauty contest winner</option>
          <option value="2" <?php if (!(strcmp(2, $row_rsEdit['looks']))) {echo "selected=\"selected\"";} ?>>very attractive</option>
          <option value="3" <?php if (!(strcmp(3, $row_rsEdit['looks']))) {echo "selected=\"selected\"";} ?>>attractive</option>
          <option value="4" <?php if (!(strcmp(4, $row_rsEdit['looks']))) {echo "selected=\"selected\"";} ?>>average</option>
          <option value="5" <?php if (!(strcmp(5, $row_rsEdit['looks']))) {echo "selected=\"selected\"";} ?>>mirror-cracking material</option>
        </select></td>
      </tr>
      <tr>
        <td valign="top" align="right">Best Feature: </td>
        <td valign="top"><select id="bestfeature" name="bestfeature">
          <option value="0" <?php if (!(strcmp(0, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>no answer</option>
<option value="1" <?php if (!(strcmp(1, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>eyes</option>
          <option value="2" <?php if (!(strcmp(2, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>hair</option>
          <option value="3" <?php if (!(strcmp(3, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>lips</option>
          <option value="4" <?php if (!(strcmp(4, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>neck</option>
          <option value="5" <?php if (!(strcmp(5, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>arms</option>
          <option value="6" <?php if (!(strcmp(6, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>hands</option>
          <option value="7" <?php if (!(strcmp(7, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>chest</option>
          <option value="8" <?php if (!(strcmp(8, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>belly button</option>
          <option value="9" <?php if (!(strcmp(9, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>butt</option>
          <option value="10" <?php if (!(strcmp(10, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>legs</option>
          <option value="11" <?php if (!(strcmp(11, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>calves</option>
          <option value="12" <?php if (!(strcmp(12, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>feet</option>
          <option value="13" <?php if (!(strcmp(13, $row_rsEdit['bestfeature']))) {echo "selected=\"selected\"";} ?>>not on the list</option>
        </select></td>
      </tr>
      <tr>
        <td valign="top" align="right">My idea of a perfect first date:</td>
        <td valign="top"><textarea id="firstdate" rows="3" cols="25" name="firstdate"><?php echo $row_rsEdit['firstdate']; ?></textarea></td>
      </tr>
      <tr>
        <td valign="top" align="right">From my past relationships i learned:</td>
        <td valign="top"><textarea id="pastrelation" rows="3" cols="25" name="pastrelation"><?php echo $row_rsEdit['pastrelation']; ?></textarea></td>
      </tr>
      <tr>
        <td valign="top" align="right">Five things i can't live without:</td>
        <td valign="top"><textarea id="fivethings" rows="3" cols="25" name="fivethings"><?php echo $row_rsEdit['fivethings']; ?></textarea></td>
      </tr>
      <tr>
        <td valign="top" align="right">In my bedroom you will find:</td>
        <td valign="top"><textarea id="bedroomthings" rows="3" cols="25" name="bedroomthings"><?php echo $row_rsEdit['bedroomthings']; ?></textarea></td>
      </tr>
      <tr>
        <td valign="top" align="right">Ideal match:</td>
        <td valign="top"><textarea id="idealmatch" rows="3" cols="25" name="idealmatch"><?php echo $row_rsEdit['idealmatch']; ?></textarea></td>
      </tr>
      <tr>
        <td valign="top" align="right"></td>
        <td valign="top">
            <input type="submit" class="clickButtonPersonal" value="Update" name="Submit"/>
            <input type="hidden" value="personal" name="MM_Insert"/></td>
      </tr>
    </tbody>
  </table>
</form>
	        </div>
	    </div>
<!-- InstanceEndEditable -->
		</div>
		<!-- end content -->
		<!-- start sidebars -->
		<div id="sidebar2" class="sidebar">
			<ul>
				
				<li>
					<h2>Forums</h2>
					<ul>
						<li></li>
					</ul>
				</li>
				<li>
					<h2>Blogs</h2>
					<ul>
						<li></li>
					</ul>
				</li>
				<li>
					<h2>Gallery</h2>
					<ul>
						<li></li>
					</ul>
				</li>
				<li>
					<h2>Jobs</h2>
					<ul>
						<li></li>
					</ul>
				</li>
				<li>
					<h2>Real Estate</h2>
					<ul>
						<li></li>
					</ul>
				</li>
				<li>
					<h2>Matrimonial</h2>
					<ul>
						<li></li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- end sidebars -->
		<div style="clear: both;">&nbsp;</div>
	</div>
	<!-- end page -->
</div>
<div id="footer">
	<p class="copyright">&copy;&nbsp;&nbsp;2009 All Rights Reserved &nbsp;&bull;&nbsp;</p>
	<p class="link"><a href="#">Privacy Policy</a>&nbsp;&#8226;&nbsp;<a href="#">Terms of Use</a></p>
</div>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsEdit);
?>
