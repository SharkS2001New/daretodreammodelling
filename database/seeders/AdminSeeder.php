<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::where('email', 'alpacke.tech@gmail.com')->update([
            'is_admin' => true,
            'user_type' => 'Admin',
        ]);
    }
}
