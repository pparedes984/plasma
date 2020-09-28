<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Casacomercial_model extends CI_Model
{
    //Obtiene todas la casas comerciales  y las ordena por nombre
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->order_by('nombre', 'asc');
        $query = $this->plasma->get('casa_comercial');

        return $query->result_array();
    }

    //Inserta una nueva casa comercial en la base de datos
    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->insert('casa_comercial', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza los nuevos valores de los atributos de una casa comecial seleccionada según su id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->update('casa_comercial', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Elimina la casa comercial selccionada por el id
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->delete('casa_comercial');
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Verifica si la casa comercial ha sido utilizada en la tabla prueba o kit antes de elimarla
    public function verificar($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[pruebas]
                                      where casa_comercial = $id");
        $query = $query->num_rows();
        $query1= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[kit]
                                      where casa_comercial = $id");
        $query1 = $query1->num_rows();
        $query = $query+$query1;
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }

    //Verifica si el número de casas comerciales con un nombre que se va a ingresar es mayor que cero
    public function verificaCasa($nombre)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[casa_comercial]
                                      where nombre = '$nombre'");
        $query = $query->num_rows();
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }

    //Obtiene todas las casas con estado=1(activo) y lasordena por el nombre ascendentemente
    public function getActivos()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('estado', 1);
        $this->plasma->order_by('nombre', 'asc');
        $query = $this->plasma->get('casa_comercial');

        return $query->result_array();
    }

    /*
    public function getCasa($casa)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->where('id',$casa);
        $query = $this->plasma->where('estado',1);
        //$this->plasma->order_by('nombre', 'asc');
        $query = $this->plasma->get('casa_comercial');

        return $query->result_array();
    }*/

}