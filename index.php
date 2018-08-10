<?php
session_start();
include_once 'inc/config.php';

spl_autoload_register(function($class)
{
	$include="inc/class/$class.class.php";
    if (file_exists($include)) require_once $include;
	else die('Include error: '.$include);
});

try
{
	$db = new DB();
	
	$cucc = $db->select('users');
	
	print "<pre>"; var_dump($cucc); print "</pre>";
}
catch (Exception $e)
{
	print "Fatal error: ".$e->getMessage();
}
?>