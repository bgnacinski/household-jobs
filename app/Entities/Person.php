<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Person extends Entity
{
    protected $datamap = [
        "id" => "id",
        "name" => "name",
        "on_duty" => "on_duty",
        "created_at" => "created_at"
    ];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        "id" => "int",
        "on_duty" => "bool"
    ];
}
