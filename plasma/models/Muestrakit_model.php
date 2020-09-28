<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Muestrakit_model extends CI_Model
{
    //Crea nuevos registros en la base de datos asociando un kit a una muestra
    public function create($data)
    {

        $this->plasma = $this->load->database('plasma', TRUE);
        //Se realiza si solo se quiere asociar un kit a una muestra
        if(count($data['kit'])==1){
            $query = $this->plasma->insert('muestra_x_kit', $data);
        }
        //Se realiza para almacenar varios kits asociados a una misma muestra
        else{
            for ($i = 0; $i<count($data['kit']); $i++){
                $dato['kit'] = $data['kit'][$i];
                $dato['abs_coi'] = $data['abs_coi'][$i];
                $dato['muestra'] = $data['muestra'];
                $query = $this->plasma->insert('muestra_x_kit', $dato);
            }

        }
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Actualiza los nuevos valores de los kits asociados a una muestra según su id
    public function update($data,$id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $this->plasma->where('id', $id);
        $query = $this->plasma->update('muestra_x_kit', $data);
        if($query)
            return 'TRUE';
        else
            return 'FALSE';
    }

    //Obtiene el número total de kits asociados a una muestra verificando su id
    public function obtener($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);
        $query = $this->plasma->query("select count(kit) contador
                                        from muestra_x_kit
                                        where muestra = $id");
        return $query->result_array();
    }

    //Elimina el kit asociado a una muestra verificando el id de la muestra
    public function delete($id)
    {
        $this->plasma = $this->load->database('plasma', TRUE);

        $query = $this->plasma->query("delete from muestra_x_kit
                                        where muestra = $id");
        if ($query) {
            return true;
        }
        else{
            return false;
        }
    }

}