<?php

namespace App\Models;

use CodeIgniter\Model;

class ExtraModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'extras';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'App\Entities\Extra';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome','slug','preco', 'descricao', 'ativo'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules = [
        'nome'     => 'required|min_length[4]|is_unique[extras.nome]|max_length[120]',
    ];
    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo nome é obrigatorio',
            'is_unique' => 'Esse extra já existe',
        ],

    ];


    //Evento callback
    protected $beforeInsert = ['criaSlug']; 
    protected $beforeUpdate = ['criaSlug']; 
    
    protected function criaSlug(array $data){

        if(isset($data['data']['nome'])) {

            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', true); 

              
        }


        return $data; 
    }


    public function procurar($term){
        if($term === null){


            return [];
        }


        return $this->select('id, nome')
                ->like('nome', $term)
                ->withDeleted(true)
                ->get() 
                ->getResult(); 

    }

    public function desfazerExclusao(int $id){
        return $this->protect(false)
                    ->where('id', $id)
                    ->set('deletado_em', null)
                    ->update(); 
    }

    
}
