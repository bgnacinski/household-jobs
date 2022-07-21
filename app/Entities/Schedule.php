<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Schedule extends Entity
{
    protected $datamap = [
        "id" => "id",
        "data" => "data",
        "created_at" => "created_at",
        "updated_at" => "updated_at"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];
}
