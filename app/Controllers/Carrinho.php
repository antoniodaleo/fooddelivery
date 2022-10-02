<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Carrinho extends BaseController{


    private $validacao; 
    private $produtoEspecificacaoModel; 
    private $extraModel; 
    private $produtoModel; 
    private $acao; 
    


    public function __construct(){   
        //$validation = \Config\Services::validation(); 

        $this->validacao = service('validation'); 
        $this->produtoEspecificacaoModel = new \App\Models\ProdutoEspecificacaoModel(); 
        $this->extraModel = new \App\Models\ExtraModel(); 
        $this->produtoModel = new \App\Models\ProdutoModel(); 

        $this->acao = service('router')->methodName(); 

    }
    
    public function index(){
        //
    }

    public function adicionar(){

        if($this->request->getMethod() === 'post'){


            //dd(service('router')); 

            $produtoPost = $this->request->getPost('produto'); 

            //dd($produtoPost); 


            /* 1ª Validazione, se i campi rispettano queste regole */
            $this->validacao->setRules([
                'produto.slug' => ['label' => 'Produto', 'rules' => 'required|string'], 
                'produto.especificacao_id' => ['label' => 'Valor do produto', 'rules' => 'required|greater_than[0]'], 
                'produto.preco' => ['label' => 'Valor do produto', 'rules' => 'required|greater_than[0]'], 
                'produto.quantidade' => ['label' => 'Quantidade', 'rules' => 'required|greater_than[0]'], 

            ]);

            if(!$this->validacao->withRequest($this->request)->run()){
                return redirect()->back()
                        ->with('errors_model', $this->validacao->getErrors())
                        ->with('atencao',"Por favor verifique os erros abaixo e tente novamente")
                        ->withInput();
            }


            /* Validiamo la possibilitá di richiedere il prodotto extra , caso il prodotto principale lo ha*/
            $especificacaoProduto =$this->produtoEspecificacaoModel
                ->join('medidas','medidas.id = produtos_especificacoes.medida_id')
                ->where('produtos_especificacoes.id', $produtoPost['especificacao_id'])
                ->first(); 


            /* Se il prodotto non offre la possib di chiedere questo extra mi mostri un erro */
            if($especificacaoProduto == null){
                return redirect()->back()
                    ->with('fraude',"Não conseguimos processar a sua solicitação. Por favor entre em contato a nossa equipe e informe o codigo de erro <strong>Erro-Add-1001</strong>");
                    
            }

            /* Caso o extra id venha no post, validamos a existencia do mesmo*/
            if($produtoPost['extra_id'] && $produtoPost['extra_id'] != "" ){

                $extra = $this->extraModel->where('id', $produtoPost['extra_id'])->first(); 

                if($extra == null){
                    return redirect()->back()
                        ->with('fraude',"Não conseguimos processar a sua solicitação. Por favor entre em contato a nossa equipe e informe o codigo de erro <strong>Erro-Add-2001</strong>");                        
                }

            }
            
            /* Array porque  podemos inserir o obj no carrinho*/
            $produto = $this->produtoModel->select(['id','nome','slug','ativo'])->where('slug',  $produtoPost['slug'])->first()->toArray(); 

           //dd($produto); 

           /*
            Se il prodotto é nullo o inativo
            mi dai un errore
           */
            if($produto == null || $produto['ativo'] == false ){
                return redirect()->back()
                    ->with('fraude',"Não conseguimos processar a sua solicitação. Por favor entre em contato a nossa equipe e informe o codigo de erro <strong>Erro-Add-3001</strong>");
                    
            }

            /* Criamos o slug composto , para identif. existencia de item no carrinho na hora de adicionar */
            $produto['slug'] = mb_url_title($produto['slug'] .'-'. $especificacaoProduto->nome .'-' .(isset($extra) ? 'com extra-' .$extra->nome : ''  ).'-'.true); 

            //dd($produto['slug']); 

            /* Criamo o nome do produto a aprtir da especificacao ou  do extra */
            $produto['nome'] = $produto['nome'].' '.$especificacaoProduto->nome.' '.(isset($extra) ? 'Com extra-'.$extra->nome : '');

            /* Definimos o preco, quantidade e tamanho do produto */
            $preco = $especificacaoProduto->preco + (isset($extra) ? $extra->preco : 0); 

            $produto['preco'] = number_format($preco, 2); 
            $produto['quantidade'] = (int) $produtoPost['quantidade']; 
            $produto['tamanho'] = $especificacaoProduto->nome; 

            // Removemos o atributo sem utilidade
            unset($produto['ativo']); 

            /*Iniciamos a inserção do produto no carrinho */
            if(session()->has('carrinho')){
                // Recupero os prod do carrinho
                $produtos = session()->get('carrinho');

                /* Recuperamos apenas os slugs dos produtos do carrinho */
                $produtoSlugs = array_column($produtos, 'slug'); 


                if(in_array($produto['slug'], $produtoSlugs)){
                    
                    /* Ja existe o produto no carrinho... incrementamos a quantidade */

                   /* Chamamos a funcao que incrementa a qtd do produto*/
                   $produtos = $this->atualizaProduto($this->acao , $produto['slug'], $$produto['quantidade'], $produtos); 
                    

                   /* Sobrescrevemos a sessao carrinho com array produtos que foi incrementados */
                   session()->set('carrinho', $produtos);

                }else{
                    /* Não existe no carrinho , pode adicionar */
                    
                    $produto[] = $produto; 
                    session()->push('carrinho',[$produto]); 
                }


                //dd(session()->get('carrinho')); 
            }else{

                /* Não existe ainda um carrinho de compras na sessão */
                $produtos[] = $produto; 
                session()->set('carrinho', $produtos); 
            }

            return redirect()->back()->with('sucesso', 'Produto adicionado com sucesso!'); 
           // dd($produto); 
        }else{
            
            return redirect()->back(); 
        
        }



    }

    private function atualizaProduto(string $acao, string $slug, int $quantidade, array $produtos){

        $produtos = array_map(function ($linha) use($acao, $slug, $quantidade){ 
            
            if($linha['slug'] == $slug){

                if($acao === 'adicionar'){
                    $linha['quantidade'] += $quantidade; 
                }

                if($acao === 'atualizar'){  
                    $linha['quantidade'] = $quantidade;
                }

            }

            return $linha; 

        }, $produtos); 

        return $produtos; 

    }

 

}



