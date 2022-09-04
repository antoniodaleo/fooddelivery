<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'produtos';
   

    protected $returnType       = 'App\Entities\Produto';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'categoria_id',
        'nome',
        'slug',
        'ingredientes',
        'ativo',
        'imagem',
        
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

        // Validation
        protected $validationRules = [
            'nome'     => 'required|min_length[4]|is_unique[produtos.nome]|max_length[120]',
            'categoria_id' => 'required|integer', 
            'ingredientes'     => 'required|min_length[10]|is_unique[produtos.ingredientes]|max_length[1000]',
        ];
        protected $validationMessages = [
            'nome' => [
                'required' => 'O campo nome é obrigatorio',
                'is_unique' => 'Esse produto já existe',
                'categoria_id' => 'O Campo categoria é obligatorio',
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
