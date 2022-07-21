<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Task extends Entity
{
    protected $datamap = [
        "id" => "id",
        "name" => "name",
        "duration" => "duration",
        "is_special" => "is_special",
        "created_at" => "created_at"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        "id" => "int",
        "duration" => "int",
        "is_special" => "bool"
    ];
}
