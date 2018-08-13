<?php
class DB
{
	private $driver;
	private $host;
	private $username;
	private $password;
	private $database;
	private $conn;
	
	public function __construct()
	{
		$this->driver=config('driver');
		$this->host=config('host');
		$this->username=config('username');
		$this->password=config('password');
		$this->database=config('database');
		
		$this->connect();
		$this->set_char_encoding();
	}
	
	private function connect()
	{
		$dsn=$this->driver.':dbname='.$this->database.';host='.$this->host;
		$this->conn=new PDO($dsn,$this->username,$this->password);
		if ($this->conn->errorCode()) die('Could not connect to database: '.$this->conn->errorInfo());
	}
	
	private function set_char_encoding($charset='UTF8')
	{
		$this->query("SET NAMES `$charset`");
	}
	
	public function query($sql="")
	{
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		
		return $stmt;
	}
	
	public function select($table='',$cols='*',$where='1')
	{
		$query=$this->query("SELECT $cols FROM $table WHERE $where");
		$rows=$query->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	
	public function insert($table='',$data=[])
	{
		if (empty($table) || empty($data)) return false;
		
		$table_fields=array_keys($data);
		$placeholder=array_fill(0,sizeof($table_fields),'?');
		
		$stmt=$this->conn->prepare("INSERT INTO $table (".implode(', ',$table_fields).") VALUES (".implode(', ',$placeholder).")");
		$stmt->execute(array_values($data));
		
		if ($this->conn->errorCode()!="00000")
			return $this->conn->errorInfo();
		
		$new_id=intval($this->query("SELECT MAX(id) FROM $table")->fetch()[0]);
		return $new_id;
	}
	
	public function update($table='',$data=[],$where='1')
	{
		if (empty($table) || empty($data)) return false;
		
		foreach ($data as $key => $val)
			$set[]="`$key`='$val'";
		
		$this->query("UPDATE `$table` SET ".implode(',', $set)." WHERE $where");
		return true;
	}
	
	public function delete($table='',$where='1')
	{
		$this->query("DELETE FROM `$table` WHERE $where");
		return true;
	}
	
	public function begin()
	{
		$this->query("BEGIN");
	}
	
	public function commit()
	{
		$this->query("COMMIT");
	}
	
	public function rollback()
	{
		$this->query("ROLLBACK");
	}
}
?>