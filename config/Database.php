<?php
class Database
{
	private static $dbhost = "localhost";
	private static $dbname = "sunshica_juniorartists";
	private static $dbuser = "sunshica_juniora";
	private static $dbpass = "+-TfyVN2}c)L";
	private static $dbconn = null;
	const BASE_URL = "http://juniorartists.sunshinehosting.ca/";

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
