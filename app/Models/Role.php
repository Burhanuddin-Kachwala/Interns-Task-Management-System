<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    const STATUS_YES = "yes";
    const STATUS_NO =   "no";

    protected $fillable = ['name', 'slug', 'is_superadmin'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    public function interns()
    {
        return $this->hasMany(Intern::class);
    }
   
}
