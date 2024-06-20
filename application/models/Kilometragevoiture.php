<?php

class Kilometragevoiture extends CI_Model {

    /*
    return all Kilometragevoitures.
    created by your name
    created at 15-11-22.
    */
    public function getAll($limit,$start) {
        $this->db->from('kilometragevoiture');
		$this->db->order_by("daterendu", "desc");
		$this->db->limit($limit, $start);
		$query = $this->db->get(); 
		return $query->result();
    }

    public function get_count() {
        return $this->db->count_all('kilometragevoiture');
    }
    /*
    function for create Kilometragevoiture.
    return Kilometragevoiture inserted id.
    created by your name
    created at 15-11-22.
    */
    public function insert($data) {
        $this->db->insert('kilometragevoiture', $data);
        return $this->db->insert_id();
    }
    /*
    return Kilometragevoiture by id.
    created by your name
    created at 15-11-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('kilometragevoiture')->result();
    }
    /*
    function for update Kilometragevoiture.
    return true.
    created by your name
    created at 15-11-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('kilometragevoiture', $data);
        return true;
    }
    /*
    function for delete Kilometragevoiture.
    return true.
    created by your name
    created at 15-11-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('kilometragevoiture');
        return true;
    }
    /*
    function for change status of Kilometragevoiture.
    return activated of deactivated.
    created by your name
    created at 15-11-22.
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