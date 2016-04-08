<?php
/** 
 * Database configuration
 */
class db_config
{
    static $confArray;

    public static function read($name)
    {
        return self::$confArray[$name];
    }

    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }

}

db_config::write('host', 'localhost');
db_config::write('user', 'root');
db_config::write('pass', '');
db_config::write('db', 'mafianations');


/**
 * Database core connection
 */
class db_core extends PDO
{
    public $conn;
    private static $instance;
    
    public function __construct () 
    {
	try 
	{
	    $this->conn = new PDO("mysql:host=".db_config::read('host').";dbname=".db_config::read('db'), db_config::read('user'), db_config::read('pass'));
	    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    
	} 
	catch (PDOException $e) 
	{
	    echo "Error:". $e;
	}
    }
    
    public static function getInstance()
    {
        if (!isset(self::$instance))
        {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        return self::$instance;
    }
}

class pdo_instance extends PDO {
    public function getLast($id = null) {
        return $this->lastInsertId($id);
    }
}
?>
