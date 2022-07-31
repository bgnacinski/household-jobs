<?php

namespace App\Models;

use CodeIgniter\Model;

class PeopleModel extends Model
{
    protected $table            = 'people';
    protected $primaryKey       = 'id';
    protected $returnType       = \App\Entities\Person::class;
    protected $allowedFields    = ["name", "on_duty", "created_at"];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "name" => "required",
        "on_duty" => "required"
    ];
    protected $validationMessages   = [
        "name" => [
            "required" => "Name field is required."
        ],
        "on_duty" => [
            "required" => "On duty field is required."
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

    public function getAllPeople(int $offset, int $limit){
        return $this->findAll($limit, $offset);
    }

    public function getPersonByID(int $id){
        return $this->find($id);
    }

    public function addPerson(array $input){
        $val_result = $this->validate($input);

        if($val_result){
            $this->save($input);

            $created_object = $this->getPersonByID($this->getInsertID());

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

    public function updatePerson(int $id, array $input){
        if(empty($this->getPersonByID($id))){
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

        $this->update($id, $input);

        $updated_object = $this->getPersonByID($id);

        return [
            "status" => "success",
            "data" => $updated_object
        ];
    }
}
