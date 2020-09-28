<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Institucion_model extends CI_Model
{
    //Obtiene todas las instituciones de la base de datos y las ordena por el nombre ascendentemente
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->order_by('nombre', 'asc');
        $query = $this->plasma->get('institucion');
        return $query->result_array();
    }
    //Obtiene las instituciones que tengan estao = 1 (activo) y las ordena por el nombre ascendentemente
    public function getActivos()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('estado',1);
        $this->plasma->order_by('nombre', 'asc');
        $query = $this->plasma->get('institucion');
        return $query->result_array();
    }

    //Inserta una nueva institución en la base de datos
    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->insert('institucion', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza los atributos con los nuevos valores de la instición seleccionadasegún el id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->update('institucion', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Elimina la institución seleccionada dela bse de datos según el id
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->delete('institucion');
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Obtiene el código de la última institución almacenada en la base de datos y le aumenta 1
    public function getCodigo()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("SELECT IDENT_CURRENT('institucion')+1 codigo");
        return $query->result_array();
    }

    //Verifica si la institución ha sido utilizada en la tabla muestra antes de eliminarla
    public function verificar($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[muestra]
                                      where institucion = $id");
        $query = $query->num_rows();
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }

    //Verifica si el número de instituciones con un nombre que se va a ingresar es mayor que cero
    public function verificaInstitucion($nombre)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[institucion]
                                      where nombre = '$nombre'");
        $query = $query->num_rows();
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }
}
