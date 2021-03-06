<?php

namespace App\Http\Controllers;

use App\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends Controller
{
    public function index(){
        $data = Team::orderBy('id', 'desc')->paginate(10);
        return $this->res($data, true, 'index success');
    }

    public function show($id){
        $data = Team::find($id);
        if($data){
            return $this->res($data, true, 'show success');
        }
        return $this->res([], false, 'show success');
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|min:2|max:50',
            'job_title' => 'required|min:2|max:50',
            'LinkedIn' => 'nullable|url|min:10|max:225',
            'facebook' => 'nullable|url|min:10|max:225',
        ]);

        if ($v->fails()) {
            return $this->res($v->errors(), false, 'we get an error');
        }

        Team::create($request->all());
        return $this->res([], true, 'store success');
    }

    public function update(Request $request, Team $Team)
    {
        $Team->update($request->all());
        return $this->res([], true, 'update success');
    }

    public function destroy(Team $Team)
    {
        $Team->delete();
        return $this->res([], Response::HTTP_NO_CONTENT, 'destory success');
    }

    protected function res($data = [], $status = true, $message = ''){
        $data = [
            'payload' => $data,
            'status' => $status,
            'message' => $message
        ];
        return response()->json($data);
    }
}
