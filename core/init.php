<?php
require(dirname(__FILE__).'/config.php');

ini_set('display_errors', 1);

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type:text/html; charset=utf-8');

session_start();

try {
	$db = new PDO("mysql:host={$config['db']['hostname']}; dbname={$config['db']['database']}", $config['db']['username'], $config['db']['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'ailed to connect to database：' . $e->getMessage();
    exit();
}

spl_autoload_register('autoload'); 

function autoload($className) {
    include(dirname(__FILE__).'/../models/'.$className.'.php');
}

$scriptName = 'c_'.basename($_SERVER['PHP_SELF'], '.php');
$action = isset($_GET['action']) ? $_GET['action'] : "index";

$initScript = new $scriptName();

if(method_exists($initScript, $action)) {
    $initScript->$action();
} else {
    header('HTTP/1.1 404 Not Found');
    exit; 
}
