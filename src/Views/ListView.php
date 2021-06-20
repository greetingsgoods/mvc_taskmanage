<?php

namespace Local\Views;


use Local\FileSystem;

class ListView extends CommonView
{
	/**
	 * EntityListView constructor.
	 * @param string $templatesDir
	 */
	function __construct($templatesDir)
	{
		parent::__construct($templatesDir);
		$loader = new \Twig\Loader\FilesystemLoader([FileSystem::append([$templatesDir, 'List']), $templatesDir]);
		$this->twig = new \Twig\Environment($loader, array(
			'cache' => FileSystem::append([$templatesDir, 'cache']),
			'auto_reload' => true,
			'autoescape' => 'html',
			'strict_variables' => true
		));
	}

	/**
	 * Loads all values and preferences for a template, then loads the template into string.
	 * @return string html page
	 * @throws \Exception
	 * @var $params array Link to the params array, from which are retrieved all the data.
	 */
	public function output($params)
	{
		ob_start();
		$tasks = $params['tasks'];
		$messages = $params['messages'];
		$queries = $params['queries'];
		//параметры для навбара-логина
		$authorized = $params['authorized'];
		$isAdmin = $params['is_admin'];
		$usernameDisplayed = $params['username'];

		if ($tasks === false) {
			$messages[] = 'Результат: ничего не найдено.';
		} else {
			foreach ($tasks as $task) {
				$array = $task->getArray();
				//вручную меняем php-значения на их текстовый вид
				if ($array['taskend'] === false) {
					$array['taskend'] = 'Не выполнено';
				} else {
					$array['taskend'] = 'Выполнено';
				}
				//наконец, добавляем массив в список задач
				$content[] = $array;
			}
			$tasks = $content;
		}

		//загружаем шаблон, который использует вышеописанные переменные
		$template = $this->twig->load('list.html.twig');
		echo $template->render(array(
			'tasks' => $tasks,
			'messages' => $messages,
			'queries' => $queries,
			'authorized' => $authorized,
			'is_admin' => $isAdmin,
			'username' => $usernameDisplayed
		));
		return ob_get_clean();
	}
}
