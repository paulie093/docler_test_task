<?php
class Log extends Core
{
	public function login_error_log($msg='',$email='')
	{
		if (!empty($msg) && !empty($email))
		{
			$insert_data=
			[
				'description' => $msg,
				'email' => trim($email),
				'ip_address' => $this->get_client_ip(),
				'session_id' => session_id()
			];
			
			$insert=$this->db->insert(strtolower(__CLASS__),$insert_data);
		}
	}
}
?>