<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Usuario;

class Login extends BaseController
{


    public function novo(){

        $data = [
            'titulo' => 'Lealize o login',
        ]; 

        return view('Login/novo', $data);
    }

    public function criar(){ 

        if($this->request->getMethod() === 'post'){
                
            $email = $this->request->getPost('email'); 
            $password = $this->request->getPost('password'); 

            //$autenticacao = \Config\Services::autenticacao(); 

            $autenticacao = service('autenticacao'); 

            if($autenticacao->login($email, $password) ){
                $usuario = $autenticacao->pegaUsuarioLogado(); 

                if(!$usuario->is_admin){
                    
                    return redirect()->to(site_url('/')); 

                }


                //dd($usuario); 

                return redirect()->to(site_url('admin/home'))->with('sucesso', "Olá $usuario->nome, que bom 
                que está de volta"); 

            }else{

                return redirect()->back()->with('atencao', 'Não encontramos suas credenciais de acesso'); 
            }


            //dd($autenticacao); 

        }else{

            return redirect()->back(); 

        }


    }


    /*
        Vamos alterar esse metodo
    */
    public function logout(){
        service('autenticacao')->logout(); 

        return redirect()->to(site_url('login/mostraMensagemLogout'));
    }

    public function mostraMensagemLogout(){
        return redirect()->to(site_url("login"))->with('info', 'Esperamos ver você novamente'); 
    }

    
}
