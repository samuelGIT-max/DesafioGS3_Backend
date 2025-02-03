<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Criar perfis
        $adminProfile = Profile::create(['name' => 'Administrador']);
        $userProfile = Profile::create(['name' => 'Usuário Comum']);

        // Criar usuários
        User::factory()->admin()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'profile_id' => $adminProfile->id,
        ]);

        User::factory(10)->create([
            'profile_id' => $userProfile->id,
        ]);
    }
}