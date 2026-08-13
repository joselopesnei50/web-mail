<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nc5 = \App\Models\Company::create([
            'name' => 'NC5 Hub Digital',
            'domain' => 'nc5.com.br',
            'is_active' => true,
        ]);

        $vivensi = \App\Models\Company::create([
            'name' => 'Vivensi',
            'domain' => 'vivensi.com.br',
            'is_active' => true,
        ]);

        \App\Models\User::create([
            'name' => 'Super Admin NC5',
            'email' => 'admin@nc5.com.br',
            'password' => bcrypt('password'),
            'company_id' => $nc5->id,
            'role' => 'super_admin',
        ]);

        \App\Models\User::create([
            'name' => 'Admin Vivensi',
            'email' => 'contato@vivensi.com.br',
            'password' => bcrypt('password'),
            'company_id' => $vivensi->id,
            'role' => 'company_admin',
        ]);
        
        \App\Models\User::create([
            'name' => 'User Vivensi',
            'email' => 'user@vivensi.com.br',
            'password' => bcrypt('password'),
            'company_id' => $vivensi->id,
            'role' => 'user',
        ]);
    }
}
