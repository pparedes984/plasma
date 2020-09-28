<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas_model extends CI_Model
{
    //Obtiene todas las pruebas almacenadas en la base de datos
    public function get()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->get('pruebas');
        return $query->result_array();
    }

    //Obtiene todos los sueros asociados a una muestra verificado su id y el tipo
    public function getSuero($muestra)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("SELECT [marcador]
                                        ,[kit]
                                        ,[valor]
                                        ,[lote]
                                        ,[fecha_caducidad]
                                        ,[usuario]
                                        ,[codigo_mapa]
                                        ,[orden]
                                        ,[interpretacion]
                                        ,t1.[id]
                                        ,[tipo]
                                        ,[muestra]
                                        ,[fecha_caracterizacion],
                                        t4.[nombre] casa_comercial 
                                        FROM [PLASMA].[dbo].[pruebas] t1  
                                        inner join [PLASMA].[dbo].kit t2 on t2.id = t1.kit
                                        inner join [PLASMA].[dbo].casa_comercial t4 on t2.casa_comercial = t4.id 
                                        where muestra = $muestra and tipo = 2");
        return $query->result_array();
    }

    //Elimina la prueba seleccionada verificando el id de la muestra
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->delete('pruebas');
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Obtiene todos los plasmas asociados a una muestra verificado su id y el tipo
    public function getPlasma($muestra)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("SELECT [marcador]
                                        ,[kit]
                                        ,[valor]
                                        ,[lote]
                                        ,[fecha_caducidad]
                                        ,[usuario]
                                        ,[codigo_mapa]
                                        ,[orden]
                                        ,[interpretacion]
                                        ,t1.[id]
                                        ,[tipo]
                                        ,[muestra]
                                        ,[fecha_caracterizacion],
                                        t4.[nombre] casa_comercial 
                                        FROM [PLASMA].[dbo].[pruebas] t1  
                                        inner join [PLASMA].[dbo].kit t2 on t2.id = t1.kit
                                        inner join [PLASMA].[dbo].casa_comercial t4 on t2.casa_comercial = t4.id 
                                        where muestra = $muestra and tipo = 1");
            return $query->result_array();
    }

    //Crea una nueva prueba y la almacena en la base de datos
    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->insert('pruebas', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza los valores nuevos de ciertos atributos de la prueba verificando su id
    public function update($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $data['id']);
        unset($data['id']);
        $query = $this->plasma->update('pruebas', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }
}