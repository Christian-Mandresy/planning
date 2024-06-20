<?php

require('RoleEntretienController.php');
class EntretienController extends RoleEntretienController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Entretien');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Vehicule');
        $this->load->library("pagination");
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
    function for manage Entretien.
    return all Entretiens.
    created by your name
    created at 10-08-22.
	santosh salve
    */
    public function manageEntretien() {

        $config = array();
        $config["base_url"] = base_url() . "manage-entretien";
        $config["total_rows"] = $this->Entretien->get_count();
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

        $data['entretiens'] = $this->Entretien->getAll($config["per_page"], $page);
        $data['page']='manage-entretien';
        $this->load->view($this->index, $data);
    }
    /*
    function for  add Entretien get
    created by your name
    created at 10-08-22.
    */
    public function addEntretien() {
        $this->load->library('form_validation');
        $data['vehicules'] = $this->Vehicule->getAllEntreprise();
        $data['page']='add-entretien';
        $this->load->view($this->index,$data);
    }
    /*
    function for add Entretien post
    created by your name
    created at 10-08-22.
    */
    public function addEntretienPost() {
        $this->load->library('form_validation');
        $validation = array(
            array('field' => 'datedebut', 'label' => 'StartDate', 'rules' => 'required|callback_compareDate'),
            array('field' => 'datefin', 'label' => 'endDate', 'rules' => 'required|callback_compareDate'),
        );

        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('required', '%s is required.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page']='add-entretien';
            $data['vehicules'] = $this->Vehicule->getAll();
            $this->load->view($this->index,$data);
        }
        else
        {
            $data['numero'] = $this->input->post('numero');
            $data['datedebut'] = $this->input->post('datedebut');
            $data['datefin'] = $this->input->post('datefin');
            $data['description'] = $this->input->post('description');
            $this->Entretien->insert($data);
            $this->session->set_flashdata('success', 'Entretien added Successfully');
            redirect('manage-entretien');
        }
        
    }
    /*
    function for edit Entretien get
    returns  Entretien by id.
    created by your name
    created at 10-08-22.
    */
    public function editEntretien($entretien_id) {
        $this->load->library('form_validation');
        $data['entretien_id'] = $entretien_id;
        $data['vehicules'] = $this->Vehicule->getAllEntreprise();
        $data['entretien'] = $this->Entretien->getDataById($entretien_id);
        $data['page']='edit-entretien';
        $this->load->view($this->index, $data);
    }
    /*
    function for edit Entretien post
    created by your name
    created at 10-08-22.
    */
    public function editEntretienPost() {

        $this->load->library('form_validation');
        $validation = array(
            array('field' => 'datedebut', 'label' => 'StartDate', 'rules' => 'required|callback_compareDate'),
            array('field' => 'datefin', 'label' => 'endDate', 'rules' => 'required|callback_compareDate'),
        );

        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('required', '%s is required.');
        $entretien_id = $this->input->post('entretien_id');
        $entretien = $this->Entretien->getDataById($entretien_id);
        if ($this->form_validation->run() == FALSE)
        {
            $data['vehicules'] = $this->Vehicule->getAll();
            $data['page']='edit-entretien';
            $data['entretien']=$entretien;
            $this->load->view($this->index,$data);
        }
        else
        {
            
            $data['numero'] = $this->input->post('numero');
            $data['datedebut'] = $this->input->post('datedebut');
            $data['datefin'] = $this->input->post('datefin');
            $data['description'] = $this->input->post('description');
            $edit = $this->Entretien->update($entretien_id,$data);
            if ($edit) {
                $this->session->set_flashdata('success', 'Entretien Updated');
                redirect('manage-entretien');
            }
        }
        
    }
    /*
    function for view Entretien get
    created by your name
    created at 10-08-22.
    */
    public function viewEntretien($entretien_id) {
        $data['entretien_id'] = $entretien_id;
        $data['entretien'] = $this->Entretien->getDataById($entretien_id);
        $this->load->view('entretien/view-entretien', $data);
    }
    /*
    function for delete Entretien    created by your name
    created at 10-08-22.
    */
    public function deleteEntretien($entretien_id) {
        $delete = $this->Entretien->delete($entretien_id);
        $this->session->set_flashdata('success', 'entretien deleted');
        redirect('manage-entretien');
    }

    
}