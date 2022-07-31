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
            return $this->failNotFound();
        }
    }

    public function create(){
        $input = [
            "name" => $this->request->getPost("name"),
            "duration" => $this->request->getPost("duration"),
            "is_special" => $this->request->getPost("is_special")
        ];

        print_r($input);

        $model = new TasksModel();
        $response = $model->addTask($input);

        switch($response["status"]){
            case "success":
                return $this->respondCreated($response["data"]);

            default:
                return $this->failValidationErrors($response["errors"]);
        }
    }
}
