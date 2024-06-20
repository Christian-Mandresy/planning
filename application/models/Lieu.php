<?php

class Lieu extends CI_Model {

    /*
    return all lieus.
    created by your name
    created at 10-08-22.
    */
    public function getAll($limit,$start) {
        $this->db->from('lieu');
		$this->db->limit($limit, $start);
		$query = $this->db->get(); 
		return $query->result();
    }

    public function getAllC() {
        return $this->db->get('lieu')->result();
    }

    public function get_count() {
        return $this->db->count_all('lieu');
    }
    /*
    function for create lieu.
    return lieu inserted id.
    created by your name
    created at 10-08-22.
    */
    public function insert($data) {
        $this->db->insert('lieu', $data);
        return $this->db->insert_id();
    }
    /*
    return lieu by id.
    created by your name
    created at 10-08-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('lieu')->result();
    }
    /*
    function for update lieu.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('lieu', $data);
        return true;
    }
    /*
    function for delete lieu.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('lieu');
        return true;
    }

}