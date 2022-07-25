<?php

namespace Core;

class Database
{
    private $connection;

    private static $instance;

    private function __construct()
    {

        $conf = Conf::getInstance();
        $confData = $conf->getConfigurations();

        $this->connection = new \mysqli(
            $confData['db']['host'],
            $confData['db']['user'],
            $confData['db']['password'],
            $confData['db']['database']
        );

        if ($this->connection->connect_errno) {
            throw new \Exception('Could not connect to DB. Error: ' . $this->connection->connect_error);
        }

        $this->connection->set_charset('utf8');
    }

    /**
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (empty(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * @param $sql
     * @return array|bool
     * @throws \Exception
     */
    public function query($sql): bool|array
    {
        if (!$this->connection) {
            return false;
        }

        $result = $this->connection->query($sql);

        if ($this->connection->error) {
            throw new \Exception($this->connection->error);
        }

        if (is_bool($result)) {
            return $result;
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * @param $str
     * @return string
     */
    public function escape($str): string
    {
        return $this->connection->real_escape_string($str);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function escapeArray($data): mixed
    {
        foreach ($data as $key => $value) {
            $data[$key] = $this->escape($value);
        }

        return $data;
    }

    /**
     * @return mixed
     */
    public function getInsertedId(): mixed
    {
        return $this->connection->insert_id;
    }
}
