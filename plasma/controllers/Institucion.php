<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Institucion extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            show_404();
            exit();
        }
        else {
            $this->load->model('Institucion_model', 'Model');
        }
    }

    //Obtiene las insituciones almacenadas en la base de datos
    public function get()
    {
        if($this->input->post('bandera')==1)
        {
            $result = $this->Model->getActivos();//Obtiene solo las instituciones con estado = 1(activo)
        }
        else{
            $result = $this->Model->get();//Obtiene todas las insitutcions sin importar el estado
        }
        $r = array("data"    => $result,
            "success" => "true");

        echo json_encode($r);
    }

    //Inserta una nueva institución en la base de datos
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

    //Actualiza ciertos atributos de una institución seleccionada
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

    //Elimina la institución seleccionada
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

    //Obtiene el código numérico con el que se va a guardar el registro para aumentar LP al principio del código antes de guardarlo
    public function getCodigo()
    {
        $result = $this->Model->getCodigo();
        $result[0]['codigo'] = 'LP'.$result[0]['codigo'];
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);
    }

    //Verifica si la institución seleccionada se utiliza en otra tabla de la base de datos antes de eliminarla
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

    //Verifica la existencia de una institución según el nombre para que no se repitan registros
    public function verificaInstitucion()
    {
        $busqueda = $this->input->post('nombre');
        $busqueda = trim($busqueda);
        $result = $this->Model->verificaInstitucion($busqueda);
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