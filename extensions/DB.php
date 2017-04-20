<?php
class DB
{
	public static function getConnection()
	{
		if(!defined('access')){
			$paramsPath = ($_SERVER['DOCUMENT_ROOT'].'/config/db_params.php');
		}
		else{
			$paramsPath = ROOT.'/config/db_params.php';
		}
		$params = include ($paramsPath);
		
		$dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
		try 
		{
			$db = new PDO($dsn, $params['user'], $params['password']);
			$db->exec("SET time_zone='Europe/Warsaw'");
		}
		catch (PDOException $e) 
		{
			die('Подключение не удалось...');// . $e->getMessage());
		}

		return $db;
	}
}