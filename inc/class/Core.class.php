<?php
class Core
{
	protected $db;
	
	public function __construct()
	{
		global $db;
		
		$this->db=$db;
	}
}
?>