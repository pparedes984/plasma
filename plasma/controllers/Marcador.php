<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marcador extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            show_404();
            exit();
        }
        else {
            $this->load->model('Marcador_model', 'Model');
        }
    }
    //Obtiene los marcadores almacenados en la base de datos
    public function get()
    {
        if($this->input->post('bandera')==1)
        {
            $result = $this->Model->getActivos();//Obiene solo los marcadores con estado =  1(activo)
        }
        else {
            $result = $this->Model->get();//Obtiene todos los marcadores sin importar su estado
        }
        $r = array("data" => $result,
            "success" => "true");
        echo json_encode($r);
    }

    //Inserta un nuevo marcador en la base de datos
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

    //Actualiza ciertos atributos del marcador seleccionado
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

    //Elimina el marcador seleccionado
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

    //Verifica si el marcador seleccionado se utiliza en otra tabla de la base de datos antes de eliminarlo
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

    //Verifica la existencia de un marcador según el nombre para que no se repitan registros
    public function verificaMarcador()
    {
        $busqueda = $this->input->post('nombre');
        $busqueda = trim($busqueda);
        $result = $this->Model->verificaMarcador($busqueda);
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