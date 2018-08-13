<?php
function config($idx='')
{
	$config=[];
	
	// database
	$config['driver']='mysql';
	$config['host']='localhost';
	$config['username']='root';
	$config['password']='';
	$config['database']='docler_test';
	
	// password generating
	$config['salt']='$1$docler$';
	
	if (!empty($idx)) return $config[$idx];
}
?>