<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDataSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'stageof.nabire@bmkg.go.id'],
            [
                'name' => 'Admin',
                'password' => bcrypt('Geofnabire25!'),
                'is_admin' => 1,
            ]
        );
    }
}
