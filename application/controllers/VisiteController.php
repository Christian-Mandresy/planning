<?php

require('RoleEntretienController.php');
class VisiteController extends RoleEntretienController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Visite');
        $this->load->model('Vehicule');
        $this->load->library('session');
        $this->load->library("pagination");
        $this->load->helper('url');
    }

    function compareDate() {
        $startDate = strtotime($_POST['datedebut']);
        $endDate = strtotime($_POST['datefin']);
      
        if ($endDate >= $startDate)
          return True;
        else {
          $this->form_validation->set_message('compareDate', 'la date de debut devrais être antérieur à la date de fin');
          return False;
        }
    }
    /*
    function for manage Visite.
    return all Visites.
    created by your name
    created at 10-08-22.
	santosh salve
    */
    public function manageVisite() {
        $config = array();
        $config["base_url"] = base_url() . "manage-visite";
        $config["total_rows"] = $this->Visite->get_count();
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

        $data['visites'] = $this->Visite->getAll($config["per_page"], $page);
        $data['page']='manage-visite';
        $this->load->view($this->index, $data);
    }
    /*
    function for  add Visite get
    created by your name
    created at 10-08-22.
    */
    public function addVisite() {
        $this->load->library('form_validation');
        $data['page']='add-visite';
        $data['vehicules'] = $this->Vehicule->getAllEntreprise();
        $this->load->view($this->index,$data);
    }
    /*
    function for add Visite post
    created by your name
    created at 10-08-22.
    */
    public function addVisitePost() {

        $this->load->library('form_validation');
        $validation = array(
            array('field' => 'datedebut', 'label' => 'StartDate', 'rules' => 'required|callback_compareDate'),
            array('field' => 'datefin', 'label' => 'endDate', 'rules' => 'required|callback_compareDate'),
        );

        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('required', '%s is required.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page']='add-visite';
            $data['vehicules'] = $this->Vehicule->getAll();
            $this->load->view($this->index,$data);
        }
        else
        {
            $data['numero'] = $this->input->post('numero');
            $data['datedebut'] = $this->input->post('datedebut');
            $data['datefin'] = $this->input->post('datefin');
            $this->Visite->insert($data);
            $this->session->set_flashdata('success', 'Visite added Successfully');
            redirect('manage-visite');
        }
        
    }
    /*
    function for edit Visite get
    returns  Visite by id.
    created by your name
    created at 10-08-22.
    */
    public function editVisite($visite_id) {
        $this->load->library('form_validation');
        $data['visite_id'] = $visite_id;
        $data['visite'] = $this->Visite->getDataById($visite_id);
        $data['vehicules'] = $this->Vehicule->getAllEntreprise();
        $data['page']='edit-visit';
        $this->load->view($this->index, $data);
    }
    /*
    function for edit Visite post
    created by your name
    created at 10-08-22.
    */
    public function editVisitePost() {
        $this->load->library('form_validation');
        $validation = array(
            array('field' => 'datedebut', 'label' => 'StartDate', 'rules' => 'required|callback_compareDate'),
            array('field' => 'datefin', 'label' => 'endDate', 'rules' => 'required|callback_compareDate'),
        );

        

        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('required', '%s is required.');
        $visite_id = $this->input->post('visite_id');
        $visite = $this->Visite->getDataById($visite_id);
        if ($this->form_validation->run() == FALSE)
        {
            $data['vehicules'] = $this->Vehicule->getAll();
            $data['page']='edit-visit';
            $data['visite']=$visite;
            $this->load->view($this->index,$data);
        }
        else
        {
            $data['numero'] = $this->input->post('numero');
            $data['datedebut'] = $this->input->post('datedebut');
            $data['datefin'] = $this->input->post('datefin');
            $edit = $this->Visite->update($visite_id,$data);
            if ($edit) {
                $this->session->set_flashdata('success', 'Visite modifié');
                redirect('manage-visite');
            }
        }

        
    }
    /*
    function for view Visite get
    created by your name
    created at 10-08-22.
    */
    public function viewVisite($visite_id) {
        $data['visite_id'] = $visite_id;
        $data['visite'] = $this->Visite->getDataById($visite_id);
        $this->load->view('visite/view-visite', $data);
    }
    /*
    function for delete Visite    created by your name
    created at 10-08-22.
    */
    public function deleteVisite($visite_id) {
        $delete = $this->Visite->delete($visite_id);
        $this->session->set_flashdata('success', 'visite deleted');
        redirect('manage-visite');
    }
    
}