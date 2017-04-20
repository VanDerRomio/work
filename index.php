<?php
session_start();
//Загальні налаштування
ini_set('display_errors', 1);
error_reporting(E_ALL);
//Підключення файлів системи
define('ROOT', dirname(__FILE__));

date_default_timezone_set('Europe/Warsaw');

require_once(ROOT.'/config/configName.php');
require_once(ROOT.'/extensions/Router.php');
require_once(ROOT.'/extensions/DB.php');
require_once(ROOT.'/views/view.php');

//Виклик Router
$router = new Router();
$view = new View();

$router->run();

require_once (ROOT.'/views/template.php');