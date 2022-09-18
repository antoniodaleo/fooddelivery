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
       
        $data = [
            'titulo' => 'Gerenciar o horário de funcionamento', 
            'expedientes' => $this->expedienteModel->findAll(), 
        ];


        //dd($data['expedientes']); 

        return view('Admin/Expedientes/expedientes', $data);



    }



}
