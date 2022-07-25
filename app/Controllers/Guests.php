<?php

namespace Controllers;

use Core\Controller;

class Guests extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->guestModel = $this->model('Models\Guests');
    }

    /**
     * @param $data
     * @return void
     */
    public function index($data): void
    {
        $this->data['guests'] = $this->guestModel->getAll();

        $this->view('Guests', $this->data);
    }

    /**
     * @param $data
     * @return void
     */
    public function add($data): void
    {
        if (isset($data) && !empty($data)) {
          $res = $this->guestModel->add($data);
          echo $res;
        }

    }
}
