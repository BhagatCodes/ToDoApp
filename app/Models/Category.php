<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = ['user_id','name','session_id'];

    public function user(){
        $this->belongsTo(User::class);
    }
}
