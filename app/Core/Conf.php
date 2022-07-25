<?php

namespace Core;

class Conf
{
    public $configurations = [];

    private static $instance;

    private function __construct()
    {
        $this->prepareConfigurations();
    }

    /**
     * @return void
     */
    private function prepareConfigurations(): void
    {
        $this->configurations = require ROOT_APP . 'config.php';;
    }

    /**
     * @return array
     */
    public function getConfigurations(): array
    {
        return $this->configurations;
    }

    /**
     * @return Conf
     */
    public static function getInstance(): Conf
    {
        if (empty(self::$instance)) {
            self::$instance = new Conf();
        }

        return self::$instance;
    }
}