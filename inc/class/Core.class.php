<?php
class Core
{
	use common;
	
	protected $db;
	
	public function __construct()
	{
		global $db;
		
		$this->db=$db;
	}
}
?>