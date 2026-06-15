<?php

Class Database{
 
private $server = "";
private $username = "";
private $password = "";

public function __construct() {
    $this->server   = "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME');
    $this->username = getenv('DB_USER');
    $this->password = getenv('DB_PASS');
}
	private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
	protected $conn;
 	
	public function open(){
 		try{
 			$this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
 			return $this->conn;
 		}
 		catch (PDOException $e){
 			echo "There is some problem in connection: " . $e->getMessage();
 		}
 
    }
 
	public function close(){
   		$this->conn = null;
 	}
 
}

$pdo = new Database();
 
?>