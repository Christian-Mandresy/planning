<?php

class utilisateur extends CI_Model {

    /*
    return all utilisateurs.
    created by your name
    created at 12-07-22.
    */
    public function getAll() {
        return $this->db->get('utilisateur')->result();
    }
    /*
    function for create utilisateur.
    return utilisateur inserted id.
    created by your name
    created at 12-07-22.
    */
    public function insert($data) {
        $this->db->trans_Start();
        $this->db->insert('utilisateur', $data);
        $id=$this->db->insert_id();
        $this->db->trans_Complete();
        return $id;
    }
    /*
    return utilisateur by id.
    created by your name
    created at 12-07-22.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('utilisateur')->result();
    }


    public function getDataByUsername($email,$mdp) {
        $this->db->where('username', $email);
        $this->db->where('mdp', md5($mdp));
        return $this->db->get('utilisateur')->result_array();
    }

    public function getDataByUser($email) {
        $this->db->where('username', $email);
        return $this->db->get('utilisateur')->result_array();
    }

    public function getRole($role)
    {
        $this->db->where('idrole', $role);
        return $this->db->get('roles')->result_array();
    }
    /*
    function for update utilisateur.
    return true.
    created by your name
    created at 12-07-22.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('utilisateur', $data);
        return true;
    }
    /*
    function for delete utilisateur.
    return true.
    created by your name
    created at 12-07-22.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('utilisateur');
        return true;
    }

}