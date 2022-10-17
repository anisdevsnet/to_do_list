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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
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