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

        if(empty($result)){
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
}
