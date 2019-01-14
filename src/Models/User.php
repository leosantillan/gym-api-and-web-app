<?php 

declare(strict_types = 1);

namespace VirtuaGym\Models;

use VirtuaGym\MyPDO;

class User
{
    protected $dbConn = false;
    protected $table = 'users';

    public function __construct(MyPDO $myPDO)
    {
        $this->dbConn = $myPDO;
    }

    public function getAll() : string
    {
        $sql = 'SELECT * FROM ' . $this->table;
        $result = $this->dbConn->select($sql);

        if (empty($result)) {
            $result = [
                'data' => [
                    'message' => 'No users found'
                ]
            ];
        }
        return json_encode($result);
    }

    public function getOne($id) : string
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $result = $this->dbConn->select($sql, ['id' => $id]);
        return json_encode($result);
    }

    public function add($data) : string
    {
        $result = $this->dbConn->insert($this->table, $data);
        return json_encode($result);
    }

    public function update($data, $id) : string
    {
        $this->dbConn->update($this->table, $data, $id);
        $resp = [
            'data' => [
                'message' => 'User updated successfully'
            ]
        ];
        return json_encode($resp);
    }

    public function delete($id) : string
    {
        $this->dbConn->delete($this->table, $id);
        $resp = [
            'data' => [
                'message' => 'User deleted successfully'
            ]
        ];
        return json_encode($resp);
    }
}
