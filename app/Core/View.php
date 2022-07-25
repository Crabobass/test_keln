<?php

namespace Core;

class View
{
    private $viewsPath;

    private static View $instance;

    private function __construct()
    {
        $conf = Conf::getInstance();
        $confData = $conf->getConfigurations();
        $this->viewsPath = $confData['app']['app_path'] . '/Views/';

        return $this;
    }

    /**
     * @return View
     */
    public static function getInstance(): View
    {
        if (empty(self::$instance)) {
            self::$instance = new View();
        }

        return self::$instance;
    }

    /**
     * @param $view
     * @param $data
     * @return void
     */
    public function render($view, $data = []): void
    {
        extract($data);
        require_once $this->viewsPath . $view . '.php';
    }
}