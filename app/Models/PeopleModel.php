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
    protected $validationRules      = [];
    protected $validationMessages   = [];
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
}
