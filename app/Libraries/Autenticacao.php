<?php  

namespace App\Libraries;

/* 
    @descricao essa biblioteca / classe cuidara da parte da autenticacao na nossa autenticacao

*/

class Autenticacao{

    private $usuario; 

    /* 
        string $email
        string $password
        return boolean
    */

    public  function login(string $email, string $password){

        $usuarioModel = new \App\Models\UsuarioModel(); 
        $usuario  =  $usuarioModel->buscaUsuarioPorEmail($email); 

        /* Se não encontrar o usuario por email , retorna false */
        if($usuario === null){
            return false; 
        }

        if(!$usuario->verificaPassword($password)){
            return false; 
        }

        /* So permitiremos o login de usuarios ativos */
        if(!$usuario->ativo){
            return false; 
        }


        // Aqui esta tudo ok para logar
        $this->logaUsuario($usuario); 

        return true; 
    }

    public function logout(){
        session()->destroy(); 
    }


    public function pegaUsuarioLogado(){

        if($this->usuario === null){
            $this->usuario = $this->pegaUsuarioDaSessao(); 
        }

        /* Retorn. o Usuario que foi definido no inicio da classe */
        return $this->usuario; 
    }

    public function pegaUsuarioDaSessao(){

        /*
            não esquecer de compartilhar a instancia com services
        
        */

        if(!session()->has('usuario_id')){

            return null; 
        }

        /* Instanciamos o MOdel usuairo */
        $usuarioModel = new \App\Models\UsuarioModel(); 

        /* Recupero o usuario de acordo com a chave da sessao usuario id */
        $usuario = $usuarioModel->find(session()->get('usuario_id'));
        

        /* So retorno o objeto usuario se o mesmo for encontrado ativo */
        if($usuario && $usuario->ativo){    
            return $usuario; 
        }
    }

    /* 
     @descricao : O metodo permite ficar logado na App se estar ativo. 
     @Return type boolean 
    */
    public function estaLogado(){
        return $this->pegaUsuarioLogado() !== null; 
    }


    /* Metodos privados ---------------------------------------------------------*/
    private function logaUsuario(object $usuario){
        $session = session(); 
        $session->regenerate(); 
        $session->set('usuario_id', $usuario->id); 
    }

}
