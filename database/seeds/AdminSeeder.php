<?php

use App\Role;
use App\User;
use App\UserRole;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     $role = Role::create(
        [
            'role' => 'administrator',
            'description' => 'all_rights'
        ]
      );

     $admin = User::create(
         [
             'firstName' => 'admin',
             'lastName' => 'admin',
             'avatar' => 'http://127.0.0.1:8000/uploads/default_avatar.png',
             'username' => 'admin@4358',
             'password' => \Illuminate\Support\Facades\Hash::make('admin@4358')
         ]
     );

     UserRole::create([
         'user_id' => $admin->id,
         'role_id' => $role->id
     ]);
    }
}
