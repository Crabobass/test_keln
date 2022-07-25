<?php

namespace Models;

use Core\Model;

class Guests extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'guests';
    }

    public function getAll()
    {
        $sql = "SELECT *"
            . " FROM " . $this->table
            . " ORDER BY id DESC";
        return $this->db->query($sql);
    }

    public function add($data)
    {
        if (empty($data['email']) || empty($data['name']) || empty($data['body']))
            return json_encode(['success' => false, 'data' => [], 'msg' => 'Все поля формы обязательны для заполнения']);

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            return json_encode(['success' => false, 'data' => [], 'msg' => 'Поле Email не валидно']);


        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars(strip_tags(trim($value)));
        }

        $data['dtime'] = date('Y-m-d H:i:s');

        $id = $this->create($data);

        if ($id) {
            $result = json_encode([
                'success' => true,
                'data' => [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'body' => $data['body'],
                ]
            ]);
        } else {
            $result = json_encode(['success' => false, 'data' => [], 'msg' => 'Не удалось добавить запись']);
        }

        return $result;
    }
}