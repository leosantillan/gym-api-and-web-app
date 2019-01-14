<?php 

declare(strict_types = 1);

namespace VirtuaGym\Models;

use VirtuaGym\MyPDO;

class PlanDay
{
    protected $dbConn = false;
    protected $table = 'plan_days';

    public function __construct(MyPDO $myPDO)
    {
        $this->dbConn = $myPDO;
    }

    public function getByPlanId($id) : string
    {
        $sql = 'SELECT PD.id, PD.id_plan, P.name as plan, D.name AS day 
                FROM ' . $this->table .' PD
                LEFT JOIN plans P ON PD.id_plan = P.id
                LEFT JOIN days D ON PD.id_day = D.id
                WHERE PD.id_plan = ?';
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

    public function getDays() : string
    {
        $sql = 'SELECT id, name AS day 
                FROM days
                ORDER BY name';
        $result = $this->dbConn->select($sql);

        if (empty($result)) {
            $result = [
                'data' => [
                    'message' => 'No exercises found'
                ]
            ];
        }
        return json_encode($result);
    }

    public function getEmailUsersByPlanId($id) : string
    {
        $sql = 'SELECT U.email 
                FROM user_plans UP
                LEFT JOIN users U ON UP.id_user = U.id
                WHERE UP.id_plan = ?';
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
