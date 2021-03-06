<?php

namespace App\Controllers\Api\V1;

use App\Models\TasksModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Tasks extends ResourceController
{
    use ResponseTrait;
    public function index()
    {
        $model = new TasksModel();

        $page = (int)$this->request->getGet("page") ?? 0;
        $limit = 500 * $page;
        $offset = $limit - 500;

        $result = $model->getAllTasks($offset, $limit);

        if(!empty($result)){
            $response = [
                "status" => "success",
                "data" => $result
            ];

            return $this->respond($response);
        }
        else{
            return $this->failNotFound();
        }
    }

    public function show($id = null){
        if(is_null($id)){
            return $this->failNotFound();
        }

        $model = new TasksModel();
        $result = $model->getTaskByID($id);

        if(!is_null($result)){
            $response = [
                "status" => "success",
                "data" => $result
            ];

            return $this->respond($response);
        }
        else{
            return $this->failNotFound("Task with ID $id not found.");
        }
    }

    public function create(){
        $input = [
            "name" => $this->request->getPost("name"),
            "duration" => $this->request->getPost("duration"),
            "is_special" => $this->request->getPost("is_special")
        ];

        if(strtolower($input["is_special"]) == "true" or $input["is_special"] == "1"){
            $input["is_special"] = true;
        }
        else{
            $input["is_special"] = false;
        }

        $model = new TasksModel();
        $result = $model->addTask($input);

        switch($result["status"]){
            case "success":
                $response = [
                    "status" => "created",
                    "data" => $result["data"]
                ];

                return $this->respondCreated($response);

            default:
                return $this->failValidationErrors($result["errors"]);
        }
    }

    public function update($id = null){
        if(is_null($id)){
            return $this->failNotFound();
        }

        $input = [
            "name" => $this->request->getVar("name"),
            "duration" => $this->request->getVar("duration"),
            "is_special" => $this->request->getVar("is_special")
        ];

        if(strtolower($input["is_special"]) == "true" or $input["is_special"] == "1"){
            $input["is_special"] = true;
        }
        else{
            $input["is_special"] = false;
        }

        $model = new TasksModel();
        $result = $model->updateTask($id, $input);

        switch($result["status"]){
            case "success":
                $response = [
                    "status" => "updated",
                    "data" => $result["data"]
                ];

                return $this->respondUpdated($response);

            case "notfound":
                return $this->failNotFound("Task with ID $id not found.");

            default:
                return $this->failValidationErrors($result["errors"]);
        }
    }

    public function delete($id = null){
        if(is_null($id)){
            return $this->failNotFound();
        }

        $model = new TasksModel();
        $result = $model->deleteTask($id);

        switch($result["status"]){
            case "success":
                $response = [
                    "status" => "deleted",
                    "data" => $result["data"]
                ];

                return $this->respondDeleted($response);

            default:
                return $this->failNotFound("Task with ID $id not found.");
        }
    }
}
