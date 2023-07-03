<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = new Role();
     	$role->name = 'admin';
     	$role->guard_name = 'web';
      	$role->save();

       	$role = new Role();
    	$role->name = 'user';
    	$role->guard_name = 'web';
   	 	$role->save();
    }
}
