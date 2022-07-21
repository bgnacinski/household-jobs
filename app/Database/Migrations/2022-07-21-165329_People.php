<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class People extends Migration
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
                "null" => false,
            ],
            "on_duty" => [
                "type" => "bool",
                "null" => false
            ],
            "created_at" => [
                "type" => "varchar",
                "constraint" => 50
            ]
        ]);

        $this->forge->addPrimaryKey("id");

        $this->forge->createTable("people");
    }

    public function down()
    {
        $this->forge->dropTable("people");
    }
}
