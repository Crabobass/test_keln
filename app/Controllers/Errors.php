<?php

namespace Controllers;

use Core\Controller;

class Errors extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

    /**
     * @param $data
     * @return void
     */
	public function index($data = []): void
    {
        $this->show404();
	}
}