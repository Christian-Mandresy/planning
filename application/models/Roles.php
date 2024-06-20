<?php

class Roles extends CI_Model
{
    public function getAll() {
        return $this->db->get('roles')->result();
    }
}