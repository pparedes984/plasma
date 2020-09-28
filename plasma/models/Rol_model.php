<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rol_model extends CI_Model
{

    //Obtiene todos los roles almacenados en la base de datos
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->order_by('descripcion', 'asc');
        $query = $this->plasma->get('rol');
        return $query->result_array();
    }

    //Crea un nuevo rol y lo almacena en la bse de datos
    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->insert('rol', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza ciertos atributos del rol verificando su id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->update('rol', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Elimna el rol seleccionado verificando su id
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->delete('rol');
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }
}