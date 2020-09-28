<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muestramarcador extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            show_404();
            exit();
        }
        else {
            $this->load->model('Muestramarcador_model', 'Model');
        }
    }
    //Inserta un nuevo registro que tenga asociado el id de una muestra y de un marcador
    public function guardar()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        $data['muestra']= $this->input->post('id');
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

    //Actualiza los marcadores asociados a la muestra seleccionada
    public function update()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        $result = $this->Model->delete($this->input->post('id'));
        $this->guardar();
    }

    //Obtiene todos los marcadores asociados a la muestra seleccionada
    public function obtener()
    {
        $result = $this->Model->obtener($this->input->post('muestra'));
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);
    }
}