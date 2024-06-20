<?php

class Chauffeur extends CI_Model {

    /*
    return all Chauffeurs.
    created by your name
    created at 10-08-22.
    */
    public function getAll($limit,$start) {
        $this->db->from('chauffeur');
		$this->db->limit($limit, $start);
		$query = $this->db->get(); 
		return $query->result();
    }
    public function getAllC() {
        return $this->db->get('chauffeur')->result();
    }

    public function get_count() {
        return $this->db->count_all('chauffeur');
    }

    /**
     * 
     */
    /*
    function for create Chauffeur.
    return Chauffeur inserted id.
    created by your name
    created at 10-08-22.
    */
    public function insert($data) {
        $this->db->insert('chauffeur', $data);
        return $this->db->insert_id();
    }
    /*
    return Chauffeur by id.
    created by your name
    created at 10-08-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('chauffeur')->result();
    }
    /*
    function for update Chauffeur.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('chauffeur', $data);
        return true;
    }
    /*
    function for delete Chauffeur.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('chauffeur');
        return true;
    }


}