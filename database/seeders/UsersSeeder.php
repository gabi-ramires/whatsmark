<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Gerar um token único usando a função Str::random()
        $token = Str::random(64);

        // Inserir um registro na tabela users
        DB::table('users')->insert([
            'name' => 'John Doe', // Nome do usuário
            'email' => 'john@example.com', // E-mail do usuário
            'email_verified_at' => now(), // Data da verificação de email
            'password' => Hash::make('password'), // Senha do usuário (criptografada usando Hash::make)
            'remember_token' => $token, // token de autenticação
            'created_at' => now(), // Data de criação
            'updated_at' => now(), // Data de atualização
        ]);
    }
}
