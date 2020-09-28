<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Interpretacion_model extends CI_Model
{
    //Obtiene todas las interpretaciones de la base de datos
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->get('interpretacion');
        return $query->result_array();
    }
}