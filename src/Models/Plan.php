<?php 

declare(strict_types = 1);

namespace VirtuaGym\Models;

use VirtuaGym\MyPDO;

class Plan
{
    protected $dbConn = false;
    protected $table = 'plans';

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
                    'message' => 'No plans found'
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
        $plan = [
            'name' => $data['name']
        ];
        $result = $this->dbConn->insert($this->table, $plan);

        if (isset($data['days'])) {
            foreach ($data['days'] as $day) {
                $tmp['id_plan'] = $result['id'];
                $tmp['id_day'] = $day['id'];
                $this->dbConn->insert('plan_days', $tmp)['id'];
            }
        }
        return json_encode($result);
    }

    public function update($data, $id) : string
    {
        $this->dbConn->update($this->table, $data, $id);
        $resp = [
            'data' => [
                'message' => 'Plan updated successfully'
            ]
        ];
        return json_encode($resp);
    }

    public function delete($id) : string
    {
        $this->dbConn->delete($this->table, $id);
        $resp = [
            'data' => [
                'message' => 'Plan deleted successfully'
            ]
        ];
        return json_encode($resp);
    }
}
