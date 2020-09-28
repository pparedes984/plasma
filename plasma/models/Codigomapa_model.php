<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Codigomapa_model extends CI_Model
{
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->get('codigo_mapa');
        return $query->result_array();
    }

    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->insert('codigo_mapa', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->update('codigo_mapa', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->delete('codigo_mapa');
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    public function verificar($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[pruebas]
                                      where codigo_mapa = $id");
        $query = $query->num_rows();
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }
}
