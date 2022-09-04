<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Medida;


class Medidas extends BaseController
{

    private $medidaModel; 

    public function __construct(){
        $this->medidaModel = new \App\Models\MedidaModel(); 
    }

    public function index(){
        $data = [
            'titulo' => 'Listando as medidas de produtos', 
            'medidas' => $this->medidaModel->withDeleted(true)->paginate(10),  
            'pager' => $this->medidaModel->pager, 
        ]; 


        return view('Admin/Medidas/index', $data); 


    }

    public function procurar(){
        
        if(!$this->request->isAJAX()){

            exit('Pagina não encontrada');

        }

        // O term vem do index, seria o que nos digitamos na barra de pesquisa
        $medidas = $this->medidaModel->procurar($this->request->getGet('term')); 
        $retorno = []; 

        foreach($medidas as $medida){
            $data['id']= $medida->id; 
            $data['value']= $medida->nome;
            
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
        $medida = new Medida(); 

        $data = [
            'titulo' => "Criando nova medida", 
            'medida' => $medida, 
        ]; 

        return view('Admin/medidas/criar', $data); 

        
    }

    public function cadastrar(){

        if($this->request->getMethod() === 'post'){
 
             $medida = new Medida($this->request->getPost()); 
 

             if($this->medidaModel->save($medida)){
                 return redirect()->to(site_url("admin/medidas/show/".$this->medidaModel->getInsertID()))
                     ->with('sucesso',"Medida $medida->nome cadastrado com sucesso");
             }else{ 
 
                 return redirect()->back()->with('errors_model', $this->medidaModel->errors())
                 ->with('atencao',"Por favor verifique os erros abaixo")
                 ->withInput();
             }
 
 
        }else{
             /* Não é Post */
             return redirect()->back();  //->with('info', 'Por favor envie um POST')
 
        }
 
    }


    public function show($id = null){
        $medida = $this->buscaMedidaOu404($id); 

        $data = [
            'titulo' => "Detalhando a medida $medida->nome", 
            'medida' => $medida, 
        ]; 

        return view('Admin/medidas/show', $data); 

        
    }

    private function buscaMedidaOu404(int $id = null){

        if(!$id || !$medida = $this->medidaModel->withDeleted(true)->where('id', $id)->first()){

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a medida $id");

        }

        return $medida; 
    }

    public function editar($id = null){
        $medida = $this->buscaMedidaOu404($id); 

        $data = [
            'titulo' => "Editando a medida $medida->nome", 
            'medida' => $medida, 
        ]; 

        return view('Admin/medidas/editar', $data); 

        
    }

    public function atualizar($id = null){

        if($this->request->getMethod() === 'post'){
 
             $medida = $this->buscaMedidaOu404($id); 
 
             if($medida->deletado_em != null){
                 return redirect()->back()->with('info', "A medida $medida->nome encontra-se excluido. Portanto, não é possivel editá-lo");
             }
            
 
             
 
             $medida->fill($this->request->getPost()); 
 
             if(!$medida->hasChanged()){
                 return redirect()->back()->with('info', 'Não á dados para atualizar'); 
             }
 
            //dd($medida); 

             if($this->medidaModel->save($medida)){
                 return redirect()->to(site_url("admin/medidas/show/$medida->id"))
                     ->with('sucesso',"sucesso $medida->nome atualizado com sucesso");
             }else{ 
 
                 return redirect()->back()->with('errors_model', $this->medidaModel->errors())
                 ->with('atencao',"Por favor verifique os erros abaixo")
                 ->withInput();
             }
 
 
        }else{
             /* Não é Post */
             return redirect()->back();  //->with('info', 'Por favor envie um POST')
 
        }
 
    }

    public function excluir($id = null){

        $medida = $this->buscaMedidaOu404($id); 


        if($medida->deletado_em != null){
            return redirect()->back()->with('info', "A medida $medida->nome já encontra-se excluido.");
        }


        if($this->request->getMethod() === 'post'){
            
            $this->medidaModel->delete($id); 

            return redirect()->to(site_url('admin/medidas'))->with('sucesso', "medida $medida->nome excluida com sucesso!");
        }

        $data = [
            "titulo" => "Excluindo a medida $medida->nome", 
            "medida" => $medida, 
        ]; 

        //dd($usuario); 
        return view('Admin/medidas/excluir', $data); 
    }

    public function desfazerExclusao($id = null){

        $medida = $this->buscamedidaOu404($id);

        if($medida->deletado_em == null){
            return redirect()->back()->with('info', 'Apenas medida excluidos podem ser recuperados');
        }

        if($this->medidaModel->desfazerExclusao($id)){

            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso!');

        }else{

            return redirect()->back()
                    ->with('errors_model', $this->medidaModel->errors())
                    ->with('atencao', 'Por favor verifique os erros abaixo!')
                    ->withInput();
            }
     
    }





}
