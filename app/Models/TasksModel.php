<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ["id", "name", "duration", "is_special", "created_at"];
    protected $returnType = \App\Entities\Task::class;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "name" => "required",
        "duration" => "required|integer",
        "is_special" => "required"
    ];
    protected $validationMessages   = [
        "name" => [
            "required" => "Name field is required."
        ],
        "duration" => [
            "required" => "Duration field is required.",
            "integer" => "Duration value must be an integer."
        ],
        "is_special" => [
            "required" => "Is special field is required."
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ["beforeInsert"];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function beforeInsert($data){
        $data["data"]["created_at"] = gmdate("c");

        return $data;
    }

    public function getAllTasks(int $offset, int $limit){
        return $this->findAll($limit, $offset);
    }

    public function getTaskByID(int $id){
        return $this->find($id);
    }

    public function addTask(array $input){
        $val_result = $this->validate($input);

        if($val_result){
            $this->save($input);

            $created_object = $this->getTaskByID($this->getInsertID());

            return [
                "status" => "success",
                "data" => $created_object
            ];
        }
        else{
            return [
                "status" => "valerr",
                "errors" => $this->errors()
            ];
        }
    }
}
