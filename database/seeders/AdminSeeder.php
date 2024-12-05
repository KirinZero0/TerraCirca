<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::where('username', 'owner')->forceDelete();

        Admin::create([
            'name' => 'Hattori',
            'email' => 'owner@example.com',
            'username' => 'owner',
            'password' => Hash::make('password'),
        ]);
    }
}
