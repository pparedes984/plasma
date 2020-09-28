<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Status_model extends CI_Model
{
    //Obtiene todas los estados almacenados en la base de datos y los ordena por el id ascendentemente
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->order_by('id', 'asc');
        $query = $this->plasma->get('status');
        return $query->result_array();
    }
}