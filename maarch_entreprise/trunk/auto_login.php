<?php

require_once("../../core/class/class_functions.php");
require_once("../../core/class/class_db.php");
require_once("../../core/class/class_history.php");	
require_once("../../core/class/class_core_tools.php");
//require_once("../../core/class/class_security.php");	
//exit();

$core_tools = new core_tools();
//$_SESSION['custom_override_id'] = $core_tools->get_custom_id();
chdir("../..");


$core_tools = new core_tools();
$core_tools->load_lang();
$func = new functions();

print_r($_POST);
if(isset($_POST['login']))
{
	$test_user = $POST['login'];
	
	$sec->login($s_login,$pass);
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
</head> 
<title>Mon_Titre</title> 

<body> 
<form action="" method="post" name="connect"> 
<SCRIPT language="javascript"> 
var WShnetwork = new ActiveXObject('WScript.Network'); 
var actual_username = WShnetwork.UserName;

window.alert(actual_username);
document.write('<input type="hidden" name="login" value="' + WShnetwork.UserName + '">');
submit();
//window.location.href="<?php  echo $_SESSION['config']['businessappurl'];?>auto_login.php";
</SCRIPT> 
</form>
</body>
</html>
