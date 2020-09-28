<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Situacion extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            show_404();
            exit();
        }
        else {
            $this->load->model('Situacion_model', 'Model');
        }
    }

    //Obtiene todos las situaciones almacenadas en la base de datos
    public function get()
    {
        $result = $this->Model->get($this->input->post('id'));
        $r = array("data" => $result,
            "success" => "true");

        echo json_encode($r);
    }

    //Elimina la situación seleccionada
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

    //Inserta una nueva situación asociado e una muestra en la base de datos
    public function create()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        unset($data['volumen']);
        unset($data['cbsituacion']);
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

    //Actualiza ciertos atributos de la situación seleccionada
    public function update()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        unset($data['id']);
        $result = $this->Model->update($data, $this->input->post('id'));
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