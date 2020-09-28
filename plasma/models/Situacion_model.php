<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Situacion_model extends CI_Model
{
    //Obtiene todas las situaciones asociadas a una muestra verificando el is de la muestra
    public function get($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('muestra', $id);
        $query = $this->plasma->get('situacion');
        return $query->result_array();
    }

    //Elimina la situación seleccionada verificando su id
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->delete('situacion');
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Crea una nueva situación y la almacena en la base de datos
    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->insert('situacion', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza ciertos atributos de la situación seleccionado verificando su id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);

        $query = $this->plasma->update('situacion', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }
}