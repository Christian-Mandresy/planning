<?php

class Profilpiece extends CI_Model {

    public function getAll() {
        return $this->db->get('profilentretien')->result();
    }

    public function getByEntretien($identretien) {
        $this->db->where('id', $identretien);
        return $this->db->get('profilpieces')->result();
    }


    public function updateEntretienPiece($identretien,$idpiece,$data)
    {
        $this->db->where('identretien', $identretien);
        $this->db->where('idpiece', $idpiece);
        $this->db->update('entretienpiece');
        return true;
    }

    /**
     * utiliser pour lister les pièces d'un entretien 
     * 
     */
    public function getPiecesByVoiture($idvoiture)
    {
        $this->db->where('numero',$idvoiture);
        $identretien=$this->db->get('vehicule')->result()[0]->identretien;
        $this->db->select('id,idpiece, piece');
        $this->db->from('profilpieces');
        $this->db->where('id', $identretien);
        return $this->db->get()->result();
    }


    /**
     * liste des pièces d'un entretien
     */

     public function getPiecesByEntretien($identretien)
     {
        $this->db->select('piece, kilometrage');
        $this->db->from('profilpieces');
        $this->db->where('id', $identretien);
        return $this->db->get()->result();
     }

}

?>