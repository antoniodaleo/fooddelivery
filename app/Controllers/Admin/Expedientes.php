<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Expedientes extends BaseController
{

    private $expedienteModel; 


    public function __construct(){
       
        $this->expedienteModel = new  \App\Models\ExpedienteModel(); 
    }

    public function expedientes(){

        if($this->request->getMethod()=== 'post'){
            //dd($this->request->getPost()); 
            $postExpedientes = $this->request->getPost(); 

            $arrayExpedientes = []; 

            for($contador = 0; $contador < count($postExpedientes['dia_descricao']); $contador++  ){

                //echo $postExpediente['dia_descricao'][$contador].'<br>'; 
                array_push($arrayExpedientes, [
                    'dia_descricao' => $postExpedientes['dia_descricao'][$contador], 
                    'abertura' => $postExpedientes['abertura'][$contador], 
                    'fechamento' => $postExpedientes['fechamento'][$contador], 
                    'situacao' => $postExpedientes['situacao'][$contador], 
                ]);

                //dd($arrayExpedientes); 
            } // Fim do for

            
            $this->expedienteModel->updateBatch($arrayExpedientes, 'dia_descricao'); 

            return redirect()->back()->with('sucesso', 'Expedientes atualizados com sucesso'); 

        }
       
        $data = [
            'titulo' => 'Gerenciar o horário de funcionamento', 
            'expedientes' => $this->expedienteModel->findAll(), 
        ];


        //dd($data['expedientes']); 

        return view('Admin/Expedientes/expedientes', $data);



    }



}
