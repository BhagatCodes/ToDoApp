<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\category;

class task extends Model
{
    protected $fillable = ['category_id','task_title','task_description','task_start','working_hours','session_id'];

    public function category(){
        return $this->belongsTo(category::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
