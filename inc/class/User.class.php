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
			$password=crypt(trim($data['password']),config('salt'));
			
			if (count($user_data)!=1)
				throw new Exception("This email is not registered in the database!");
			if ($user_data[0]['password']!=$password)
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
		if (empty($data)) return false;
		
		try
		{
			// begin transaction
			$this->db->begin();
			
			unset($data['register']);
			$existing_id=$this->db->select('users','id',"email LIKE '".$data['email']."' AND active=1")[0]['id'];
			
			// form validation
			if (intval($existing_id)>0)
				throw new Exception("This email address is already in use!");
			if (trim($data['password'])!=trim($data['password_agn']))
				throw new Exception("The entered passwords do not match!");
			if (strlen(trim($data['password']))<8)
				throw new Exception("Password must be at least 8 characters long!");
			if (preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)/', $data['password'])==0)
				throw new Exception("Password must contain at least one lowercase and uppercase letter, one digit and one special character!");
			
			// check if there is already an account with the email that is yet to be confirmed
			$confirm_exists=$this->db->select('confirm INNER JOIN users ON confirm.user_id=users.id','*',"email LIKE '".$data['email']."'");
			if (count($confirm_exists)>0) throw new Exception("An account with this email is yet to be confirmed! Please check your inbox.");
			
			// generate password hash
			unset($data['password_agn']);
			$data['password']=$password=crypt(trim($data['password']),config('salt'));
			
			// add user to users table
			$new_id=$this->db->insert('users',$data);
			if (is_string($new_id)) throw new Exception($new_id);
			
			$hash=md5($data['email'].'_'.date('YmdHis').rand(100000,999999));
			
			// add confirm data to confirm table
			$confirm_data= [
				'user_id' => $new_id,
				'session_id' => session_id(),
				'hash' => $hash
			];
			
			$confirm_insert=$this->db->insert('confirm',$confirm_data);
			if (is_string($confirm_insert)) throw new Exception($confirm_insert);
			
			// mail sending part
			$subject="Activate your account";
			$message="Please activate your account via this link: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]&passkey=$hash&email=$data[email]";
			if (!$this->send_mail($data['email'],$subject,$message))
				throw new Exception("Could not send the verification email!");
			
			// commit
			$this->db->commit();
			return $new_id;
		}
		catch (Exception $e)
		{
			// rollback if error occurs
			$this->db->rollback();
			return $e->getMessage();
		}
	}
	
	private function send_mail($to='',$subject='',$message='')
	{
		if (empty($to) || empty($subject) || empty($message)) return false;
		
		// add Mail PEAR library
		include('Mail.php');
		
		$recipients=$to;
		
		$headers = [];
		$headers['From']    = 'laurinyecz.pal.1993@gmail.com';
		$headers['To']      = $to;
		$headers['Subject'] = $subject;
		
		$body = $message;
		
		$mail =& Mail::factory('smtp',config('smtp'));
		return $mail->send($recipients,$headers,$body);
	}
	
	public function confirm_user($passkey='',$email='')
	{
		if (empty($passkey) || empty($email)) return false;
		
		// check if this email is yet to be confirmed
		$confirm=$this->db->select('confirm INNER JOIN users ON confirm.user_id=users.id','confirm.*',"email LIKE '".trim($email)."' AND hash='$passkey' AND session_id='".session_id()."' AND active=0")[0];
		if (!is_array($confirm))
		{
			header('location: ?q=login');
			exit;
		}
		
		// update active field
		$update=$this->db->update('users',['active'=>1],"id='".$confirm['user_id']."'");
		// delete confirm field
		$delete=$this->db->delete('confirm',"id='".$confirm['id']."'");
		
		header('location: ?q=login');
		exit;
	}
}
?>
