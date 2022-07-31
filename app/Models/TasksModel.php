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

    public function updateTask(int $id, array $input){
        if(empty($this->getTaskByID($id))){
            return [
                "status" => "notfound"
            ];
        }

        //removing empty entries from input
        foreach($input as $key => $value){
            if(empty($value)){
                unset($input[$key]);
            }
        }

        $validation_rules = [
            "duration" => "integer"
        ];
        $validation_messages = [
            "integer" => "Duration value must be an integer."
        ];

        $this->validation->setRules($validation_rules, $validation_messages);
        $val_result = $this->validation->run($input);

        if($val_result){
            $this->update($id, $input);

            $updated_object = $this->getTaskByID($id);

            return [
                "status" => "success",
                "data" => $updated_object
            ];
        }
        else{
            return [
                "status" => "valerr",
                "errors" => $this->errors()
            ];
        }
    }

    public function deleteTask(int $id){
        $result = $this->getTaskByID($id);

        if(empty($result)){
            return [
                "status" => "notfound"
            ];
        }

        $object_to_delete = $result;
        $this->delete($id);

        return [
            "status" => "success",
            "data" => $object_to_delete
        ];
    }
}
