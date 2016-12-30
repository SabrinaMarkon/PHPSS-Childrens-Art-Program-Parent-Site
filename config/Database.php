<?php
class Database
{
	private static $dbhost = "DATABASE_HOST";
	private static $dbname = "DATABASE_NAME";
	private static $dbuser = "DATABASE_USERAME";
	private static $dbpass = "DATABASE_PASSWORD";
	private static $dbconn = null;
	const BASE_URL = "http://yourdomain.com/";

	public function __construct() {
		die('Action not allowed'); 
	}

	public static function connect() {
		# one connection for whole program
		if (null == self::$dbconn) {

			try
			{
				self::$dbconn = new PDO("mysql:host=" . self::$dbhost . ";dbname=" . self::$dbname, self::$dbuser, self::$dbpass);
			}
			catch(PDOException $e)
			{
				echo 'Connection failed: ' . $e->getMessage();
				exit;
			}
		}
		return self::$dbconn;
	}

	public static function disconnect() {
		self::$dbconn = null;
	}

}
