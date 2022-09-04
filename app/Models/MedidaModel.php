<?php

namespace App\Models;

use CodeIgniter\Model;

class MedidaModel extends Model
{
   
    protected $table            = 'medidas';
   
    protected $useAutoIncrement = true;
   
    protected $returnType       = 'App\Entities\Medida';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome','descricao', 'ativo'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules = [
        'nome'     => 'required|min_length[4]|is_unique[medidas.nome]|max_length[120]',
    ];
    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo nome é obrigatorio',
            'is_unique' => 'Esse medida já existe',
        ],

    ];

}
