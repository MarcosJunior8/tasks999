<?php

namespace App\Controllers;

use UNIS\Controller\Action;
use UNIS\Di\Container;
use App\Models\TaskResult;
use App\views\tabelaindex;

class Index extends Action
{
	private $task;

	public function __construct()
	{
		parent::__construct();
		$this->task = Container::getClass('task');
	}

	public function index()
	{
		if(!is_null($this->getParam())) {
			$this->view->result = $this->getParam();
		}

		$this->view->taskList = $this->task->fetchAll();
		
		
		$this->render('index');
	}

	public function add()
	{
		$addResult = TaskResult::ADD_OK;
		if($this->task->add($_POST) !== true) {
			$addResult = TaskResult::ADD_ERROR;
		}
		
		$this->redirect("/index/{$addResult}");
	}
	public function delete()
	{
		
		$result = $this->task->delete($this->getParam());
		
		$deleteResult = TaskResult::DELETE_ERROR;
		if($result === 1) {
			$deleteResult = TaskResult::DELETE_OK;
		}
		if($result === 0) {
			$deleteResult = null;
		}

		$this->redirect("/index/{$deleteResult}");
	}
}