<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kit_model extends CI_Model
{
    //Obtiene todos los kits  y los ordena por nombre
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->order_by('casa_comercial asc , nombre asc');
        $query = $this->plasma->get('kit');
        return $query->result_array();
    }

    //Obtiene todas los kits con estado=1(activo) y concatena con la casa comercial asociada al kit
    public function getActivos()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("SELECT kit.[id]
                                          ,kit.[estado]
                                          ,concat(kit.[nombre],' - ',casa_comercial.[nombre]) nombre
                                          ,kit.[casa_comercial]
                                      FROM [PLASMA].[dbo].[kit]
                                      inner join casa_comercial on kit.casa_comercial = casa_comercial.id
                                      where kit.estado = 1
                                      order by casa_comercial.nombre");
        return $query->result_array();
    }

    //Inserta un nuevo kit en la base de datos
    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->insert('kit', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza los nuevos valores de los atributos de un kit seleccionado según su id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->update('kit', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Elimina el kit selccionado verificando el id
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->delete('kit');
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Verifica si el kit ha sido utilizado en la tabla muestra o en la tabla pruebas antes de eliminarlo
    public function verificar($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[muestra]
                                      where id = $id");
        $query = $query->num_rows();
        $query1= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[pruebas]
                                      where id = $id");
        $query1 = $query1->num_rows();
        $query = $query + $query1;
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }

    //Verifica si el número de kits con un nombre que se va a ingresar es mayor que cero
    public function verificaKit($nombre, $casa)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[kit]
                                      where nombre = '$nombre'
                                      and casa_comercial = $casa");
        $query = $query->num_rows();
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }

    //Obtiene los datos de la prueba guardada verificando su id
    public function getParametro($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id',$id);
        $query = $this->plasma->get('kit');
        return $query->result_array();
    }
}
