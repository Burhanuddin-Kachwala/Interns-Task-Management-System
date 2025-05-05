<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskComment extends Model
{
    use SoftDeletes;

    protected $fillable = ['task_id', 'intern_id', 'admin_id', 'comment'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
