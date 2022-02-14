<?php

namespace App\Http\Controllers;

use App\Note;
use App\Preparation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class PreparationController extends Controller
{
    public function index(Request $request){
        // $allAnimals = Animal::with(['user'])->where('user_id', $request->user_id)->get()->sortByDesc('id');
        $data = Preparation::with(['user'])->where('user_id', $request->user_id)->orderBy('id', 'desc')->paginate(10);
        return $this->res($data, true, 'index success');
    }

    public function show($id){
        $data = Preparation::find($id);
        if($data){
            return $this->res($data, true, 'show success');
        }
        return $this->res([], false, 'show success');
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required|min:2|max:50',
            'context' => 'min:2',
            'image' => 'image',
        ]);

        if ($v->fails()) {
            return $this->res($v->errors(), false, 'we get an error');
        }

//        Preparation::create($request->all());

        if($request->file('image')) {
            $pathToFile = $request->file('image')->store('preparations', 'public');
        } else {
            $pathToFile = '';
        }

        Preparation::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'context' => $request->context,
            'image' => $pathToFile,
        ]);
        return $this->res([], true, 'store success');
    }

//    public function update(Request $request, Note $Note)
//    {
//        $Note->update($request->all());
//        return $this->res([], true, 'update success');
//    }

    public function update(Request $request, Preparation $Preparation)
    {
        $Preparation->update($request->all());
        return $this->res([], true, 'update success');
    }

    public function destroy(Preparation $Preparation)
    {
        $Preparation->delete();
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
