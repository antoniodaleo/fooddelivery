<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoEspecificacaoModel extends Model
{

    protected $table            = 'produtos_especificacoes';
    protected $returnType       = 'object';
    protected $allowedFields    = ['produto_id' , 'medida_id', 'preco', 'customizavel'];

    //Validações------------------------------------------------------------------------
    protected $validationRules = [
        'medida_id'     => 'required|integer',    
        'preco'     => 'required|greater_than[0]', 
        'customizavel' => 'required|integer',  
    ];

    protected $validationMessages = [
        'medida_id' => [
            'required' => 'O campo medida é obrigatorio',    
        ],
            
    
    ];

    public function buscaEspecificacoesDoProduto(int $produto_id, int $quantidade_paginacao){

        return $this->select('medidas.nome AS medida, produtos_especificacoes.*')
                    ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id ' )
                    ->join('produtos', 'produtos.id = produtos_especificacoes.produto_id ')
                    ->where('produtos_especificacoes.produto_id', $produto_id)
                    ->paginate($quantidade_paginacao); 
    }
    
    
}
