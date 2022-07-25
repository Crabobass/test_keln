<?php

namespace Core;

use Exception;

abstract class Model
{
    protected $db;

    protected $table = '';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * @param $data
     * @return array|bool
     * @throws Exception
     */
    public function create($data): bool|array
    {
        $data = $this->db->escapeArray($data);

        $sql = "INSERT INTO " . $this->table;

        $fields = array_map(function ($field) {
            return '`' . $field . '`';
        }, array_keys($data));
        $sql .= " (" . implode(', ', $fields) . ")";

        $values = array_map(function ($value) {
            return "'" . $value . "'";
        }, array_values($data));
        $sql .= " VALUES (" . implode(', ', $values) . ")";

        $result = $this->db->query($sql);

        if ($result) {
            $result = $this->db->getInsertedId();
        }
        return $result;
    }

    /**
     * @param $id
     * @return array|bool|mixed
     * @throws Exception
     */
    public function read($id = null): mixed
    {
        $sql = "SELECT * FROM " . $this->table;
        if ($id) {
            $sql .= " WHERE `id` = " . $id;
        }

        $result = $this->db->query($sql);

        return $id ? $result[0] : $result;
    }

    /**
     * @param $data
     * @param $id
     * @return array|bool
     * @throws Exception
     */
    public function update($data, $id): bool|array
    {
        $data = $this->db->escapeArray($data);

        $sql = "UPDATE " . $this->table . " SET ";
        foreach ($data as $key => $value) {
            $sql .= " `{$key}` = '{$value}', ";
        }
        $sql = mb_substr($sql, 0, mb_strlen($sql) - 2);
        $sql .= " WHERE `id` = " . $id;

        return $this->db->query($sql);
    }

    /**
     * @param $id
     * @return bool|array
     * @throws Exception
     */
    public function delete($id): bool|array
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = {$id}";
        return $this->db->query($sql);
    }

    /**
     * @param $field
     * @param $value
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function checkUniqueFieldValue($field, $value, $id = null): bool
    {
        $value = $this->db->escape($value);
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $field . " = '{$value}'";
        if (isset($id)) {
            $sql .= " AND id <> {$id}";
        }

        $result = $this->db->query($sql);

        if (!isset($result) || empty($result)) {
            return true;
        }
        return false;
    }
}