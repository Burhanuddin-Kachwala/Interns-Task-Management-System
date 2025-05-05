<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskIntern extends Model
{
    public $timestamps = true;

    protected $fillable = ['task_id', 'intern_id'];
}
