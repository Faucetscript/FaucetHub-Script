<?php
session_start();
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'Smarty.class.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

spl_autoload_register(function($className) {
	$path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $className . '.php';
	if(file_exists($path)) {
		require_once $path;
	} else {
		$path = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';
		if(file_exists($path)) {
			require_once $path;
		}
	}

});

$db = DB::getInstance();

$csrf = new CSRF;
$smarty = new Smarty;

//$smarty->force_compile = true;
$smarty->debugging = false;
$smarty->caching = false;
$smarty->cache_lifetime = 0;