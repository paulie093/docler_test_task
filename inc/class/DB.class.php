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
	
	public function update()
	{
		
	}
}
?>