<?php
class User extends Core
{
	private $name;
	
	public function __construct($email='')
	{
		parent::__construct();
		
		if (!empty($email))
		{
			$name=$this->db->select('users','name',"email LIKE '".trim($email)."'")[0]['name'];
			if (!empty($name)) $this->name=$name;
		}
	}
	
	public function login_check($data=[])
	{
		try
		{
			$user_data=$this->db->select('users','email,password,active',"email LIKE '".trim($data['email'])."'");
			
			if (count($user_data)!=1)
				throw new Exception("This email is not registered in the database!");
			if ($user_data[0]['password']!=trim($data['password']))
				throw new Exception("Passwords do not match!");
			if ($user_data[0]['active']==0)
				throw new Exception("The user is not yet confirmed!");
			
			$_SESSION['docler']['email']=$user_data[0]['email'];
			$_SESSION['docler']['logged_in']=true;
			
			header('location: ?q=greet');
			exit;
		}
		catch (Exception $e)
		{
			$msg=$e->getMessage();
			
			$log=new Log();
			$log->login_error_log($msg,$data['email']);
			
			return $msg;
		}
	}
	
	public function logout()
	{
		session_unset($_SESSION['docler']);
		header('location: ?q=login');
		exit;
	}
	
	public function get_name()
	{
		return $this->name;
	}
	
	public function register($data=[])
	{
		print_r($data);
	}
}
?>