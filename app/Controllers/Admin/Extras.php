<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Extra; 

class Extras extends BaseController
{

    private $extraModel; 

    public function __construct(){
        $this->extraModel = new \App\Models\ExtraModel(); 

    }

    public function index(){

        $data = [
            'titulo' => 'Listando os extras de produto', 
            'extras' => $this->extraModel->withDeleted(true)->paginate(10), 
            'pager' => $this->extraModel->pager
        ]; 

        return view('Admin/Extras/index', $data); 



    }


    public function procurar(){
        
        if(!$this->request->isAJAX()){

            exit('Pagina não encontrada');

        }

        // O term vem do index, seria o que nos digitamos na barra de pesquisa
        $extras = $this->extraModel->procurar($this->request->getGet('term')); 
        $retorno = []; 

        foreach($extras as $extra){
            $data['id']= $extra->id; 
            $data['value']= $extra->nome;
            
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
        $extra = new Extra(); 

        $data = [
            'titulo' => "Adicionar Extra", 
            'extra' => $extra, 
        ]; 

        return view('Admin/Extras/criar', $data); 

        
    }

    public function cadastrar(){

        if($this->request->getMethod() === 'post'){
 
            $extra = new Extra($this->request->getPost()); 
 
             
            //dd($extra); 

             if($this->extraModel->save($extra)){
                 return redirect()->to(site_url("admin/extras/show/".$this->extraModel->getInsertID()))
                     ->with('sucesso',"Extra $extra->nome cadastrado com sucesso");
             }else{ 
 
                 return redirect()->back()->with('errors_model', $this->extraModel->errors())
                 ->with('atencao',"Por favor verifique os erros abaixo")
                 ->withInput();
             }
 
 
        }else{
             /* Não é Post */
             return redirect()->back();  //->with('info', 'Por favor envie um POST')
 
        }
 
    }


    public function show($id = null){
        $extra = $this->buscaExtraOu404($id); 

        $data = [
            'titulo' => "Detalhando a extra $extra->nome", 
            'extra' => $extra, 
        ]; 

        return view('Admin/extras/show', $data); 

        
    }


    private function buscaExtraOu404(int $id = null){

        if(!$id || !$extra = $this->extraModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a extra $id");

        }

        return $extra; 
    }

    public function editar($id = null){
        $extra = $this->buscaExtraOu404($id); 

        if($extra->deletado_em != null){
            return redirect()->back()->with('info', "O extra $extra->nome encontra-se excluida. Portanto, não é possivel editá-lo");
        }

        $data = [
            "titulo" => "Editando o extra $extra->nome ", 
            "extra" => $extra, 
        ]; 

        //dd($usuario); 

        return view('Admin/extras/editar', $data); 
    }

    public function atualizar($id = null){

        if($this->request->getMethod() === 'post'){
 
             $extra = $this->buscaExtraOu404($id); 
 
             if($extra->deletado_em != null){
                 return redirect()->back()->with('info', "A extra $extra->nome encontra-se excluido. Portanto, não é possivel editá-lo");
             }
            
 
             
 
             $extra->fill($this->request->getPost()); 
 
             if(!$extra->hasChanged()){
                 return redirect()->back()->with('info', 'Não á dados para atualizar'); 
             }
 
            //dd($extra); 

             if($this->extraModel->save($extra)){
                 return redirect()->to(site_url("admin/extras/show/$extra->id"))
                     ->with('sucesso',"sucesso $extra->nome atualizado com sucesso");
             }else{ 
 
                 return redirect()->back()->with('errors_model', $this->extraModel->errors())
                 ->with('atencao',"Por favor verifique os erros abaixo")
                 ->withInput();
             }
 
 
        }else{
             /* Não é Post */
             return redirect()->back();  //->with('info', 'Por favor envie um POST')
 
        }
 
    }

    




}
