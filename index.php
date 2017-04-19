<?php
session_start();
//Загальні налаштування
ini_set('display_errors', 0);
error_reporting(E_ALL);
//Підключення файлів системи
define('ROOT', dirname(__FILE__));
define('access', true);
date_default_timezone_set('Europe/Warsaw');

require_once(ROOT.'/config/configName.php');
require_once(ROOT.'/components/Router.php');
require_once(ROOT.'/components/DB.php');
require_once(ROOT.'/views/view.php');

//Виклик Router
$router = new Router();
$view = new View();
$settings = new Settings();

$router->run();

require_once (ROOT.'/views/template.php');