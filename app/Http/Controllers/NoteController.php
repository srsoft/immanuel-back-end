<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{
    public function index(){
        $data = Note::with(['user'])->orderBy('id', 'desc')->paginate(10);
        return $this->res($data, true, 'index success');
    }

    public function show($id){
        $data = Note::find($id);
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
            'context' => 'nullable|min:2|max:225',
        ]);

        if ($v->fails()) {
            return $this->res($v->errors(), false, 'we get an error');
        }

        Note::create($request->all());
        return $this->res([], true, 'store success');
    }

    public function update(Request $request, Note $Note)
    {
        $Note->update($request->all());
        return $this->res([], true, 'update success');
    }

    public function destroy(Note $Note)
    {
        $Note->delete();
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
