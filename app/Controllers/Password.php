<?php

namespace App\Controllers;

use App\Controllers\BaseController;
//use App\Entities\Usuario;

class Password extends BaseController{
    

    private $usuarioModel; 

    public function __construct(){   
        $this->usuarioModel = new \App\Models\UsuarioModel(); 
    }

    public function esqueci(){

        $data = [
            'titulo ' => 'Esqueci a minha senha', 
        ];

        return view('Password/esqueci', $data); 


    }

    public function processaEsqueci(){
        if($this->request->getMethod()==='post'){

            //dd($this->request->getPost()); 
            $usuario = $this->usuarioModel->buscaUsuarioPorEmail($this->request->getPost('email')); 

            if($usuario === null || !$usuario->ativo){
                return redirect()->to(site_url('password/esqueci'))->back()
                ->with('atencao', 'Não encontramos uma conta invalida com esse email')
                ->withInput();
            }

            $usuario->iniciaPasswordReset(); 


            /* 
                Precisamos atualizar o modelo Usuario 
            */

            $this->usuarioModel->save($usuario);  
           
            $this->enviaEmailRedefinicaoSenha($usuario); 
            return redirect()->to(site_url('login'))->with('sucesso', ' Email de redefinição de senha enviado 
            para sua caixa de entrada');
            
        }else{

            /* Não é POST */
            return redirect()->back(); 
        }
    }

    public function processaReset($token = null){
        if($token === null){
            return redirect()->to(site_url('password/esqueci'))->with('atencao','Link invalido ou expirado'); 

        }

        $usuario = $this->usuarioModel->buscaUsuarioParaResetarSenha($token); 

        if($usuario != null){

            //dd($this->request->getPost());
            $usuario->fill($this->request->getPost()); 

            if($this->usuarioModel->save($usuario)){

                /* 
                    Setando as col 'reset_hast' e 'reset_exp._at' como null ao invocar o metodo abaixo
                    que foi definido na entidade user

                    Invalidamos o link antigo que foi enviado para o email do usuario 
                */

                $usuario->completaPasswordReset(); 

                /* 
                    Atualizamos novam o usuario com os novos valores definidos acima
                */
                $this->usuarioModel->save($usuario);

                return redirect()->to(site_url('login'))->with('sucesso', ' Nova senha cadastrada com sucesso!'); 
            }else{
                
                return redirect()->to(site_url("password/reset/$token"))->with('errors_model', $this->usuarioModel->errors())
                 ->with('atencao',"Por favor verifique os erros abaixo")
                 ->withInput();

            }



        }else{

            return redirect()->to(site_url('password/esqueci'))->with('atencao','Link invalido ou expirado');

        }

        //dd($usuario); 
    }

    private function enviaEmailRedefinicaoSenha(object $usuario){

        $email = service('email'); 

        $email->setFrom('no-reply@fooddelivery.com.br', 'Food Delivery');
        $email->setTo($usuario->email);
           

        $email->setSubject('Resetta sua senha');
        
        $mensagem = view('Password/reset_email',['token' => $usuario->reset_token]); 
        
        $email->setMessage($mensagem);

        $email->send();
            


    }

    public function reset($token = null){

        if($token === null){
            return redirect()->to(site_url('password/esqueci'))->with('atencao','Link invalido ou expirado'); 

        }

        $usuario = $this->usuarioModel->buscaUsuarioParaResetarSenha($token); 

        if($usuario != null){

            $data =  [
                'titulo' => 'Redefina a sua senha', 
                'token' => $token, 
            ];

            return view('Password/reset', $data); 

        }else{

            return redirect()->to(site_url('password/esqueci'))->with('atencao','Link invalido ou expirado');

        }

        //dd($usuario); 

    }



}