<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Tasks', 'slug' => 'view-tasks'],
            ['name' => 'Create Tasks', 'slug' => 'create-tasks'],
            ['name' => 'Manage Interns', 'slug' => 'manage-interns'],
            ['name' => 'View Comments', 'slug' => 'view-comments'],
            ['name' => 'Comment on Task', 'slug' => 'comment-task'],
            ['name' => 'Chat', 'slug' => 'chat'],
        ];
    
        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
    }
}
