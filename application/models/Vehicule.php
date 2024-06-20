<?php

class Vehicule extends CI_Model {

    /*
    return all Vehicules.
    created by your name
    created at 09-08-22.
    */
    public function getAll($limit,$start) {
        $sql="SELECT v.*,pr.nom as prestataire from vehicule as v 
        left join prestataire as pr on v.idprestataire=pr.id order by v.idprestataire limit ? OFFSET ?";

        $query =  $this->db->query($sql, array($limit,(int)$start));
        return $query->result();
    }

    public function countall()
    {
        $sql="SELECT count(*)as nbr from vehicule";
        $query =  $this->db->query($sql);
        return $query->result()[0]->nbr;
    }

    public function getAllEntreprise()
    {
        $this->db->where('idprestataire', null);
        return $this->db->get('vehicule')->result();
    }
    /*
    function for create Vehicule.
    return Vehicule inserted id.
    created by your name
    created at 09-08-22.
    */
    public function insert($data) {
        $this->db->insert('vehicule', $data);
        return $this->db->insert_id();
    }
    /*
    return Vehicule by id.
    created by your name
    created at 09-08-22.
    */
    public function getDataById($id) {
        $this->db->where('numero', $id);
        return $this->db->get('vehicule')->result();
    }

    public function getVehiculeSansEntretien()
    {
        $this->db->where('idprestataire', null);
        $this->db->where('identretien', null);
        return $this->db->get('vehicule')->result();
    }
    

    public function getVehiculeAvecEntretien()
    {
        $sql="SELECT * from vehicule where identretien is not null and idprestataire is null";
        $query=$this->db->query($sql);
        return $query->result();
    }

    public function getDataByPrestataire($idprestataire)
    {
        $this->db->where('idprestataire', $idprestataire);
        return $this->db->get('vehicule')->result();
    }
    /*
    function for update Vehicule.
    return true.
    created by your name
    created at 09-08-22.
    */
    public function update($id,$data) {
        $this->db->where('numero', $id);
        $this->db->update('vehicule', $data);
        return true;
    }
    /*
    function for delete Vehicule.
    return true.
    created by your name
    created at 09-08-22.
    */
    public function delete($id) {
        $this->db->where('numero', $id);
        $this->db->delete('vehicule');
        return true;
    }
    /*
    function for change status of Vehicule.
    return activated of deactivated.
    created by your name
    created at 09-08-22.
    */
    public function changeStatus($numero) {
        $table=$this->getDataById($numero);
        if($table[0]->status==0)
        {
        $this->update($numero,array('status' => '1'));
        return "Activated";
        }else{
        $this->update($numero,array('status' => '0'));
        return "Desactivated";
        }
    }

}