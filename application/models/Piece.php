<?php

class Piece extends CI_Model {

    /*
    return all Pieces.
    created by your name
    created at 29-08-22.
    */
    public function getAll($limit, $start) {
        $this->db->from('piece');
		$this->db->limit($limit, $start);
		$query = $this->db->get(); 
		return $query->result();
    }


    public function getAllC() {
        return $this->db->get('piece')->result();
    }

    public function get_count() {
        return $this->db->count_all('piece');
    }
    /*
    function for create Piece.
    return Piece inserted id.
    created by your name
    created at 29-08-22.
    */
    public function insert($data) {
        $this->db->insert('piece', $data);
        return $this->db->insert_id();
    }
    /*
    return Piece by id.
    created by your name
    created at 29-08-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('piece')->result();
    }
    /*
    function for update Piece.
    return true.
    created by your name
    created at 29-08-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('piece', $data);
        return true;
    }
    /*
    function for delete Piece.
    return true.
    created by your name
    created at 29-08-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('piece');
        return true;
    }

}