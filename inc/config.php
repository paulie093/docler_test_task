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
	
	if (!empty($idx)) return $config[$idx];
}
?>