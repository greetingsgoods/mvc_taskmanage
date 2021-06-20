<?php

namespace Local\Views;

use Local\FileSystem;

class TaskView extends CommonView
{
	function __construct($templatesDir)
	{
		parent::__construct($templatesDir);
		$loader = new \Twig\Loader\FilesystemLoader([FileSystem::append([$templatesDir, 'NewTask']), $templatesDir]);
		$this->twig = new \Twig\Environment($loader, array(
			'cache' => FileSystem::append([$templatesDir, 'cache']),
			'auto_reload' => true,
			'autoescape' => 'html'
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
		$messages = $params['messages'];
		$errors = $params['errors'];
		$dataBack = $params['databack'];
		//параметры для навбара-логина
		$authorized = $params['authorized'];
		$usernameDisplayed = $params['username'];

		//загружаем шаблон, который использует вышеописанные переменные
		$template = $this->twig->load('newtask.html.twig');
		echo $template->render(array(
			'errors' => $errors,
			'messages' => $messages,
			'databack' => $dataBack,
			'authorized' => $authorized,
			'username' => $usernameDisplayed
		));
		return ob_get_clean();
	}
}
