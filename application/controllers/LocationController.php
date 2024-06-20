<?php


class LocationController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Location');
        $this->load->library('session');
        $this->load->helper('url');
    }

    function compareDate() {
        $startDate = strtotime($_POST['datedebut']);
        $endDate = strtotime($_POST['datefin']);
      
        if ($endDate >= $startDate)
          return True;
        else {
          $this->form_validation->set_message('compareDate', 'la date de location devrais être antérieur à la date de fin');
          return False;
        }
    }

  
    public function addLocationPost() {

        $this->load->library('form_validation');

        $validation = array(
            array('field' => 'datedebut', 'label' => 'StartDate', 'rules' => 'required|callback_compareDate'),
            array('field' => 'datefin', 'label' => 'endDate', 'rules' => 'required|callback_compareDate'),
        );

        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('required', '%s is required.');

        if ($this->form_validation->run() == FALSE)
        {
        
        }
        else
        {

        }

        if ($this->form_validation->run() == FALSE)
        {
            $data['page']='add-vehicule';
            $this->load->view('index',$data);
        }
        else
        {
            $data['numero'] = $this->input->post('numero');
            $data['datedebut'] = $this->input->post('datedebut');
            $data['datefin'] = $this->input->post('datefin');
            $data['proprietaire'] = $this->input->post('proprietaire');
            $this->Location->insert($data);
            $this->session->set_flashdata('success', 'Location added Successfully');
            redirect('manage-vehicule');
        }
        
    }
    /*
    function for edit Location get
    returns  Location by id.
    created by your name
    created at 10-08-22.
    */
    public function editLocation($location_id) {
        $this->load->library('form_validation');
        $data['location_id'] = $location_id;
        $data['location'] = $this->Location->getDataById($location_id);
        $data['page']='edit-location';
        $this->load->view('index', $data);
    }
    /*
    function for edit Location post
    created by your name
    created at 10-08-22.
    */
    public function editLocationPost() {
        $location_id = $this->input->post('location_id');
        $location = $this->Location->getDataById($location_id);

        $this->load->library('form_validation');
        $validation = array(
            array('field' => 'datedebut', 'label' => 'StartDate', 'rules' => 'required|callback_compareDate'),
            array('field' => 'datefin', 'label' => 'endDate', 'rules' => 'required|callback_compareDate'),
        );

        $this->form_validation->set_rules($validation);
        $this->form_validation->set_message('required', '%s is required.');

        if ($this->form_validation->run() == FALSE)
        {
            $data['page']='edit-location';
            $data['location']=$location;
            $this->load->view('index',$data);
        }
        else
        {
            
            $data['numero'] = $this->input->post('numero');
            $data['datedebut'] = $this->input->post('datedebut');
            $data['datefin'] = $this->input->post('datefin');
            $data['proprietaire'] = $this->input->post('proprietaire');
            $edit = $this->Location->update($location_id,$data);
            if ($edit) {
                $this->session->set_flashdata('success', 'Location Updated');
                redirect('manage-vehicule');
            } 
        }

        
    }
    /*
    function for delete Location    created by your name
    created at 10-08-22.
    */
    public function deleteLocation($location_id) {
        $delete = $this->Location->delete($location_id);
        $this->session->set_flashdata('success', 'location deleted');
        redirect('manage-location');
    }
    
}