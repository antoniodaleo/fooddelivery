<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaExpediente extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' =>  'INT', 
                'constraint' => 5, 
                'unsigned' => true,
                'auto_increment' => true,  
            ], 

            'dia' => [ // De 0 (Domingo) ate 6 (Sabado)
                'type' =>  'INT', 
                'constraint' => '5', 
            ],

            'dia_descricao' => [
                'type' =>  'VARCHAR', 
                'constraint' => '50', 
            ],

            'abertura' => [
                'type' =>  'TIME', 
                'null' => true,
                'default' => null,  
            ],

            'fechamento' => [
                'type' =>  'TIME', 
                'null' => true,
                'default' => null,  
            ],

            
            'situacao' => [ // 0 [Fechado] 1 Aberto
                'type' =>  'BOOLEAN', 
                'null' => false,
                
            ],
           
           

        ]); 

        $this->forge->addPrimaryKey('id'); 
        $this->forge->createTable('expediente'); 
    }

    public function down()
    {
        $this->forge->dropTable('expediente'); 
    }
}
