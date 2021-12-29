<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $module_name;
    protected $model;

    public function storeContact(Request $request){

    }

    public function index($module_name){
        try {
            $this->setModuleName($module_name);
            $check = $this->initModel();
            if($check === false) {
                return $this->youCantAccess();
            }
            $data = $this->model->paginate(10);
            return $this->successWithdata($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getById($module_name, $id){
        try {
            $this->setModuleName($module_name);
            $check = $this->initModel();
            if($check === false) {
                return $this->youCantAccess();
            }
            $data = $this->model->find($id);
            if($data){
                return $this->successWithdata($data);
            }
            return $this->res([], false, 'we can not find this id');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    protected function errorResponse($e){
        return $this->res([], false, $e);
    }

    protected function successWithdata($data){
        return $this->res($data, true, 'here what we found in ' . $this->module_name);
    }

    protected function youCantAccess(){
        return $this->res([], false, 'you can not access this module');
    }

    protected function res($data = [], $status = true, $message = ''){
        $data = [
            'payload' => $data,
            'status' => $status,
            'message' => $message
        ];
        return response()->json($data);
    }

    protected function setModuleName($module_name){
        $this->module_name = $module_name;
    }

    protected function initModel(){
        $module = \Str::lower($this->module_name);
        $module = \Str::singular($module);
        $module = \Str::camel($module);
        $module = \Str::ucfirst($module);
        if(in_array($module, $this->expectModules())){
            return false;
        }
        $namespace = 'App\\'.$module;
        $this->model = new $namespace;
    }

    protected function expectModules(){
        return ['Contact'];
    }
}
