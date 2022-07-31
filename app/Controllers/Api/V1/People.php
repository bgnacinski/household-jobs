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

        $model = new PeopleModel();
        $result = $model->getPersonByID($id);

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

    public function create(){
        $input = [
            "name" => $this->request->getVar("name"),
            "on_duty" => $this->request->getVar("on_duty")
        ];

        if(strtolower($input["on_duty"]) == "true" or $input["on_duty"] == "1"){
            $input["on_duty"] = true;
        }
        else{
            $input["on_duty"] = false;
        }

        $model = new PeopleModel();
        $result = $model->addPerson($input);

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
}
