<?php

require('RoleCircuitController.php');
class ChauffeurController extends RoleCircuitController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Chauffeur');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library("pagination");
    }
    /*
    function for manage Chauffeur.
    return all Chauffeurs.
    created by your name
    created at 10-08-22.
	santosh salve
    */
    public function manageChauffeur() {
        $config = array();
        $config["base_url"] = base_url() . "manage-chauffeur";
        $config["total_rows"] = $this->Chauffeur->get_count();
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

        $data['chauffeurs'] = $this->Chauffeur->getAll($config["per_page"], $page);
        $data['page'] = 'manage-chauffeur';
        $this->load->view($this->index, $data);
    }
    /*
    function for  add Chauffeur get
    created by your name
    created at 10-08-22.
    */
    public function addChauffeur() {
        $data['page']='add-chauffeur';
        $this->load->view($this->index,$data);
    }
    /*
    function for add Chauffeur post
    created by your name
    created at 10-08-22.
    */
    public function addChauffeurPost() {
        $data['nom'] = $this->input->post('nom');
        $data['prenom'] = $this->input->post('prenom');
        $data['contact'] = $this->input->post('contact');
        $this->Chauffeur->insert($data);
        $this->session->set_flashdata('success', 'Chauffeur added Successfully');
        redirect('manage-chauffeur');
    }
    /*
    function for edit Chauffeur get
    returns  Chauffeur by id.
    created by your name
    created at 10-08-22.
    */
    public function editChauffeur($chauffeur_id) {
        $data['chauffeur_id'] = $chauffeur_id;
        $data['chauffeur'] = $this->Chauffeur->getDataById($chauffeur_id);
        $data['page']='edit-chauffeur';
        $this->load->view($this->index, $data);
    }
    /*
    function for edit Chauffeur post
    created by your name
    created at 10-08-22.
    */
    public function editChauffeurPost() {
        $chauffeur_id = $this->input->post('chauffeur_id');
        $chauffeur = $this->Chauffeur->getDataById($chauffeur_id);
        $data['nom'] = $this->input->post('nom');
        $data['prenom'] = $this->input->post('prenom');
        $data['contact'] = $this->input->post('contact');
    $edit = $this->Chauffeur->update($chauffeur_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Chauffeur Updated');
            redirect('manage-chauffeur');
        }
    }
    /*
    function for view Chauffeur get
    created by your name
    created at 10-08-22.
    */
    public function viewChauffeur($chauffeur_id) {
        $data['chauffeur_id'] = $chauffeur_id;
        $data['chauffeur'] = $this->Chauffeur->getDataById($chauffeur_id);
        $this->load->view('chauffeur/view-chauffeur', $data);
    }
    /*
    function for delete Chauffeur    created by your name
    created at 10-08-22.
    */
    public function deleteChauffeur($chauffeur_id) {
        $delete = $this->Chauffeur->delete($chauffeur_id);
        $this->session->set_flashdata('success', 'chauffeur deleted');
        redirect('manage-chauffeur');
    }
    /*
    function for activation and deactivation of Chauffeur.
    created by your name
    created at 10-08-22.
    */
    public function changeStatusChauffeur($chauffeur_id) {
        $edit = $this->Chauffeur->changeStatus($chauffeur_id);
        $this->session->set_flashdata('success', 'chauffeur '.$edit.' Successfully');
        redirect('manage-chauffeur');
    }
    
}