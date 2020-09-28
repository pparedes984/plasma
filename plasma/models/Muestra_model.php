<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Muestra_model extends CI_Model
{
    /*
     * Obtiene todas las muestras almacenadas en la base de datos y las ordena por el id descendentemente
     * Se realiza una paginación para traer las muestras de 10 en 10
    */
    public function get($start, $limit)
    {
        $cantidadConsulta = $start+$limit;
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("select * from 
                            (select *,ROW_NUMBER() OVER (ORDER BY id desc) AS ROW from muestra ) it
                            where IT.row > $start and IT.row <= $cantidadConsulta;");
        return $query->result_array();
    }

    //Obtiene los datos asociados a una muestra que estan almacenados en la base de datos  incluyendo los datos asociados a
    // la muestra que se encuentran en otra tabla verificando el id de la muestra
    public function obtener($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query['marcador'] = $this->plasma->query("select muestra.id, fecha_ingreso, fecha_modificacion, fecha_recepcion, fecha_transformacion, institucion, localizacion_transformacion, situacion, estatus, ubicacion, ubicacion_plasmoteca, ubicacion_seroteca, 
                                        volumen, usuario_recepcion, usuario_transformacion, muestra_x_marcador.marcador c, observacion, concentracion_calcio
                                        from muestra
                                        inner join muestra_x_marcador on muestra_x_marcador.muestra = muestra.id 
                                        where muestra.id = $id")->result_array();
        $query['kit'] = $this->plasma->query("select muestra.id, muestra_x_kit.kit b, muestra_x_kit.abs_coi d
                                        from muestra
                                        inner join muestra_x_kit on muestra_x_kit.muestra = muestra.id 
                                        where muestra.id = $id")->result_array();
        return $query;
    }

    //crea una nueva muestra y la almacena en la base de datos
    public function create($data)
    {
        $this->plasma = $this->load->database('plasma', TRUE);

        $query = $this->plasma->insert('muestra', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }


    //Actualiza los buevos valores de los atributos de la muestra seleccionada verificando su id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->update('muestra', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Elimina l muestra seleccionada verificando su id
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->query("delete from muestra_x_kit
                                        where muestra = $id");
        $this->plasma->where('id', $id);
        $query = $this->plasma->delete('muestra');

        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Obtiene el último id de la muestra almacenado en la base de datos
    public function getUltimo()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("SELECT max(id) ultimo
                                        FROM [PLASMA].[dbo].[muestra]");
        return $query->result_array();
    }

    //Obtiene el id de la última muestra almacenada en la base de datos y se aumenta en uno el código
    public function getCodigo()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("SELECT IDENT_CURRENT('muestra')+1 codigo");
        return $query->result_array();
    }

    //Verifica la existencia de una muestra según su id
    public function existeMuestra($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("select * from [plasma].[dbo].[muestra]
                                          where id = '$id'");
        $query = $query->num_rows();
        if ($query > 0) {
            return true;
        }
        else{
            return false;
        }

    }

    //Verifica si la muestra ha sido utilizado en la tabla pruebas o en la tabla situación antes de eliminarla
    public function verificar($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[pruebas]
                                      where muestra = $id");
        $query = $query->num_rows();
        $query1= $this->plasma->query("SELECT *
                                      FROM [PLASMA].[dbo].[situacion]
                                      where muestra = $id");
        $query1 = $query1->num_rows();
        $query = $query + $query1;
        if ($query == 0) {
            return true;
        }
        else{
            return false;
        }
    }

    //Verifica la cantidad de marcadores almacenados en pruebas asociados a una muestra
    // para poder cambiar el estado de la muestra a completo cuyo tipo sea suero
    public function verificarSuero($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $suero= $this->plasma->query("SELECT count(distinct(marcador)) suero
                                        FROM [PLASMA].[dbo].[pruebas]
                                        where muestra = $id
                                        and tipo = 2;")->result_array();
        $prueba= $this->plasma->query("SELECT count(distinct(marcador)) plasma
                                        FROM [PLASMA].[dbo].[pruebas]
                                        where muestra = $id
                                        and tipo = 1;")->result_array();
        if ($suero[0]['suero']>=$prueba[0]['plasma'] && $suero[0]['suero']>0) {
            return true;
        }
        else{
            return false;
        }
    }

    //Verifica la cantidad de marcadores almacenados en pruebas asociados a una muestra
    // para poder cambiar el estado de la muestra a completo cuyo tipo sea plasma
    public function verificarPlasma($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $prueba= $this->plasma->query("SELECT count(distinct(marcador)) plasma
                                        FROM [PLASMA].[dbo].[pruebas]
                                        where muestra = $id
                                        and tipo = 1;")->result_array();
        $marcador= $this->plasma->query("SELECT count(*) marcador
                                            FROM [PLASMA].[dbo].muestra_x_marcador
                                            where muestra = $id;")->result_array();
        if ($marcador[0]['marcador']<=$prueba[0]['plasma']) {
            return true;
        }
        else{
            return false;
        }
    }

    public function busquedaCodigo($codigo){
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("select *
                                        from muestra where id like '$codigo%';");
        return $query->result_array();
    }

    public function busquedaEstado($estado, $start, $limit){
        $cantidadConsulta = $start+$limit;
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("select * from (select *,ROW_NUMBER() OVER (ORDER BY id desc) AS ROW 
                                        from muestra where estatus = $estado) it
                                        where IT.row > $start and IT.row <= $cantidadConsulta;");
        return $query->result_array();
    }

    public function getTotal()
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->order_by('id', 'desc');
        $query = $this->plasma->get('muestra');
        return $query->num_rows();
    }
}
