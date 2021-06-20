<?php

namespace Local\Controllers;


use Local\Database\TaskMapper;
use Local\Database\UserMapper;
use Local\FileSystem;
use Local\Input\NewTaskValidator;
use Local\LoginManager;
use Local\Views\EditView;

class EditController extends PageController
{
	private $root;
	private $pdo;

	function __construct($root, $pdo)
	{
		parent::__construct();
		$this->root = $root;
		$this->pdo = $pdo;
	}

	function start()
	{
		//для редактирования задачи
		$taskmapper = new TaskMapper($this->pdo);
		//проверяем, имеет ли пользователь права на редактирование
		$userMapper = new UserMapper($this->pdo);
		$loginMan = new LoginManager($userMapper, $this->pdo);
		//проверяем логин пользователя (если есть)
		$authorized = $loginMan->isLogged();
		//админ ли?
		$isAdmin = $loginMan->isAdmin();
		if ($authorized and $isAdmin) {
			$statusChanged = $this->checkAndChangeStatus($_POST, $taskmapper);
			//проверяем в инпуте наличие айди, без него - исключение
			$taskID = $this->checkTaskID($_POST);
			$editResult = $this->checkAndChangeNewText($_POST, $taskmapper);
			//если успешно отредактировали текст -> возвращаемся на главную
			if ($editResult) {
				$this->redirect('list.php');
			} else {
				//если нет - показываем окошко редактирования
				$taskText = $taskmapper->getTask($taskID)->getText();
				$view = new EditView(FileSystem::append([$this->root, 'templates']));
				$view->render([
					'authorized' => $authorized,
					'task_id' => $taskID,
					'task_text' => $taskText
				]);
			}
		}
	}

	function checkAndChangeStatus($input, TaskMapper $taskmapper)
	{
		$result = false;
		if (array_key_exists('taskend', $input) and $input['taskend'] === '1') {
			if (array_key_exists('task_id', $input)) {
				$result = $taskmapper->changeStatus((int)$input['task_id'], true);
			}
		}
		return $result;
	}

	function checkTaskID($input)
	{
		if (array_key_exists('task_id', $input)) {
			return (int)$input['task_id'];
		} else throw new \Exception('ID задачи не указан перед редактированием. Аборт.');
	}

	function checkAndChangeNewText($input, TaskMapper $taskmapper)
	{
		//если отослана форма редактирования вместе с ID задачи
		if (array_key_exists('edit_form_sent', $input)
			and
			$input['edit_form_sent'] === '1'
			and
			$taskID = $this->checkTaskID($input)
		) {
			$validator = new NewTaskValidator();
			$newText = $validator->checkTaskText($input);
			$result = $taskmapper->changeText($taskID, $newText);
		} else $result = false;
		return $result;
	}
}
