<?php

$class_version["database"] = array('module', '1.0.0.0.1', 'Nema opisa');

class Database {
	private $_connection;
	private static $_instance; //The single instance
	private $_host = ADMIN_DB_HOST;
	private $_username = ADMIN_DB_USER;
	private $_password = ADMIN_DB_PASS;
	private $_database = ADMIN_DB_NAME;


	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	// Constructor
	private function __construct() {

		$this->_connection = new mysqli($this->_host, $this->_username,
			$this->_password, $this->_database);
	
		// Error handling
		if(mysqli_connect_error()) {

//			trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(),
//				 E_USER_ERROR);
			throw new Exception("Failed to conencto to MySQL: " . mysqli_connect_error());
		}
	}
	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }
	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}
/*
$db = Database::getInstance();
    $mysqli = $db->getConnection(); 
    $sql_query = "SELECT foo FROM .....";
    $result = $mysqli->query($sql_query);
*/
?>