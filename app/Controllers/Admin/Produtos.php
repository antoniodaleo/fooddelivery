<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Produto; 

class Produtos extends BaseController
{

    private $produtoModel; 
    private $categoriaModel; 
    private $extraModel; 
    private $produtoExtraModel; 

    public function __construct(){

        $this->produtoModel = new \App\Models\ProdutoModel(); 
        $this->categoriaModel = new \App\Models\CategoriaModel(); 
        $this->extraModel = new \App\Models\ExtraModel(); 
        $this->produtoExtraModel = new \App\Models\ProdutoExtraModel(); 

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

    public function editarimagem($id = null){
        $produto = $this->buscaProdutoOu404($id);

        $data = [
            'titulo' => "Editando a imagem do  produto $produto->nome", 
            'produto' => $produto, 
            
        ]; 

        return view('Admin/Produtos/editar_imagem', $data); 
    }

    public function upload($id = null){
        $produto = $this->buscaProdutoOu404($id);

        $imagem = $this->request->getFile('foto_produto'); 

        if(!$imagem->isValid()){
            $codigoErro = $imagem->getError(); 

            if($codigoErro == UPLOAD_ERR_NO_FILE){
                return redirect()->back()->with('atencao','Nenhum arquivo foi selecionado'); 
            }
        }

        $tamanhoImagem = $imagem->getSizeByUnit('mb'); 

        if($tamanhoImagem > 2){
            return redirect()->back()->with('atencao', 'O arquivo selecionado é muito grante. Maximo permitido é: 2 MB'); 
        }

        $tipoImagem = $imagem->getMimeType(); 
        $tipoImagemLimpo = explode('/', $tipoImagem); 
        $tiposPermitidos = [
            'jpeg' , ' png', 'webp',
        ];

        if(!in_array($tipoImagemLimpo[1], $tiposPermitidos)){
            return redirect()->back()->with('atencao', 'O arquivo não tem o formato permitido. Apenas: '. implode(',', $tiposPermitidos)); 
        }

        list($largura, $altura) = getimagesize($imagem->getPathname()); 

        if($largura < "400" || $altura < "400"){
            return redirect()->back()->with('atencao', 'A imagem não pode ser menor do que 400 x 400 pixels'); 
        }


        //*********** A partir desse ponto fazemos o store da imagem  */
        
        /* Fazendo o store da img e recuperando o caminho da mesma  */
        $imagemCaminho = $imagem->store('produtos'); 

        $imagemCaminho = WRITEPATH. 'uploads/'. $imagemCaminho; 

        service('image')
            ->withFile($imagemCaminho)
            ->fit(400, 400, 'center')
            ->save($imagemCaminho);

        // Recup a img antiga antiga para exclui-la
        $imagemAntiga = $produto->imagem; 

        /* Atribuindo a nova imagem */
        $produto->imagem = $imagem->getName(); 

        // Atualizando a img do produto
        $this->produtoModel->save($produto);

        /* Definindo o caminho da img antiga */
        $caminhoImagem =   WRITEPATH. 'uploads/produtos/'.$imagemAntiga; 

        if(is_file($caminhoImagem)){

            unlink($caminhoImagem); 
        }

        return redirect()->to(site_url("admin/produtos/show/$produto->id"))->with('sucesso', 'Imagem alterada com sucesso'); 

        dd($imagem); 
    }

    public function imagem(string $imagem = null){
        if($imagem){
            $caminhoImagem = WRITEPATH. 'uploads/produtos/'.$imagem; 
            $infoImagem = new \finfo(FILEINFO_MIME); 
            $tipoImagem = $infoImagem->file($caminhoImagem); 

            header("Content-Type: $tipoImagem"); 
            header("Content-Length: ".filesize($caminhoImagem)); 

            readfile($caminhoImagem); 
            
            exit; 
        }
    }

    /*---------------------------------------------------------------- */
    public function extras($id = null){
        $produto = $this->buscaProdutoOu404($id); 

        $data = [
            'titulo' => "Gerenciar os extras do produto $produto->nome", 
            'produto' => $produto, 
            'extras' => $this->extraModel->where('ativo', true)->findAll(),
            'produtosExtras' => $this->produtoExtraModel->buscaExtrasDoProduto($produto->id), 

        ]; 

        //dd($data['produtosExtras']); 

        return view('Admin/Produtos/extras', $data); 
    }



}
