<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        $usuario_model = new \App\Models\UsuarioModel;

        $usuario = [
            'nome' => 'Antonio Daleo', 
            'email' => 'antoniodaleo@gmail.com', 
            'telefone'=>'85989118999',
        ];


        $usuario_model->protect(false)->insert($usuario);

        $usuario = [
            'nome' => 'Letycia Lobato', 
            'email' => 'letylobato@gmail.com', 
            'telefone'=>'85989118922',
        ];

        $usuario_model->protect(false)->insert($usuario);

        dd($usuario_model->errors());
    }
}
