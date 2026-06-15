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

$username = getenv('DB_USER');
$password = getenv('DB_PASS');

try {
   $connection = new PDO('mysql:host=' . getenv('DB_HOST') . ';dbname=' . getenv('DB_NAME'), $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    die();
}
$servername = getenv('DB_HOST');
$dbname     = getenv('DB_NAME');";

// Create connection
$conne = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conne->connect_error) {
    header("location:connection_error.php?error=$conn->connect_error");
    die($conne->connect_error);
}
 
?>