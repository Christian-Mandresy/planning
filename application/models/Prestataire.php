<?php

class Prestataire extends CI_Model {

    /*
    return all Prestataires.
    created by your name
    created at 22-08-22.
    */
    public function getAll() {
        return $this->db->get('prestataire')->result();
    }
    /*
    function for create Prestataire.
    return Prestataire inserted id.
    created by your name
    created at 22-08-22.
    */
    public function insert($data) {
        $this->db->insert('prestataire', $data);
        return $this->db->insert_id();
    }

    public function insertWithV($data,$vehicule)
    {
        $this->db->trans_Start();
        $this->db->insert('prestataire', $data);
        $idpresta=$this->db->insert_id();
        for($i=0;$i<count($vehicule);$i++)
        {
            $vehicule[$i]['idprestataire']=$idpresta;
            $this->db->insert('vehicule',$vehicule[$i]);
        }
        $this->db->trans_Complete();
    }

    public function insertV($vehicule)
    {
        $this->db->trans_Start();
        for($i=0;$i<count($vehicule);$i++)
        {
            $this->db->insert('vehicule',$vehicule[$i]);
        }
        $this->db->trans_Complete();
    }
    /*
    return Prestataire by id.
    created by your name
    created at 22-08-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('prestataire')->result();
    }
    /*
    function for update Prestataire.
    return true.
    created by your name
    created at 22-08-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('prestataire', $data);
        return true;
    }
    /*
    function for delete Prestataire.
    return true.
    created by your name
    created at 22-08-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('prestataire');
        return true;
    }
    /*
    function for change status of Prestataire.
    return activated of deactivated.
    created by your name
    created at 22-08-22.
    */
    public function changeStatus($id) {
        $table=$this->getDataById($id);
             if($table[0]->status==0)
             {
                $this->update($id,array('status' => '1'));
                return "Activated";
             }else{
                $this->update($id,array('status' => '0'));
                return "Deactivated";
             }
    }

}