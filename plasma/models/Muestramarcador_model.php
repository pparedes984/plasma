<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muestramarcador_model extends CI_Model
{

    //Crea nuevos registros en la base de datos asociando un marcador a una muestra
    public function create($data)
    {

        $this->plasma = $this->load->database('plasma', TRUE);
        //Se realiza si solo se quiere asociar un kit a una muestra
        if(count($data['marcador'])==1){
            $query = $this->plasma->insert('muestra_x_marcador', $data);
        }
        //Se realiza para almacenar varios kits asociados a una misma muestra
        else{
            for ($i = 0; $i<count($data['marcador']); $i++){
                $dato['marcador'] = $data['marcador'][$i];
                $dato['muestra'] = $data['muestra'];
                $query = $this->plasma->insert('muestra_x_marcador', $dato);
            }

        }
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza los nuevos valores de los marcadores asociados a una muestra según su id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->update('muestra_x_marcador', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Obtiene el número total de marcadores asociados a una muestra verificando su id
    public function obtener($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("select count(marcador) contador
                                        from muestra_x_marcador
                                        where muestra = $id");
        return $query->result_array();
    }

    //Elimina el marcador asociado a una muestra verificando el id de la muestra
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);

        $query = $this->plasma->query("delete from muestra_x_marcador
                                        where muestra = $id");
        if ($query) {
            return true;
        }
        else{
            return false;
        }
    }

}