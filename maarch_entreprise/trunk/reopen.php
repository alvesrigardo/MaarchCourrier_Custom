<?php
/**
* File : reopen.php
*
* Identification with cookie
*
* @package  Maarch PeopleBox 1.0
* @version 2.1
* @since 10/2005
* @license GPL
* @author  Claire Figueras  <dev@maarch.org>
*/
session_name('PeopleBox');
session_start();
/*if( strtoupper(substr(PHP_OS, 0, 3)) != "WIN")
{
	$_SESSION['slash_env'] = "/";
}
else
{
	$_SESSION['slash_env'] = "\\";
}*/
$_SESSION['slash_env'] = DIRECTORY_SEPARATOR;

$path_tmp = explode('/',$_SERVER['SCRIPT_FILENAME']);
$path_server = implode('/',array_slice($path_tmp,0,array_search('apps',$path_tmp))).'/';

$_SESSION['pathtocore'] = $path_server."core".DIRECTORY_SEPARATOR;
$_SESSION['pathtocoreclass'] = $path_server."core".DIRECTORY_SEPARATOR."class".DIRECTORY_SEPARATOR;
$_SESSION['pathtomodules'] = $path_server."modules".DIRECTORY_SEPARATOR;

$_SESSION['urltomodules'] = $_SESSION['config']['coreurl']."/modules/";
require_once($_SESSION['pathtocoreclass']."class_functions.php");
require_once($_SESSION['pathtocoreclass']."class_db.php");
require_once($_SESSION['pathtocoreclass']."class_core_tools.php");
require_once("class/class_business_app_tools.php");
$core_tools = new core_tools();
$business_app_tools = new business_app_tools();
$func = new functions();
$cookie = explode("&",$_COOKIE['maarch']);
$user = explode("=",$cookie[0]);
$thekey = explode("=",$cookie[1]);
$s_UserId = strtolower($func->wash($user[1],"no","","yes"));
$s_key =strtolower($func->wash($thekey[1],"no","","yes"));
if(!empty($_SESSION['error']) || ($s_UserId == "1" && $s_key == ""))
{
	header("location: ".$_SESSION['config']['businessappurl']."login.php?coreurl=".$_SESSION['config']['coreurl']);
	exit();
}
else
{
	if(trim($_SERVER['argv'][0]) <> "")
	{
		header("location: ".$_SESSION['config']['businessappurl']."login.php?coreurl=".$_SESSION['config']['coreurl']."&".$_SERVER['argv'][0]);
	}
	else
	{
		header("location: ".$_SESSION['config']['businessappurl']."login.php?coreurl=".$_SESSION['config']['coreurl']);
	}
	exit();
	/*$pass = md5($s_pass);
	require($_SESSION['pathtocoreclass']."class_security.php");
	$sec = new security();
	//$sec->show_array($_SESSION);
	//$sec->build_config();
	$sec->reopen($s_UserId,$s_key);*/
}
?>
