<?php

namespace App\Controllers\Api\V1;

use App\Models\PeopleModel;
use CodeIgniter\RESTful\ResourceController;

class People extends ResourceController
{
    public function index()
    {
        $model = new PeopleModel();

        $page = $this->request->getGet("page") ?? 0;
        $limit = 500 * $page;
        $offset = $limit - 500;

        $result = $model->getAllPeople($offset, $limit);

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

    public function show($id = null){
        if(is_null($id)){
            return $this->failNotFound();
        }

        $model = new PeopleModel();
        $result = $model->getPersonByID($id);

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
