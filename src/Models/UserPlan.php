<?php 

declare(strict_types = 1);

namespace VirtuaGym\Models;

use VirtuaGym\MyPDO;

class UserPlan
{
    protected $dbConn = false;
    protected $table = 'user_plans';

    public function __construct(MyPDO $myPDO)
    {
        $this->dbConn = $myPDO;
    }

    public function getByUserId($id) : string
    {
        $sql = 'SELECT PU.id, PU.id_plan, P.name as plan, CONCAT(U.firstname, " ", U.lastname) AS user 
                FROM ' . $this->table .' PU
                LEFT JOIN plans P ON PU.id_plan = P.id
                LEFT JOIN users U ON PU.id_user = U.id
                WHERE PU.id_plan = ?';
        $result = $this->dbConn->select($sql, [$id]);

        if (empty($result)) {
            $result = [
                'data' => [
                    'message' => 'No assignations found'
                ]
            ];
        }
        return json_encode($result);
    }

    public function getPlanById($id) : string
    {
        $sql = 'SELECT id, name 
                FROM plans
                WHERE id = ?';
        $result = $this->dbConn->select($sql, [$id]);

        if (empty($result)) {
            $result = [
                'data' => [
                    'message' => 'Plan not found'
                ]
            ];
        }
        return json_encode($result);
    }

    public function getEmailByUserId($id) : string
    {
        $sql = 'SELECT email 
                FROM users
                WHERE id = ?';
        $result = $this->dbConn->select($sql, [$id]);

        if (empty($result)) {
            $result = [
                'data' => [
                    'message' => 'User not found'
                ]
            ];
        }
        return json_encode($result);
    }

    public function getUsers() : string
    {
        $sql = 'SELECT id, CONCAT(firstname, " ", lastname) AS user 
                FROM users
                ORDER BY lastname, firstname';
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

    public function add($data) : string
    {
        $result = $this->dbConn->insert($this->table, $data);
        return json_encode($result);
    }

    public function delete($id) : string
    {
        $this->dbConn->delete($this->table, $id);
        $resp = [
            'data' => [
                'message' => 'OK'
            ]
        ];
        return json_encode($resp);
    }
}
