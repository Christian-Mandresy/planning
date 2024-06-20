<?php

class RoleCircuitController extends CI_Controller {

    public $index;

    public function __construct() {
        parent::__construct();
        $this->load->model('Utilisateur');
        $this->load->library('session');
        $this->load->helper('url');

        $user=$this->session->utilisateur;
        if(empty($user))
        {
            redirect('form-login');
        }
        else
        {
            if($user['idrole']==1)
            {
                redirect('login');
            }
            elseif($user['idrole'] == 2)
            {
                $this->index = 'index';
            }
            elseif($user['idrole'] == 3)
            {
                $this->index = 'indexcircuit';
            }
        }
    }



}