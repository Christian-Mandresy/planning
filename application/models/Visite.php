<?php

class Visite extends CI_Model {

    /*
    return all Visites.
    created by your name
    created at 10-08-22.
    */
    public function getAll($limit,$start) {
        $this->db->from('visite');
		$this->db->order_by("datedebut", "desc");
		$this->db->limit($limit, $start);
		$query = $this->db->get(); 
		return $query->result();
    }

    public function get_count() {
        return $this->db->count_all('visite');
    }
    /*
    function for create Visite.
    return Visite inserted id.
    created by your name
    created at 10-08-22.
    */
    public function insert($data) {
        $this->db->insert('visite', $data);
        return $this->db->insert_id();
    }
    /*
    return Visite by id.
    created by your name
    created at 10-08-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('visite')->result();
    }
    /*
    function for update Visite.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('visite', $data);
        return true;
    }

    /**
     * situation de visite technique pour une voiture
     */
    public function visiteTech($numero)
    {
        $sql="SELECT max(datedebut)as dernierdate,TIMESTAMPDIFF(MONTH,datedebut,now())as duree,date(now()) as maintenant,
        DATE_ADD(datedebut, INTERVAL 5 MONTH)as datefin, ? as numero from visite where numero= ? ";
        $query=$this->db->query($sql,array($numero,$numero));
        return $query->result();
    }
    /*
    function for delete Visite.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('visite');
        return true;
    }
    /*
    function for change status of Visite.
    return activated of deactivated.
    created by your name
    created at 10-08-22.
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