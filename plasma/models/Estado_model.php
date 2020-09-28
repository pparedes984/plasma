<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_model extends CI_Model
{
    //Obtiene todos los estados de la base de datos
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->get('estado');
        return $query->result_array();
    }
}