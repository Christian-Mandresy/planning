<?php


class VehiculeController extends CI_Controller {

    public $index;
    public function __construct() {
        parent::__construct();
        $this->load->model('Vehicule');
        $this->load->model('Location');
        $this->load->model('Profilentretien');
        $this->load->model('Profilpiece');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');

        $user=$this->session->utilisateur;
        if(empty($user))
        {
            redirect('form-login');
        }
        else
        {
            if($user['idrole']==1)
            {
                $this->index = 'indexentretien';
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
    /*
    function for manage Vehicule.
    return all Vehicules.
    created by your name
    created at 09-08-22.
	santosh salve
    */
    public function manageVehicule() { 
        $data['page'] = 'manage-vehicule';
        $data['vehicules'] = $this->Vehicule->getAllEntreprise();
        $data['locations'] = $this->Location->getAll();
        $this->load->view ($this->index, $data);
    }

    /*
    function for  add Vehicule get
    created by your name
    created at 09-08-22.
    */
    public function addVehicule() {
        $data['page'] = 'add-vehicule';
        $data['entretiens']=$this->Profilentretien->getAll();
        $this->load->view($this->index, $data);
    }
    /*
    function for add Vehicule post
    created by your name
    created at 09-08-22.
    */
    public function addVehiculePost() {
        $data['numero'] = $this->input->post('numero');
        $data['place'] = $this->input->post('place');
        $data['identretien'] = $this->input->post('identretien');
        if(empty($this->input->post('identretien')))
        {
            $data['identretien']=null;
        }
    
        $this->Vehicule->insert($data);
        $this->session->set_flashdata('success', 'Vehicule added Successfully');
        redirect('manage-vehicule');
    }

    /*
        assignement entretien
    */
    public function assignentretien()
    {
        $data['page'] = 'assign-entretien';
        $data['vehicules'] = $this->Vehicule->getVehiculeSansEntretien();
        $data['entretiens'] = $this->Location->getAll();
        $this->load->view ($this->index, $data);
    }
    /*
       end assignement entretien
    */



    /*
    function for edit Vehicule get
    returns  Vehicule by id.
    created by your name
    created at 09-08-22.
    */
    public function editVehicule($vehicule_id) {
        $data['vehicule_id'] = $vehicule_id;
        $data['vehicule'] = $this->Vehicule->getDataById($vehicule_id);
        $data['entretiens']=$this->Profilentretien->getAll();
        $data['page'] = 'edit-vehicule';
        $this->load->view($this->index, $data);
    }
    /*
    function for edit Vehicule post
    created by your name
    created at 09-08-22.
    */
    public function editVehiculePost() {
        $vehicule_id = $this->input->post('vehicule_id');
        $vehicule = $this->Vehicule->getDataById($vehicule_id);
        $data['numero'] = $this->input->post('numero');
        $data['place'] = $this->input->post('place');
        $data['identretien']= $this->input->post('identretien');
        if(empty($data['identretien']))
        {
            $data['identretien']=null;
        }
        $edit = $this->Vehicule->update($vehicule_id,$data);
        if($vehicule[0]->idprestataire == null)
        {
            if ($edit) {
                $this->session->set_flashdata('success', 'Vehicule Updated');
                redirect('manage-vehicule');
            }
        }
        else
        {
            if ($edit) {
                $this->session->set_flashdata('success', 'Vehicule Updated');
                redirect('edit-prestataire/'.$vehicule[0]->idprestataire);
            }
        }
        
        
    }
    /*
    function for view Vehicule get
    created by your name
    created at 09-08-22.
    */
    public function viewVehicule($vehicule_id) {
        $data['vehicule_id'] = $vehicule_id;
        $data['vehicule'] = $this->Vehicule->getDataById($vehicule_id);
        $this->load->view('vehicule/view-vehicule', $data);
    }
    /*
    function for delete Vehicule    created by your name
    created at 09-08-22.
    */
    public function deleteVehicule($vehicule_id) {
        $delete = $this->Vehicule->delete($vehicule_id);
        $this->session->set_flashdata('success', 'vehicule deleted');
        redirect('manage-vehicule');
    }
    /*
    function for activation and deactivation of Vehicule.
    created by your name
    created at 09-08-22.
    */
    public function changeStatusVehicule($vehicule_id) {
        $edit = $this->Vehicule->changeStatus($vehicule_id);
        $this->session->set_flashdata('success', 'vehicule'.$edit.' Successfully');
        redirect('manage-vehicule');
    }

    /**
     * 
     * formulaire pour assigner une entretien pour une voiture
     * 
     */

     public function formentretienpiece($voiture)
     {
        $data['voiture']=$voiture;
        $data['entretiens']=$this->Profilentretien->getAll();
       	if(empty($data['entretiens']))
        {
          $data['profilpieces'] = null;
        }
        else
        {
			$data['profilpieces'] = $this->Profilpiece->getByEntretien($data['entretiens'][0]->id);
        }
        $data['page']='assign-vehicule-entretien';
        $this->load->view($this->index,$data);
     }

     public function ajoutentretienvoiture()
     {
        $data['identretien']=$this->input->post('identretien');
        $this->Vehicule->update($this->input->post('numero'),$data);
        redirect('entretien-piece');
     }
    
}