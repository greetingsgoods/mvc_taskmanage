<?php

use Local\Controllers\TaskController;
use Local\ErrorHelper;
use Local\FileSystem;

$root = dirname(__FILE__, 2);
//автозагрузчик и объект PDO
require_once($root . '/bootstrap.php');
//обработчик ошибок
$errorHelper = new ErrorHelper(FileSystem::append([$root, 'templates']));
try {
	$controller = new TaskController($root, $pdo);
	$controller->start();
} catch (\Throwable $e) {
	$errorHelper->dispatch($e);
}
