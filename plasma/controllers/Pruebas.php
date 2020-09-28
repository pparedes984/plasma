<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            show_404();
            exit();
        }
        else {
            $this->load->model('Pruebas_model', 'Model');
        }
    }
    //Obtiene las pruebas almacenadas en la base de datos
    public function get()
    {
        if($this->input->post('bandera')==2)
        {
            $result = $this->Model->getPlasma($this->input->post('id'));//Obtiene todas las muestras asociadas a una muestra con tipo = 1(plasma)
        }
        else {
            $result = $this->Model->getSuero($this->input->post('id'));//Obtiene todas las muestras asociadas a una muestra con tipo = 2(suero)
        }
        $r = array("data" => $result,
            "success" => "true");
        echo json_encode($r);
    }

    //Elimina la prueba seleccionada
    public function delete()
    {
        $result = $this->Model->delete($this->input->post('id'));
        if($result)
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    //Inserta una prueba en la base de datos, asociada a una muestra
    public function create()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        unset($data['codigo_mapa']);
        if($this->input->post('bandera')==1){
            $data['tipo'] = 1;
        }
        else{
            $data['tipo'] = 2;
        }

        $data['muestra'] = $this->input->post('muestra');
        $data['usuario'] = $this->session->session_usuario_apps;
        $result = $this->Model->create($data);
        if($result)
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    //Actualiza ciertos atributos de una prueba seleccionada
    public function update()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        $result = $this->Model->update($data);
        if($result)
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }
}