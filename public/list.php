<?php

use Local\Controllers\ListController;
use Local\ErrorHelper;
use Local\FileSystem;

$root = dirname(__FILE__, 2);
//автозагрузчик и объект PDO
require_once($root . '/bootstrap.php');
//обработчик ошибок
$errorHelper = new ErrorHelper(FileSystem::append([$root, 'templates']));
try {
	$controller = new ListController($root, $pdo);
	//обработка get параметров
	$controller->get('taskAdded', function ($key, $value, ListController $c) {
		$c->addMessage('Ваша задача успешно добавлена!');
	});
	$controller->start();

} catch (\Throwable $e) {
	$errorHelper->dispatch($e);
}
