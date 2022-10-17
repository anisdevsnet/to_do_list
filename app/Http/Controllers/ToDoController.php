<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        
            return response()->json(Todo::latest()->get());
        
        
        
    }

   

    
    public function store(Request $request)
    {   
        $todo = Todo::Create($request->all());
        return response()
        ->json($todo);
    }

    
    public function complete(Request $request)
    {
        $todo = Todo::find($request->get('id'));
        $todo->done = true;
        $todo->update();
        return response()
        ->json('success');
    }

    public function incomplete(Request $request)
    {
        $todo = Todo::find($request->get('id'));
        $todo-> done = false;
        $todo->update();
        return response()
        ->json('unsuccess');
    }

    
    public function update(Request $request,$id)
    {
       $todo = Todo::find($id);
       if(!$todo)
       {
        $status = 0;
        $msg = 'not found';

        return response([ 'todo' => $todo, 'status' => $status, 'message' => $msg]);
       }
       $todo->update([
        'name'=>$request->get('name')
       ]);
        return response()
        ->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::find($id)->delete();
        return response()
        ->json($todo);
    }
}
