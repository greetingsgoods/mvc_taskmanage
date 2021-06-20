<?php
/**
 * Created by PhpStorm.
 * User: Shinoa
 * Date: 07.08.2017
 * Time: 19:11
 */

namespace Local\Controllers;


use Local\Database\TaskMapper;
use Local\Database\UserMapper;
use Local\FileSystem;
use Local\Input\NewTaskValidator;
use Local\LoginManager;
use Local\Views\TaskView;

class TaskController extends PageController
{
	private $root;
	private $pdo;
	private $errors;

	function __construct($root, $pdo)
	{
		parent::__construct();
		$this->root = $root;
		$this->pdo = $pdo;
	}

	function start()
	{
		$this->execute();
		$this->regPage($this->root, $this->pdo);
	}

	protected function regPage($root, \PDO $pdo)
	{
		$userMapper = new UserMapper($pdo);
		$taskMapper = new TaskMapper($pdo);
		$validator = new NewTaskValidator();
		$loginMan = new LoginManager($userMapper, $pdo);
		//проверяем логин пользователя (если есть)
		$authorized = $loginMan->isLogged();
		//если залогинены - запоминаем имя
		if ($authorized === true) {
			$usernameDisplayed = $loginMan->getLoggedName();
		} else {
			$usernameDisplayed = '';
		}

		$dataBack = array();  // значения неправильных входных данных

		//проверяем, были ли посланы данные формы
		if ($validator->dataSent($_POST)) {
			//проверяем, правильно ли они заполнены
			$data = $validator->checkInput($_POST, $this->errors);
			if ($data !== false) {
				//если пользователь авторизован - используем его аккаунт, иначе аккаунт Гостя
				$taskUsername = $authorized ? $usernameDisplayed : 'Guest';
				$userID = $userMapper->getIdFromName($taskUsername);

				//добавляем запись с расчитанными и проверенными параметрами
				$taskMapper->addTask($userMapper, $userID, $data['email'], $data['task_text']);
				$this->redirect('list.php?taskAdded');
			} else {
				$dataBack['email'] = $_POST['email'];
				$dataBack['task_text'] = $_POST['task_text'];
			}
		}

		$view = new TaskView(FileSystem::append([$root, '/templates']));
		$view->render([
			'errors' => $this->errors,
			'messages' => $this->messages,
			'databack' => $dataBack,
			'authorized' => $authorized,
			'username' => $usernameDisplayed
		]);
	}
}
