<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = 'todos';
    use HasFactory;
    protected $fillable = ['user_id','name','done'];
   
    public function user()
    {
     return $this->hasOne(related: User::class);
    }
}
