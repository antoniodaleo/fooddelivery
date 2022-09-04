<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Produto; 

class Produtos extends BaseController
{

    private $produtoModel; 
    private $categoriaModel; 

    public function __construct(){

        $this->produtoModel = new \App\Models\ProdutoModel(); 
        $this->categoriaModel = new \App\Models\CategoriaModel(); 

    }


    public function index(){
        $data = [
            'titulo' => 'Listando as produtos', 
            'produtos' => $this->produtoModel
                ->select('produtos.*, categorias.nome AS categoria')
                ->join('categorias','categorias.id = produtos.categoria_id')
                ->withDeleted(true)
                ->paginate(10),

            'pager' => $this->produtoModel->pager,
        ]; 

        //dd($data[ 'produtos']); 

       
        return view('Admin/produtos/index', $data); 
    }

    public function procurar(){
        
        if(!$this->request->isAJAX()){

            exit('Pagina não encontrada');

        }

        // O term vem do index, seria o que nos digitamos na barra de pesquisa
        $produtos = $this->produtoModel->procurar($this->request->getGet('term')); 
        $retorno = []; 

        foreach($produtos as $produto){
            $data['id']= $produto->id; 
            $data['value']= $produto->nome;
            
            $retorno[] = $data; 
            
        }

        return $this->response->setJSON($retorno); 

        /* 
        echo '<pre>';
        print_r($this->request->getGet()); //Get -> mais detalhes
        exit;
        */ 
    }

    public function criar(){
        $produto = new Produto(); 

        $data = [
            'titulo' => "Criando novo produto $produto->nome", 
            'produto' => $produto, 
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll(), 
        ]; 

        return view('Admin/Produtos/criar', $data); 

        
    }


    public function show($id = null){
        $produto = $this->buscaProdutoOu404($id); 

        $data = [
            'titulo' => "Detalhando a produto $produto->nome", 
            'produto' => $produto, 
        ]; 

        return view('Admin/Produtos/show', $data); 

        
    }

    private function buscaProdutoOu404(int $id = null){

        if(!$id || !$produto = $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
            ->join('categorias','categorias.id = produtos.categoria_id')
            ->where('produtos.id', $id)
            ->withDeleted(true)
            ->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a produto $id");

        }

        return $produto; 
    }

    public function editar($id = null){
        $produto = $this->buscaProdutoOu404($id); 

        $data = [
            'titulo' => "Editando a produto $produto->nome", 
            'produto' => $produto, 
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll()
        ]; 

        return view('Admin/Produtos/editar', $data); 

        
    }

    public function atualizar($id = null){
        if($this->request->getMethod() === 'post'){

            $produto = $this->buscaProdutoOu404($id); 

            //dd($this->request->getPost()); 
            $produto->fill($this->request->getPost()); 

            if(!$produto->hasChanged()){
                return redirect()->back()->with('info', 'Não ha dados para atualizar'); 
            }

            if($this->produtoModel->save($produto)){
                return redirect()->to(site_url("admin/produtos/show/$id"))->with('sucesso', 'Produto atualizado com sucesso'); 

            }else{

                return redirect()->back()->with('errors_model', $this->produtoModel->errors())
                 ->with('atencao',"Por favor verifique os erros abaixo")
                 ->withInput();
            }


        }else{

            return redirect()->back(); 

        }

        
    }

    public function cadastrar(){
        if($this->request->getMethod()=== 'post'){

            $produto = new Produto($this->request->getPost()); 

            

            if($this->produtoModel->save($produto)){
                return redirect()->to(site_url('admin/produtos/show/'.$this->produtoModel->getInsertID()))
                ->with('sucesso', 'Produto cadastrado  com sucesso'); 

            }else{

                return redirect()->back()
                ->with('errors_model', $this->produtoModel->errors())
                 ->with('atencao',"Por favor verifique os erros abaixo")
                 ->withInput();
            }


        }else{

            return redirect()->back(); 

        }

        
    }





}
