<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'slug', 'description', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function interns()
    {
        return $this->belongsToMany(Intern::class, 'task_intern');
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }
}
