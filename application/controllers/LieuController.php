<?php

require('RoleCircuitController.php');
class LieuController extends RoleCircuitController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Lieu');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library("pagination");
    }
    /*
    function for manage Lieu.
    return all Lieus.
    created by your name
    created at 24-10-22.
	santosh salve
    */
    public function manageLieu() {
        $config = array();
        $config["base_url"] = base_url() . "manage-lieu";
        $config["total_rows"] = $this->Lieu->get_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 2;

        $config['full_tag_open'] = '<ul class="pagination">';        
        $config['full_tag_close'] = '</ul>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['first_tag_close'] = '</span></li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['prev_tag_close'] = '</span></li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['next_tag_close'] = '</span></li>';        
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['last_tag_close'] = '</span></li>';        
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';        
        $config['num_tag_close'] = '</span></li>';
        
                          

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        $data["links"] = $this->pagination->create_links();
        $data['page']='manage-lieu';
        $data['lieus'] = $this->Lieu->getAll($config["per_page"], $page);
        $this->load->view($this->index, $data);
    }
    /*
    function for  add Lieu get
    created by your name
    created at 24-10-22.
    */
    public function addLieu() {
        $this->load->view('lieu/add-lieu');
    }
    /*
    function for add Lieu post
    created by your name
    created at 24-10-22.
    */
    public function addLieuPost() {
        $data['nom'] = $this->input->post('nom');
    $this->Lieu->insert($data);
        $this->session->set_flashdata('success', 'Lieu added Successfully');
        redirect('manage-lieu');
    }
    /*
    function for edit Lieu get
    returns  Lieu by id.
    created by your name
    created at 24-10-22.
    */
    public function editLieu($lieu_id) {
        $data['lieu_id'] = $lieu_id;
        $data['lieu'] = $this->Lieu->getDataById($lieu_id);
        $data['page'] ='edit-lieu';
        $this->load->view($this->index, $data);
    }
    /*
    function for edit Lieu post
    created by your name
    created at 24-10-22.
    */
    public function editLieuPost() {
        $lieu_id = $this->input->post('lieu_id');
        $lieu = $this->Lieu->getDataById($lieu_id);
        $data['nom'] = $this->input->post('nom');
    $edit = $this->Lieu->update($lieu_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Lieu Updated');
            redirect('manage-lieu');
        }
    }
    /*
    function for view Lieu get
    created by your name
    created at 24-10-22.
    */
    public function viewLieu($lieu_id) {
        $data['lieu_id'] = $lieu_id;
        $data['lieu'] = $this->Lieu->getDataById($lieu_id);
        $this->load->view('lieu/view-lieu', $data);
    }
    /*
    function for delete Lieu    created by your name
    created at 24-10-22.
    */
    public function deleteLieu($lieu_id) {
        $delete = $this->Lieu->delete($lieu_id);
        $this->session->set_flashdata('success', 'lieu deleted');
        redirect('manage-lieu');
    }
    /*
    function for activation and deactivation of Lieu.
    created by your name
    created at 24-10-22.
    */
    public function changeStatusLieu($lieu_id) {
        $edit = $this->Lieu->changeStatus($lieu_id);
        $this->session->set_flashdata('success', 'lieu '.$edit.' Successfully');
        redirect('manage-lieu');
    }
    
}