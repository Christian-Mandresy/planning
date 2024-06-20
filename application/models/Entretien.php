<?php

class Entretien extends CI_Model {

    /*
    return all Entretiens.
    created by your name
    created at 10-08-22.
    */
    public function getAll($limit,$start) {
        $this->db->from('entretien');
		$this->db->order_by("datedebut", "desc");
		$this->db->limit($limit, $start);
		$query = $this->db->get(); 
		return $query->result();
    }

    public function get_count() {
        return $this->db->count_all('entretien');
    }
    /*
    function for create Entretien.
    return Entretien inserted id.
    created by your name
    created at 10-08-22.
    */
    public function insert($data) {
        $this->db->insert('entretien', $data);
        return $this->db->insert_id();
    }
    /*
    return Entretien by id.
    created by your name
    created at 10-08-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('entretien')->result();
    }
    /*
    function for update Entretien.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('entretien', $data);
        return true;
    }
    /*
    function for delete Entretien.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('entretien');
        return true;
    }


}