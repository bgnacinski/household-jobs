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
            return $this->respond($result);
        }
        else{
            return $this->respondNoContent();
        }
    }
}
