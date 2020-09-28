<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tiposituacion_model extends CI_Model
{
    //Obtiene todos los tipos de situaciones almacenados en la base de datos y los ordena por id ascendentemente
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->order_by('id', 'asc');
        $query = $this->plasma->get('Tipo_situacion');
        return $query->result_array();
    }
}