<?php

class Location extends CI_Model {

    /*
    return all Locations.
    created by your name
    created at 10-08-22.
    */
    public function getAll() {
        return $this->db->get('location')->result();
    }
    /*
    function for create Location.
    return Location inserted id.
    created by your name
    created at 10-08-22.
    */
    public function insert($data) {
        $this->db->insert('location', $data);
        return $this->db->insert_id();
    }
    /*
    return Location by id.
    created by your name
    created at 10-08-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('location')->result();
    }
    /*
    function for update Location.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('location', $data);
        return true;
    }
    /*
    function for delete Location.
    return true.
    created by your name
    created at 10-08-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('location');
        return true;
    }

}