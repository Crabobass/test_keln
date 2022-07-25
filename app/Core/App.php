<?php

namespace Core;

use Exception;

class App
{
    private $controller = 'Controllers\Guests';

    private $action = 'index';

    private $params = [];

    public function __construct()
    {
        //для первоначальной установки структуры базы
        if (isset($_GET['set_db_struct']) && $_GET['set_db_struct'] == 'true')
            $this->setDbStruct();

        $url = $this->parseUrl();
        $cont = 'Controllers\\';

        if (isset($url[0])) {
            $this->controller = $cont . ucfirst($url[0]);
            if (!class_exists($this->controller)) {
                $this->controller = $cont . 'Errors';
            }
        }

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
            } else {
                $this->controller = $cont . 'Errors';
            }
        }

        $this->controller = new $this->controller();

        $this->params['data'] = $_POST;

        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    /**
     * @return string[]|void
     */
    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    private function setDbStruct(): void
    {
        $sql = "CREATE TABLE `guests` (
                `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `dtime` DATETIME NOT NULL,
                `name` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
                `email` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
                `body` TEXT NOT NULL COLLATE 'utf8_unicode_ci',
                PRIMARY KEY (`id`),
                INDEX `dtime` (`dtime`)
            ) COLLATE='utf8_unicode_ci' ENGINE=InnoDB;";

        $DB = Database::getInstance();
        $DB->query($sql);
    }
}
