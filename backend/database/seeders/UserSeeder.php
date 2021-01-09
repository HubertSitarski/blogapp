<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var User $user */
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@example.pl',
            'password' => Hash::make('admin'),
        ]);

        $user->assignRole(['Super Admin']);

        /** @var User $user */
        $user = User::create([
            'name' => 'user',
            'email' => 'user@example.pl',
            'password' => Hash::make('user'),
        ]);

        $user->assignRole(['User']);
    }
}
