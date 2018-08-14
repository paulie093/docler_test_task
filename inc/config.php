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
	
	// SMTP mail
	$config['smtp']=['host'=>'localhost','port'=>25,'auth'=>false];
	$config['mail_from']='doclertest@lpteszt.nhely.hu';
	
	if (!empty($idx)) return $config[$idx];
}
?>