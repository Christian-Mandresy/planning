<?php

require('RoleEntretienController.php');
class KilometrageVoitureController extends RoleEntretienController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Kilometragevoiture');
        $this->load->model('Vehicule');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library("pagination");
        $this->load->library('form_validation');
    }
    /*
    function for manage Kilometragevoiture.
    return all Kilometragevoitures.
    created by your name
    created at 15-11-22.
	santosh salve
    */
    public function manageKilometragevoiture() {
        $config = array();
        $config["base_url"] = base_url() . "manage-kilometragevoiture";
        $config["total_rows"] = $this->Kilometragevoiture->get_count();
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

        $data['kilometragevoitures'] = $this->Kilometragevoiture->getAll($config["per_page"], $page);
        $data['page']='manage-kilometragevoiture';
        $this->load->view($this->index,$data);
    }
    /*
    function for  add Kilometragevoiture get
    created by your name
    created at 15-11-22.
    */
    public function addKilometragevoiture() {
        $data['vehicules'] = $this->Vehicule->getAllEntreprise();
        $data['page']='add-kilometragevoiture';
        $this->load->view($this->index,$data);
    }
    /*
    function for add Kilometragevoiture post
    created by your name
    created at 15-11-22.
    */
    public function addKilometragevoiturePost() {
        $data['numero'] = $this->input->post('numero');
        $data['daterendu'] = date('Y-m-d');
        $data['kmavant'] = $this->input->post('kmavant');
        $data['kmapres'] = $this->input->post('kmapres');
        $this->Kilometragevoiture->insert($data);
        $this->session->set_flashdata('success', 'Kilometragevoiture added Successfully');
        redirect('manage-kilometragevoiture');
    }
    /*
    function for edit Kilometragevoiture get
    returns  Kilometragevoiture by id.
    created by your name
    created at 15-11-22.
    */
    public function editKilometragevoiture($kilometragevoiture_id) {
        $data['kilometragevoiture_id'] = $kilometragevoiture_id;
        $data['kilometragevoiture'] = $this->Kilometragevoiture->getDataById($kilometragevoiture_id);
        $data['vehicules'] = $this->Vehicule->getAllEntreprise();
        $data['page']='edit-kilometragevoiture';
        $this->load->view($this->index,$data);
    }
    /*
    function for edit Kilometragevoiture post
    created by your name
    created at 15-11-22.
    */
    public function editKilometragevoiturePost() {
        $kilometragevoiture_id = $this->input->post('kilometragevoiture_id');
        $kilometragevoiture = $this->Kilometragevoiture->getDataById($kilometragevoiture_id);
        $data['numero'] = $this->input->post('numero');
        $data['daterendu'] = $this->input->post('daterendu');
        $data['kmavant'] = $this->input->post('kmavant');
        $data['kmapres'] = $this->input->post('kmapres');
        $edit = $this->Kilometragevoiture->update($kilometragevoiture_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Kilometragevoiture Updated');
            redirect('manage-kilometragevoiture');
        }
    }
    /*
    function for view Kilometragevoiture get
    created by your name
    created at 15-11-22.
    */
    public function viewKilometragevoiture($kilometragevoiture_id) {
        $data['kilometragevoiture_id'] = $kilometragevoiture_id;
        $data['kilometragevoiture'] = $this->Kilometragevoiture->getDataById($kilometragevoiture_id);
        $this->load->view('kilometragevoiture/view-kilometragevoiture', $data);
    }
    /*
    function for delete Kilometragevoiture    created by your name
    created at 15-11-22.
    */
    public function deleteKilometragevoiture($kilometragevoiture_id) {
        $delete = $this->Kilometragevoiture->delete($kilometragevoiture_id);
        $this->session->set_flashdata('success', 'kilometragevoiture deleted');
        redirect('manage-kilometragevoiture');
    }
    /*
    function for activation and deactivation of Kilometragevoiture.
    created by your name
    created at 15-11-22.
    */
    public function changeStatusKilometragevoiture($kilometragevoiture_id) {
        $edit = $this->Kilometragevoiture->changeStatus($kilometragevoiture_id);
        $this->session->set_flashdata('success', 'kilometragevoiture '.$edit.' Successfully');
        redirect('manage-kilometragevoiture');
    }
    
}