<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Marcador_model extends CI_Model
{
    //Obtiene todos los marcadores  y los ordena por nombre
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->order_by('nombre', 'asc');
        $query = $this->plasma->get('marcador');
        return $query->result_array();
    }

    //Inserta un nuevo marcador en la base de datos
    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->insert('marcador', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza los nuevos valores de los atributos de un marcador seleccionado según su id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->update('marcador', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Elimina el marcador selccionado verificando el id
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->delete('marcador');
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Verifica si el marcador ha sido utilizado en la tabla muestra_x_marcador o en la tabla pruebas antes de eliminarlo
    public function verificar($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[pruebas]
                                      where marcador = $id");
        $query = $query->num_rows();
        $query1= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[muestra_x_marcador]
                                      where marcador = $id");
        $query1 = $query1->num_rows();
        $query = $query+$query1;
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }

    //Verifica si el número de marcadores con un nombre que se va a ingresar es mayor que cero
    public function verificaMarcador($nombre)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[marcador]
                                      where nombre = '$nombre'");
        $query = $query->num_rows();
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }

    //Obtiene todas los marcadores con estado=1(activo) y los ordena por el nombre
    public function getActivos()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("SELECT *
                                      FROM marcador
                                      where estado = 1
                                      order by nombre");

        return $query->result_array();
    }
}