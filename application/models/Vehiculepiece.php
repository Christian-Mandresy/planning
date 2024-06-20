<?php

class Vehiculepiece extends CI_Model {

    /*
    return all Vehiculepieces.
    created by your name
    created at 07-09-22.
    */
    public function getAll() {
        return $this->db->get('vehiculepiece')->result();
    }
    /*
    function for create Vehiculepiece.
    return Vehiculepiece inserted id.
    created by your name
    created at 07-09-22.
    */
    public function insert($data) {
        $this->db->insert('vehiculepiece', $data);
        return $this->db->insert_id();
    }

    /**
     * 
     * liste des entretien pieces par vehicule
     * 
     */
    public function getByNumero($numero,$limit, $start)
    {
        $sql="SELECT * from piecevehiculeentretien where numero=? order by entretiendate desc limit ? OFFSET ?";

        $query =  $this->db->query($sql, array($numero,$limit,(int)$start));
        return $query->result();
    }

    /**
     * nombre des entretiens par numero
     */
    public function count($numero)
    {
        $sql="SELECT count(*)as nbr from piecevehiculeentretien where numero=?";
        $query =  $this->db->query($sql,array($numero));
        return $query->result()[0]->nbr;
    }


    /*
    return Vehiculepiece by id.
    created by your name
    created at 07-09-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('vehiculepiece')->result();
    }
    /*
    function for update Vehiculepiece.
    return true.
    created by your name
    created at 07-09-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('vehiculepiece', $data);
        return true;
    }
    /*
    function for delete Vehiculepiece.
    return true.
    created by your name
    created at 07-09-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('vehiculepiece');
        return true;
    }
    /*
    function for change status of Vehiculepiece.
    return activated of deactivated.
    created by your name
    created at 07-09-22.
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