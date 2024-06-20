<?php

require('RoleEntretienController.php');
class VehiculePieceController extends RoleEntretienController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Profilpiece');
        $this->load->model('Vehicule');
        $this->load->model('Visite');
        $this->load->model('Vehiculepiece');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library("pagination");
    }

    


    public function entretienpiece()
    {
        
        $data['vehicules']=$this->Vehicule->getVehiculeAvecEntretien();
        if(empty($data['vehicules']))
        {
          $data['pieces']=null;
          $data['identretien']=null;
        }
        else
        {
          $data['pieces']=$this->Profilpiece->getPiecesByVoiture($data['vehicules'][0]->numero);
          $data['identretien']=$data['pieces'][0]->id;
        }
        $data['vehiculesS']=$this->Vehicule->getVehiculeSansEntretien();
        $data['page']='assign-entretien';
        $this->load->view($this->index,$data);
    }

    /*
    function for manage Vehiculepiece.
    return all Vehiculepieces.
    created by your name
    created at 07-09-22.
	santosh salve
    */
    public function manageVehiculepiece() { 

        $data['vehicules'] = $this->Vehicule->getVehiculeAvecEntretien();
        $data['page']='manage-vehiculepiece';
        $this->load->view ($this->index, $data);
    }

    /**
     * liste des derniers entretien par vehicule
     */
    public function listvehiculepiece($numero)
    {
        $config["base_url"] = base_url() . "list-vehiculepiece/".$numero;
        $config["total_rows"] = $this->Vehiculepiece->count($numero);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        /*
        start 
        add boostrap class and styles
        */
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
        /*
        end 
        add boostrap class and styles
        */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();

        $data['visites']=$this->Visite->visiteTech($numero);
        $data['vehiculepieces'] = $this->Vehiculepiece->getByNumero($numero,$config["per_page"],$page);
        $data['page']='list-vehiculepiece';
        $this->load->view($this->index, $data);
    }



    /*
    function for  add Vehiculepiece get
    created by your name
    created at 07-09-22.
    */
    public function addVehiculepiece() {
        $this->load->view('vehiculepiece/add-vehiculepiece');
    }
    /*
    function for add Vehiculepiece post
    created by your name
    created at 07-09-22.
    */
    public function addVehiculepiecePost() {
        $data['idpiece'] = $this->input->post('piece');
        $data['kilometrage'] = $this->input->post('kilometrage');
        $data['entretiendate'] = $this->input->post('entretiendate');
        $data['numero'] = $this->input->post('numero');
        $data['identretien'] = $this->input->post('identretien');
        $this->Vehiculepiece->insert($data);
        $this->session->set_flashdata('success', 'entretien piece ajouté avec success');
        redirect('manage-vehiculepiece');
    }
    /*
    function for edit Vehiculepiece get
    returns  Vehiculepiece by id.
    created by your name
    created at 07-09-22.
    */
    public function editVehiculepiece($vehiculepiece_id) {
        $data['vehicules']=$this->Vehicule->getVehiculeAvecEntretien();
        $data['pieces']=$this->Profilpiece->getPiecesByVoiture($data['vehicules'][0]->numero);
        $data['vehiculepiece_id'] = $vehiculepiece_id;
        $data['page']='edit-vehiculepiece';
        $data['vehiculepiece'] = $this->Vehiculepiece->getDataById($vehiculepiece_id);
        $data['identretien']=$data['vehiculepiece'][0]->identretien;
        $this->load->view($this->index, $data);
    }
    /*
    function for edit Vehiculepiece post
    created by your name
    created at 07-09-22.
    */
    public function editVehiculepiecePost() {
        $vehiculepiece_id = $this->input->post('vehiculepiece_id');
        $data['idpiece'] = $this->input->post('idpiece');
        $data['kilometrage'] = $this->input->post('kilometrage');
        $data['entretiendate'] = $this->input->post('entretiendate');
        $data['numero'] = $this->input->post('numero');
        $data['identretien'] = $this->input->post('identretien');
        $edit = $this->Vehiculepiece->update($vehiculepiece_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Vehiculepiece Updated');
            redirect('manage-vehiculepiece');
        }
    }
    /*
    function for view Vehiculepiece get
    created by your name
    created at 07-09-22.
    */
    public function viewVehiculepiece($vehiculepiece_id) {
        $data['vehiculepiece_id'] = $vehiculepiece_id;
        $data['vehiculepiece'] = $this->Vehiculepiece->getDataById($vehiculepiece_id);
        $this->load->view('vehiculepiece/view-vehiculepiece', $data);
    }
    /*
    function for delete Vehiculepiece    created by your name
    created at 07-09-22.
    */
    public function deleteVehiculepiece($vehiculepiece_id) {
        $delete = $this->Vehiculepiece->delete($vehiculepiece_id);
        $this->session->set_flashdata('success', 'vehiculepiece deleted');
        redirect('manage-vehiculepiece');
    }
    /*
    function for activation and deactivation of Vehiculepiece.
    created by your name
    created at 07-09-22.
    */
    public function changeStatusVehiculepiece($vehiculepiece_id) {
        $edit = $this->Vehiculepiece->changeStatus($vehiculepiece_id);
        $this->session->set_flashdata('success', 'vehiculepiece '.$edit.' Successfully');
        redirect('manage-vehiculepiece');
    }
}