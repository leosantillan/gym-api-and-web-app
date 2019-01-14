<?php 

declare(strict_types = 1);

namespace VirtuaGym;

use PDO;

class MyPDO extends PDO
{
    public function __construct($dsn, $username, $password, $options = []) 
    {
        parent::__construct($dsn, $username, $password, $options);
    }

    public function select($sql, $args = NULL) 
    {
        $stmt = $this->prepare($sql);
        $stmt->execute($args);
        $result = $stmt->fetchAll(MyPDO::FETCH_ASSOC);
        return $result;
    }

    public function insert($table, $data) 
    {
        $query = 'INSERT INTO ' . $table . ' (' . $this->insertFields($data)['fields'] . ') VALUES (' . $this->insertFields($data)['values'] .')';
        $stmt = $this->prepare($query);
        if ($stmt->execute($data)) {
            $data['id'] = $this->lastInsertId();
            return $data;
        }
    }

    public function update($table, $data, $id) 
    {
        $data['id'] = $id;
        $query = 'UPDATE ' . $table . ' SET ' . $this->bindFields($data) .' WHERE id = :id';
        $stmt = $this->prepare($query);
        return $stmt->execute($data);
    }

    public function delete($table, $id) 
    {
        $query = 'DELETE FROM ' . $table . ' WHERE id = ?';
        $stmt = $this->prepare($query);
        return $stmt->execute([$id]);
    }

    public function insertFields($fields)
    {
        $str_fields = $str_values = $sep = '';
        foreach($fields as $field => $data){ 
            $str_fields .= $sep . '' . $field;
            $str_values .= $sep . ':' . $field;
            $sep = ', ';
        }
        $string['fields'] = $str_fields;
        $string['values'] = $str_values;
        return $string;
    }

    public function bindFields($fields){
        end($fields); $lastField = key($fields);
        $bindString = ' ';
        foreach($fields as $field => $data){ 
            $bindString .= $field . '=:' . $field; 
            $bindString .= ($field === $lastField ? ' ' : ',');
        }
        return $bindString;
    }
}
