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
    public function hasPermission($permissionName)
    {
        // Force-load role and permissions if not loaded
        if (!$this->relationLoaded('role') || !$this->role?->relationLoaded('permissions')) {
            $this->load('role.permissions');
        }

        if (!$this->role) {
            return false;
        }

        if ($this->role->is_superadmin) {
            return true;
        }

        return $this->role->permissions->contains('slug', $permissionName);
    }

    public function hasRole($slug)
    {
        return $this->role && $this->role->slug === $slug;
    }
}
