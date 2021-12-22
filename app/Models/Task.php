<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon  \Carbon;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function encargado(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function logs(){
        return $this->hasMany(Log::class, 'task_id', 'id');
    }

    public function expired(){
        if(Carbon::createFromFormat('Y-m-d', $this->limit_date)->gte(Carbon::now()))
            return false;
        return true;
    }
}
