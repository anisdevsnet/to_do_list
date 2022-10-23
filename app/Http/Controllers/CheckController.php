<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    public function index()
    {
        $todo = Todo::latest()->get();
        return view('check.index');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'=>'required',
            //'status'
            //'categories'=>'required',
            
        ]);
        $todo = new Todo();
        $todo -> user_id = Auth::user()->id;
        $todo -> name = $request->input('name') ?? "";
        $todo->save();
       return view('check.create');
    }
}
