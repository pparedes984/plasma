<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            show_404();
            exit();
        }
        else {
            $this->load->model('Usuario_model', 'Model');
        }
    }

    //Obtiene todos los usuarios del sistema almacenados en la base de datos
    public function get()
    {
        $result = $this->Model->get();
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);
    }

    //Crea un nuevo usuario en la base de datos
    public function create()
    {
        $data = json_decode($this->input->post('data'), TRUE);
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

    //Actualiza ciertos atributos del usuario seleccionado
    public function update()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        unset($data['id']);
        $result = $this->Model->update($data,$this->input->post('id'));
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

    //Elimina el usuario seleccionado
    public function delete()
    {
        $result = $this->Model->delete($this->input->post('usuario'));
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

    //Verifica si el usuario seleccionado se utiliza en otra tabla de la base de datos antes de eliminarlo
    public function verificar()
    {
        $result = $this->Model->verificar($this->input->post('id'));
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
