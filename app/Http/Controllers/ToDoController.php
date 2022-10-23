<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        //dd(Auth::user());
            return response()
            ->json(Todo::where('user_id','=',Auth::user()->id)->orderBy('created_at','DESC')->get());
        
    }

    public function store(Request $request)
    {   
         //dd( auth()->user());
        $rules =[
            'name'=>'required|max:25'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            $result = $validator->errors()->all();
            return response(['error' => $result]);
        }

        $todo = new Todo;
        $todo->user_id = Auth::user()->id;
        $todo->name = $request->input('name');
       
       
        $todo->save();
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

    public function comment(Request $request, $id)
    {
        
        $todo = Todo::find($id);
        $todo->comment = $request->comment;
       
        $todo->save();
    }
}
