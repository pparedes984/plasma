<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Muestra extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->input->is_ajax_request()) {
            show_404();
            exit();
        }
        else {
            $this->load->model('Muestra_model', 'Model');
        }
    }
    //Obtiene las muestras almacenadas en la base de datos
    public function get()
    {
        //Se manda como parámetros un inicio y un final del número de muestras que se desean obtener
        $start = $this->input->post('start');
        $limit = $this->input->post('limit');
        //Se realiza la busqueda si es que se recibe como parametro la busqueda 1 y se busca dependiendo del estado
        if($this->input->post('busqueda') == 1){
            $result = $this->Model->busquedaEstado($this->input->post('estado'),$start,$limit);
            $cantidad = count($result);
        }
        //Se realiza la busqueda de la muestra según el id de la muestra que se desea buscar
        else if($this->input->post('busqueda') == 2)
        {
            $result = $this->Model->busquedaCodigo($this->input->post('codigo'));
            $cantidad = count($result);
        }
        else{
            $result = $this->Model->get($start,$limit);
            $cantidad = $this->Model->getTotal();
        }
        //Se verifica si esque el ´lasma y el suero estan completoso incompletos para presentar este dato
        $plasma = $this->verificarPlasma($result);
        $suero = $this->verificarSuero($plasma);
        $r = array("data"    => $suero,
            "cantidad" => $cantidad,
            "success" => "true");
        echo json_encode($r);
    }

    //Obtiene los datos de una muestra seleccionada para cargarlos posteriormente
    public function obtener()
    {
        $result = $this->Model->obtener($this->input->post('muestra'));
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);
    }

    //Ingresa una muestra en la base de datos
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

    //Actualiza ciertos atributos de la muestra seleccionada
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

    //Elimina la muestra selecciionada
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


    public function guardar()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        $data['usuario_recepcion']= $this->session->session_usuario_apps;
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

    public function getCodigoIns()
    {
        $result = $this->Model->getCod();
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);
    }

    public function getUltimo()
    {
        $result = $this->Model->getUltimo();
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);
    }

    public function getCodigo()
    {
        $result = $this->Model->getCodigo();
        $r = array("data"    => $result,
            "success" => "true");
        echo json_encode($r);
    }

    public function verificar()
    {
        if ($this->input->post('muestra') == "null")
        {
            $id = null;
            $result = $this->Model->existeMuestra($id);
        }
        else
            $result = $this->Model->existeMuestra($this->input->post('muestra'));
        if($result)
        {
            $r = array("success" => "true");
        }
        else
        {
            $r = array("failure" => "false");
        }
        echo json_encode($r);
    }

    //Actualiza los nuevos valores de los atributos relacionados con la situación de na muestra
    public function updateSituacion()
    {
        $data['situacion'] = $this->input->post('situacion');
        $data['volumen'] = $this->input->post('volumen');
        $result = $this->Model->update($data,$this->input->post('muestra'));
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

    public function updateMuestra()
    {
        $data = json_decode($this->input->post('data'), TRUE);
        $transformacion = isset($data['usuario_transformacion']);
        if($transformacion) {
            if ($data['usuario_transformacion'] == null) {
                $data['usuario_transformacion'] = $this->session->session_usuario_apps;
            }
        }
        else
            $data['usuario_transformacion'] = $this->session->session_usuario_apps;

        date_default_timezone_set('America/Bogota');
        $data['fecha_modificacion'] = date("Y-m-d ");

        if(isset($data['estatus'])){
        if($data['estatus'] == 1){
            $data['observacion'] = null;
        }
        else{
            $data['localizacion_transformacion'] = null;
            $data['ubicacion_seroteca'] = null;
            $data['volumen'] = null;
            $data['concentracion_calcio'] = null;
        }
        }

        $result = $this->Model->update($data,$this->input->post('muestra'));
        if($result){
            $r = array("success" => "true");
        }
        else{
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    public function verificarMuestra()
    {
        $result = $this->Model->verificar($this->input->post('id'));
        if($result){
            $r = array("success" => "true");
        }
        else{
            $r = array("failure" => "true");
        }
        echo json_encode($r);
    }

    public function verificarSuero($resp)
    {
        for ($i = 0;$i<count($resp);$i++) {
            $result = $this->Model->verificarSuero($resp[$i]['id']);
            if($result == true)
                $resp[$i]['estado_suero'] = 'Completo';
            else
                $resp[$i]['estado_suero'] = 'Incompleto';
        }
        return $resp;
    }

    public function verificarPlasma($resp)
    {
       for ($i = 0;$i<count($resp);$i++) {
            $result = $this->Model->verificarPlasma($resp[$i]['id']);
            if($result == true)
                $resp[$i]['estado_plasma'] = 'Completo';
            else
                $resp[$i]['estado_plasma'] = 'Incompleto';
        }
        return $resp;
    }

    //Verifica si se completo las pruebas de suero haciendo un conteo de los marcadores que se debió utilizar para la prueba
    public function comprobarSuero()
    {
        $result = $this->Model->verificarSuero($this->input->post('data'));
        if($result == true)
            $resp['estado_suero'] = 'Completo';
        else
            $resp['estado_suero'] = 'Incompleto';

        echo json_encode($resp);
    }

    //Verifica si se completo las pruebas de plasma haciendo un conteo de los marcadores que se debió utilizar para la prueba
    public function comprobarPlasma()
    {
        $result = $this->Model->verificarPlasma($this->input->post('data'));
        if($result == true)
            $resp['estado_plasma'] = 'Completo';
        else
            $resp['estado_plasma'] = 'Incompleto';

        echo json_encode($resp);
    }
}