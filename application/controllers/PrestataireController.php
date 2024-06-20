<?php

require('RoleCircuitController.php');
class PrestataireController extends RoleCircuitController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Prestataire');
        $this->load->model('Vehicule');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }
    /*
    function for manage Prestataire.
    return all Prestataires.
    created by your name
    created at 22-08-22.
	santosh salve
    */
    public function managePrestataire() {
        $data['page']='manage-prestataire';
        $data['prestataires'] = $this->Prestataire->getAll();
        $this->load->view($this->index, $data);
    }
    /*
    function for  add Prestataire get
    created by your name
    created at 22-08-22.
    */
    public function addPrestataire() {
        $data['page']='add-prestataire';
        $this->load->view($this->index,$data);
    }
    /*
    function for add Prestataire post
    created by your name
    created at 22-08-22.
    */
    public function addPrestatairePost() {
        $config = array(
            array(
                    'field' => 'numero',
                    'label' => 'numero',
                    'rules' => 'required|max_length[11]',
                    'errors' => array(
                        'required' => 'vous devez fournir un %s.',
                        'max_length' => 'longueur maximal 11',
                    ),
            ),
            array(
                    'field' => 'place',
                    'label' => 'place',
                    'rules' => 'required|greater_than[0]',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                            'greater_than' => 'nombre de place supérieur à 0',
                    ),
            )
        );

        $indice=1;

        while(!empty($this->input->post('numero'.$indice)))
        {
            $rule1=array(
                'field' => 'numero'.$indice,
                'label' => 'numero'.$indice,
                'rules' => 'required|max_length[11]',
                'errors' => array(
                    'required' => 'vous devez fournir un %s.',
                    'max_length' => 'longueur maximal 11',
                ),
            );
            $rule2=array(
                'field' => 'place'.$indice,
                'label' => 'place'.$indice,
                'rules' => 'required|greater_than[0]',
                'errors' => array(
                        'required' => 'vous devez fournir une %s.',
                        'greater_than' => 'nombre de place supérieur à 0',
                ),
            );
            array_push($config,$rule1,$rule2);
            $indice++;
        }

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
        {
            redirect('add-prestataire');
        }
        else
        {
            $data['nom'] = $this->input->post('nom');
            $data['contact'] = $this->input->post('contact');
            $numero=$this->input->post('numero');
            $place=$this->input->post('place');
            $vehicule=array(
                array(
                    'numero' => $numero,
                    'place' => $place,
                    'idprestataire' => 0
                ),
            );
        
            for($i=1;$i<$indice;$i++)
            {
                $array=array(
                    'numero' => $this->input->post('numero'.$i),
                    'place'  => $this->input->post('place'.$i),
                    'idprestataire' => 0
                );
                array_push($vehicule,$array);
            }

            $this->Prestataire->insertWithV($data,$vehicule);
            $this->session->set_flashdata('success', 'Prestataire added Successfully');
            redirect('manage-prestataire');
        }
    
    }
    /*
    function for edit Prestataire get
    returns  Prestataire by id.
    created by your name
    created at 22-08-22.
    */
    public function editPrestataire($prestataire_id) {
        $data['prestataire_id'] = $prestataire_id;
        $data['prestataire'] = $this->Prestataire->getDataById($prestataire_id);
        $data['vehicules'] = $this->Vehicule->getDataByPrestataire($prestataire_id);
        $data['page'] = 'edit-prestataire';
        $this->load->view($this->index, $data);
    }

    public function ajoutVehicule($prestataire_id)
    {
        $data['prestataire_id'] = $prestataire_id;
        $data['page']='add-vehicule-prestataire';
        $this->load->view($this->index, $data);
    }

    public function addVehiculePrestatairePost()
    {
        $indice=1;
        $numero=$this->input->post('numero');
        $place=$this->input->post('place');
        $idprest=$this->input->post('prestataire_id');
        $vehicule=array(
            array(
                'numero' => $numero,
                'place' => $place,
                'idprestataire' => $idprest
            ),
        );

        while(!empty($this->input->post('numero'.$indice)))
        {
            $array=array(
                'numero' => $this->input->post('numero'.$indice),
                'place'  => $this->input->post('place'.$indice),
                'idprestataire' => $idprest
            );
            array_push($vehicule,$array);
            $indice++;
        }
        
        $this->Prestataire->insertV($vehicule);
        $this->session->set_flashdata('success', 'voiture ajouter avec succes');
        redirect('edit-prestataire/'.$idprest);
    }

    /*
    function for edit Prestataire post
    created by your name
    created at 22-08-22.
    */
    public function editPrestatairePost() {
        $prestataire_id = $this->input->post('prestataire_id');
        $prestataire = $this->Prestataire->getDataById($prestataire_id);
        $data['nom'] = $this->input->post('nom');
        $data['contact'] = $this->input->post('contact');
    $edit = $this->Prestataire->update($prestataire_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Prestataire Updated');
            redirect('manage-prestataire');
        }
    }
    /*
    function for view Prestataire get
    created by your name
    created at 22-08-22.
    */
    public function viewPrestataire($prestataire_id) {
        $data['prestataire_id'] = $prestataire_id;
        $data['prestataire'] = $this->Prestataire->getDataById($prestataire_id);
        $this->load->view('prestataire/view-prestataire', $data);
    }
    /*
    function for delete Prestataire    created by your name
    created at 22-08-22.
    */
    public function deletePrestataire($prestataire_id) {
        $delete = $this->Prestataire->delete($prestataire_id);
        $this->session->set_flashdata('success', 'prestataire deleted');
        redirect('manage-prestataire');
    }
    /*
    function for activation and deactivation of Prestataire.
    created by your name
    created at 22-08-22.
    */
    public function changeStatusPrestataire($prestataire_id) {
        $edit = $this->Prestataire->changeStatus($prestataire_id);
        $this->session->set_flashdata('success', 'prestataire '.$edit.' Successfully');
        redirect('manage-prestataire');
    }
    
}