<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registro_model extends CI_Model
{
    public function reporteIngreso($id)
    {
        //Se obtiene el tramite
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("select pruebas.valor, marcador.nombre, interpretacion.descripcion
                                from muestra
                                inner join pruebas on muestra.id = pruebas.muestra
                                inner join marcador on marcador.id = pruebas.marcador
                                inner join interpretacion on interpretacion.id = pruebas.interpretacion
                                where muestra.id = '$id' and pruebas.tipo =1");

        $arreglo['aux'] = $query->result_array();

        $query = $this->plasma->query("select convert(varchar,muestra.fecha_recepcion,105) fecha_recepcion
                                        from muestra
                                        where id='$id'")->result_array();
        $arreglo['fecha_recepcion'] = $query;

        return $arreglo;
    }

}