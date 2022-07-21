<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tasks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "int",
                "constraint" => 11,
                "auto_increment" => true,
                "unique" => true
            ],
            "name" => [
                "type" => "text",
                "null" => false
            ],
            "duration" => [
                "type" => "int",
                "null" => false
            ],
            "is_special" => [
                "type" => "bool",
                "null" => false
            ],
            "created_at" => [
                "type" => "varchar",
                "constraint" => 50,
                "null" => false
            ]
        ]);

        $this->forge->addPrimaryKey("id");

        $this->forge->createTable("tasks");
    }

    public function down()
    {
        $this->forge->dropTable("tasks");
    }
}
