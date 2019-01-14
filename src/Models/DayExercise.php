<?php 

declare(strict_types = 1);

namespace VirtuaGym\Models;

use VirtuaGym\MyPDO;

class DayExercise
{
    protected $dbConn = false;
    protected $table = 'day_exercises';

    public function __construct(MyPDO $myPDO)
    {
        $this->dbConn = $myPDO;
    }

    public function getByDayId($id) : string
    {
        $sql = 'SELECT DE.id, DE.id_day, D.name as day, E.name AS exercise 
                FROM ' . $this->table .' DE
                LEFT JOIN days D ON DE.id_day = D.id
                LEFT JOIN exercises E ON DE.id_exercise = E.id
                WHERE DE.id_day = ?';
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

    public function getDayById($id) : string
    {
        $sql = 'SELECT id, name 
                FROM days
                WHERE id = ?';
        $result = $this->dbConn->select($sql, [$id]);

        if (empty($result)) {
            $result = [
                'data' => [
                    'message' => 'Day not found'
                ]
            ];
        }
        return json_encode($result);
    }

    public function getExercises() : string
    {
        $sql = 'SELECT id, name AS exercise 
                FROM exercises
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
