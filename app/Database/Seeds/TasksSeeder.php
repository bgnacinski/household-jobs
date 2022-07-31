<?php

namespace App\Database\Seeds;

use App\Models\TasksModel;
use CodeIgniter\Database\Seeder;

class TasksSeeder extends Seeder
{
    public function run()
    {
        $model = new TasksModel();
        $data = [
            "name" => "Test task",
            "duration" => 30,
            "is_special" => true
        ];

        $model->save($data);
    }
}
