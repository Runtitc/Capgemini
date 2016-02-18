<?php
class Database{
    private static $dbName = 'crud' ;
    private static $dbHost = '127.0.0.1' ;
    private static $dbUser = 'root';
    private static $dbPass = '';
     
    private static $cont  = null;
     
    public function __construct() {
        die('This is static class, so you cannot initiate object of that class.');
    }
     
    public static function connect(){
		if ( null == self::$cont ){     
			try
			{
			  self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUser, self::$dbPass);
			}
			catch(PDOException $e)
			{
			  die($e->getMessage()); 
			}
		}
		return self::$cont;
	}
     
    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>
