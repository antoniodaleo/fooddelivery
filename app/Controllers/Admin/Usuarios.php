<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Usuario;


class Usuarios extends BaseController
{

    private $usuarioModel; 

    public function __construct(){
        $this->usuarioModel = new \App\Models\UsuarioModel(); 
    
    }

    public function index(){

        $data = [
            'titulo'=> 'Listando os usuarios', 
            'usuarios' => $this->usuarioModel->withDeleted(true)->paginate(10),
            'pager' =>  $this->usuarioModel->pager,
        ];

        session()->set('sucesso', 'Olá, quem bom voçe esta conosco');
        return view('Admin/Usuarios/index', $data); 

    }

    public function procurar(){

        /*  
        echo '<pre>';
        print_r($this->request->getGet()); //Get -> mais detalhes
        exit;
        */

        
        if(!$this->request->isAJAX()){

            exit('Pagina não encontrada');

        }

        // O term vem do index, seria o que nos digitamos na barra de pesquisa
        $usuarios = $this->usuarioModel->procurar($this->request->getGet('term')); 
        $retorno = []; 

       
        

        foreach($usuarios as $usuario){
            $data['id']= $usuario->id; 
            $data['value']= $usuario->nome;
            
            $retorno[] = $data; 
            
        }

        return $this->response->setJSON($retorno); 

         
    }

    public function show($id = null){
        $usuario = $this->buscaUsuarioOu404($id); 

        $data = [
            'titulo' => "Detalhando o usuario $usuario->nome", 
            'usuario' => $usuario, 
        ]; 

        return view('Admin/Usuarios/show', $data); 

        
    }

    public function criar(){

        $usuario = new Usuario(); 


        $data = [
            'titulo' => "Criando novo usuario", 
            'usuario' => $usuario, 
        ]; 

        return view('Admin/Usuarios/criar', $data); 

        
    }

    public function cadastrar(){

        if($this->request->getMethod() === 'post'){
 
             $usuario = new Usuario($this->request->getPost()); 
 
 
            //dd($usuario); 
             if($this->usuarioModel->protect(false)->save($usuario)){
                 return redirect()->to(site_url("admin/usuarios/show/".$this->usuarioModel->getInsertID()))
                     ->with('sucesso',"Usuario $usuario->nome cadastrado com sucesso");
             }else{ 
 
                 return redirect()->back()->with('errors_model', $this->usuarioModel->errors())
                 ->with('atencao',"Por favor verifique os erros abaixo")
                 ->withInput();
             }
 
 
        }else{
             /* Não é Post */
             return redirect()->back();  //->with('info', 'Por favor envie um POST')
 
        }
 
    }


    public function editar($id = null){
        $usuario = $this->buscaUsuarioOu404($id); 

        if($usuario->deletado_em != null){
            return redirect()->back()->with('info', "O usuario $usuario->nome encontra-se excluido. Portanto, não é possivel editá-lo");
        }


        $data = [
            'titulo' => "Editando o usuario $usuario->nome", 
            'usuario' => $usuario, 
        ]; 

        return view('Admin/Usuarios/editar', $data); 

        
    }

    public function atualizar($id = null){

        if($this->request->getMethod() === 'post'){
 
             $usuario = $this->buscaUsuarioOu404($id); 
 
             if($usuario->deletado_em != null){
                 return redirect()->back()->with('info', "O usuario $usuario->nome encontra-se excluido. Portanto, não é possivel editá-lo");
             }
            
 
             $post = $this->request->getPost(); 
 
             if(empty($post['password'])){
 
                 $this->usuarioModel->desabilitaValidacaoSenha();
                 unset($post['password']); 
                 unset($post['password_confirmation']); 
                 
             }
 
             //dd($post); 
 
             $usuario->fill($post); 
 
             if(!$usuario->hasChanged()){
                 return redirect()->back()->with('info', 'Não á dados para atualizar'); 
             }
 
            //dd($usuario); 
             if($this->usuarioModel->protect(false)->save($usuario)){
                 return redirect()->to(site_url("admin/usuarios/show/$usuario->id"))
                     ->with('sucesso',"sucesso $usuario->nome atualizado com sucesso");
             }else{ 
 
                 return redirect()->back()->with('errors_model', $this->usuarioModel->errors())
                 ->with('atencao',"Por favor verifique os erros abaixo")
                 ->withInput();
             }
 
 
        }else{
             /* Não é Post */
             return redirect()->back();  //->with('info', 'Por favor envie um POST')
 
        }
 
    }


    private function buscaUsuarioOu404(int $id = null){

        if(!$id || !$usuario = $this->usuarioModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o usuario $id");

        }

        return $usuario; 
    }


    public function excluir($id = null){

        $usuario = $this->buscaUsuarioOu404($id); 


        if($usuario->deletado_em != null){
            return redirect()->back()->with('info', "O usuario $usuario->nome já encontra-se excluido.");
        }


        if($usuario->is_admin){
            return redirect()->back()->with('info', 'Não é possivel excluir um usuario <b>Administrador</b>');
        }


        if($this->request->getMethod() === 'post'){
            
            $this->usuarioModel->delete($id); 

            return redirect()->to(site_url('admin/usuarios'))->with('sucesso', "Usuario $usuario->nome excluido com sucesso!");
        }

        $data = [
            "titulo" => "Excluindo o usuario $usuario->nome", 
            "usuario" => $usuario, 
        ]; 

        //dd($usuario); 
        return view('Admin/Usuarios/excluir', $data); 
    }

    public function desfazerExclusao($id = null){

        $usuario = $this->buscaUsuarioOu404($id);

        if($usuario->deletado_em == null){
            return redirect()->back()->with('info', 'Apenas usuarios excluidos podem ser recuperados');
        }

        if($this->usuarioModel->desfazerExclusao($id)){

            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso!');

        }else{

            return redirect()->back()
                    ->with('errors_model', $this->usuarioModel->errors())
                    ->with('atencao', 'Por favor verifique os erros abaixo!')
                    ->withInput();
            }
     
    }



}
