<?php 

declare(strict_types = 1);

namespace VirtuaGym\Models;

use VirtuaGym\MyPDO;

class Day
{
    protected $dbConn = false;
    protected $table = 'days';

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
                    'message' => 'No days found'
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
        $day = [
            'name' => $data['name']
        ];
        $result = $this->dbConn->insert($this->table, $day);

        if (isset($data['exercises'])) {
            foreach ($data['exercises'] as $exercise) {
                $tmp['id_day'] = $result['id'];
                $tmp['id_exercise'] = $exercise['id'];
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
                'message' => 'Day updated successfully'
            ]
        ];
        return json_encode($resp);
    }

    public function delete($id) : string
    {
        $this->dbConn->delete($this->table, $id);
        $resp = [
            'data' => [
                'message' => 'Day deleted successfully'
            ]
        ];
        return json_encode($resp);
    }
}
