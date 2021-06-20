<?php
/**
 * Created by PhpStorm.
 * User: Shinoa
 * Date: 08.08.2017
 * Time: 2:57
 */

namespace Local\Views;


use Local\FileSystem;

class EditView extends CommonView
{
	function __construct($templatesDir)
	{
		parent::__construct($templatesDir);
		$loader = new \Twig\Loader\FilesystemLoader([FileSystem::append([$templatesDir, 'Edit']), $templatesDir]);
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

		//загружаем шаблон, который использует вышеописанные переменные
		$template = $this->twig->load('edit.html.twig');
		echo $template->render(array(
			'task_id' => $params['task_id'],
			'task_text' => $params['task_text']
		));
		return ob_get_clean();
	}
}
