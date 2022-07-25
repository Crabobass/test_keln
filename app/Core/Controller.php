<?php

namespace Core;

abstract class Controller
{
	protected $data = [];

	public function __construct()
	{
		if (isset($_SESSION['user']) ) {
			$this->data['user'] = $_SESSION['user'];
		}
	}

    /**
     * @param string $model
     * @return object
     */
	public function model(string $model): object
    {
		return new $model();
	}

    /**
     * @param $view
     * @param array $data
     * @return void
     */
	public function view($view, array $data = []): void
    {
        $viewInst = View::getInstance();
        $viewInst->render($view, $data);
	}

    /**
     * @return void
     */
    public function show404()
    {
        header("Status: 404 Not Found");
        $this->view('404');
        exit();
    }
}