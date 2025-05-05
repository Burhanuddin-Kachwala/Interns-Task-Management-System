<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = ['name', 'email', 'password', 'role_id', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }
    public function isSuperAdmin() {
        return $this->role->is_super_admin == Role::STATUS_YES ? true : false;
    }
    public function hasPermission($slug)
    {
        if($this->isSuperAdmin()) {
            return true;
        }
        return $this->role && $this->role->permissions()->where('slug', $slug)->exists();
    }

    public function hasRole($slug)
    {
        return $this->role && $this->role->slug === $slug;
    }
}
