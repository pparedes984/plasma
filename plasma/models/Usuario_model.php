<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
    //Obtiene todos los usuarios almacenados en la base de datos y los ordena por el usuario ascendentemente
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        /*$query = $this->plasma->query("SELECT usuario, cedula, nombre, usuario.estado, email, rol.descripcion rol
                                        FROM [PLASMA].[dbo].[usuario]
                                        inner join rol on rol.id = usuario.rol;");*/
        $this->plasma->order_by('usuario', 'asc');
        $query = $this->plasma->get('usuario');
        return $query->result_array();
    }

    //Crea un nuevo usuario en la base de datos
    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->insert('usuario', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza ciertos atributos del usuario seleccionado verificando el id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('usuario', $id);
        $query = $this->plasma->update('usuario', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Elimina el usuario seleccionado verificando el id
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('usuario', $id);
        $query = $this->plasma->delete('usuario');
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Comprueba que el usuario buscado exista
    function existeUsuario($usuario)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("select * from [plasma].[dbo].[usuario]
                                          where usuario = '$usuario'
                                          and  estado = 1");
        $query = $query->num_rows();
        if ($query > 0) {
            return true;
        }
        else{
            return false;
        }

    }

    //Comprueba el rol asociado a un usuario para darle permisos dentro del sistema según su rol
    function revisa_rol($usuario)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("SELECT rol
                                              FROM [plasma].[dbo].[usuario]
                                              where usuario = '$usuario'");
        return $query->result_array();
    }

    //Verifica si el usuario ha sido utilizado en la tabla muestra o en la tabla pruebas o en la tabla situación antes de eliminarlo
    public function verificar($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[muestra]
                                      where usuario_transformacion = '$id'
                                      or usuario_recepcion = '$id'");
        $query = $query->num_rows();
        $query1= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[pruebas]
                                      where usuario = '$id'");
        $query1 = $query1->num_rows();
        $query2= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[situacion]
                                      where usuario = '$id'");
        $query2 = $query2->num_rows();
        $query = $query + $query1 + $query2;
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }
}