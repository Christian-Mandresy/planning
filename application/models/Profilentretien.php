<?php

class Profilentretien extends CI_Model {

    /*
    return all Profilentretiens.
    created by your name
    created at 26-08-22.
    */
    public function getAll() {
        return $this->db->get('profilentretien')->result();
    }
    /*
    function for create Profilentretien.
    return Profilentretien inserted id.
    created by your name
    created at 26-08-22.
    */
    public function insert($data) {
        $this->db->insert('profilentretien', $data);
        return $this->db->insert_id();
    }

    public function insertWithPiece($data,$piece)
    {
        $this->db->trans_Start();
        $this->db->insert('profilentretien', $data);
        $idprofil=$this->db->insert_id();
        for($i=0;$i<count($piece);$i++)
        {
            $piece[$i]['identretien']=$idprofil;
            $this->db->insert('entretienpiece',$piece[$i]);
        }
        $this->db->trans_Complete();
    }

    public function insertPiece($piece)
    {
        $this->db->trans_Start();
        try
        {
            $this->db->insert_batch('entretienpiece',$piece);
        }
        catch(Exception $e)
        {
            throw new Exception('veuiller verifier si les pièces ne sont pas déja inserer');
        }
        
        $this->db->trans_Complete();
    }

    public function modifyPiece($data)
    {
      	$this->db->where('idpiece',$data['idpiece']);
        $this->db->where('identretien',$data['identretien']);
        $this->db->update('entretienpiece', $data);
        return true;
    }

    /*
    return Profilentretien by id.
    created by your name
    created at 26-08-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('profilentretien')->result();
    }


    /*
    function for update Profilentretien.
    return true.
    created by your name
    created at 26-08-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('profilentretien', $data);
        return true;
    }
    
    /*
    function for delete Profilentretien.
    return true.
    created by your name
    created at 26-08-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('profilentretien');
        return true;
    }


}