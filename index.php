<?php
session_start();
include_once 'inc/config.php';

spl_autoload_register(function($class)
{
	$include="inc/class/$class.class.php";
	if (file_exists($include)) require_once $include;
	elseif (!file_exists($include)) include_once 'inc/trait/'.$class.'.trait.php';
	else die('Include error: '.$include);
});

try
{
	if (!isset($_SESSION['docler']))
	{
		$_SESSION['docler']['logged_in']=false;
	}
	
	$db = new DB();
	$redirect = false;
	
	if (isset($_REQUEST['q']))
	{
		$tpl_path='templates/'.$_REQUEST['q'].'.php';
		
		if (file_exists($tpl_path)) include_once $tpl_path;
		else $redirect=true;
	}
	else $redirect=true;
	
	if ($redirect)
	{
		header('location: ?q=login');
		exit;
	}
}
catch (Exception $e)
{
	print "Fatal error: ".$e->getMessage();
}
?>
