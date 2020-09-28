<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Casacomercial extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            show_404();
            exit();
        }
        else {
            $this->load->model('Casacomercial_model', 'Model');
        }
    }

    //Obtiene las casas comerciales almacenadas en la base de datos
    public function get()
    {
        if($this->input->post('bandera')==1)
        {
            $result = $this->Model->getActivos();//Obtiene solo las casas comerciales con estado = 1(activo)
        }
        else{
            $result = $this->Model->get();//Obtiene todas las casas comerciales sin importar el estado
        }
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);
    }

    //Inserta una nueva casa comercial en la base de datos
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

    //Actualiza ciertos atributos de una casa comercial seleccionada
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

    //Elimina la casa comercial seleccionada
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

    //Verifica si la casa comercial seleccionada se utiliza en otra tabla de la base de datos antes de eliminarla
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

    //Verifica la existencia de una casa comercial según el nombre para que no se repitan registros
    public function verificaCasa()
    {
        $busqueda = $this->input->post('nombre');
        $busqueda = trim($busqueda);
        $result = $this->Model->verificaCasa($busqueda, $this->input->post('casa'));
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

    //Obtiene una casa comecial específica
    /*public function getCasa()
    {

        $result = $this->Model->getCasa($this->input->post('casa'));
        $r = array("data"    => $result,
            "success" => "true");

        echo json_encode($r);
    }*/
}
