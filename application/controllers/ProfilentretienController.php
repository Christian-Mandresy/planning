<?php

require('RoleEntretienController.php');
class ProfilentretienController extends RoleEntretienController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Profilentretien');
        $this->load->model('Piece');
        $this->load->model('Profilpiece');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }
    /*
    function for manage Profilentretien.
    return all Profilentretiens.
    created by your name
    created at 26-08-22.
	santosh salve
    */
    public function manageProfilentretien() { 
        $data['profilentretiens'] = $this->Profilentretien->getAll();
        $data['page']= 'manage-profilentretien';
        $this->load->view($this->index, $data);
    }
    /*
    function for  add Profilentretien get
    created by your name
    created at 26-08-22.
    */
    public function addProfilentretien() {
        $data['page']='add-profilentretien';
        $data['pieces']=$this->Piece->getAllC();
        $this->load->view($this->index,$data);
    }

    public function editentretienpiece()
    {
        $config = array(
            array(
                    'field' => 'kilometrage',
                    'label' => 'kilometrage',
                    'rules' => 'required|greater_than[0]',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                            'greater_than' => 'kilometrage supérieur à 0',
                    ),
            )
        );

        $data['identretien']=$this->input->post('profilpiece_id');
        $data['idpiece']=$this->input->post('idpiece');
        $data['kilometrage']=$this->input->post('kilometrage');
        $this->Profilentretien->modifyPiece($data);
        redirect('edit-profilentretien/'.$data['identretien']);
    }
    /*
    function for add Profilentretien post
    created by your name
    created at 26-08-22.
    */
    public function addProfilentretienPost() {
        $data['nom'] = $this->input->post('nom');
        $data['description'] = $this->input->post('description');
        $config = array(
            array(
                    'field' => 'kilometrage',
                    'label' => 'kilometrage',
                    'rules' => 'required|greater_than[0]',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                            'greater_than' => 'kilometrage supérieur à 0',
                    ),
            )
        );

        $indice=1;

        while(!empty($this->input->post('kilometrage'.$indice)))
        {
            $rule2=array(
                'field' => 'kilometrage'.$indice,
                'label' => 'kilometrage'.$indice,
                'rules' => 'required|greater_than[0]',
                'errors' => array(
                        'required' => 'vous devez fournir une %s.',
                        'greater_than' => 'kilometrage supérieur à 0',
                ),
            );
            array_push($config,$rule2);
            $indice++;
        }

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', 'verifier le kilometrage entrée');
            redirect('add-profilentretien');
        }
        else
        {
            $data['nom'] = $this->input->post('nom');
            $data['description'] = $this->input->post('description');
            $idpiece=$this->input->post('idpiece');
            $kilometrage=$this->input->post('kilometrage');
            $piece=array(
                array(
                    'idpiece' => $idpiece,
                    'kilometrage' => $kilometrage,
                    'identretien' => 0
                ),
            );
        
            for($i=1;$i<$indice;$i++)
            {
                $array=array(
                    'idpiece' => $this->input->post('idpiece'.$i),
                    'kilometrage'  => $this->input->post('kilometrage'.$i),
                    'identretien' => 0
                );
                array_push($piece,$array);
            }

            $this->Profilentretien->insertWithPiece($data,$piece);
            $this->session->set_flashdata('success', 'profil entretien ajouté avec success');
            redirect('manage-profilentretien');
        }
    }

    public function addentretienpiece($identretien)
    {
        $data['page']='add-entretienpiece';
        $data['pieces']=$this->Piece->getAllC();
        $data['identretien']=$identretien;
        $this->load->view($this->index,$data);
    }

    public function addentretienpiecepost()
    {
        $config = array(
            array(
                    'field' => 'kilometrage',
                    'label' => 'kilometrage',
                    'rules' => 'required|greater_than[0]',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                            'greater_than' => 'kilometrage supérieur à 0',
                    ),
                )
        );

        $indice=1;

        while(!empty($this->input->post('kilometrage'.$indice)))
        {
            $rule2=array(
                'field' => 'kilometrage'.$indice,
                'label' => 'kilometrage'.$indice,
                'rules' => 'required|greater_than[0]',
                'errors' => array(
                        'required' => 'vous devez fournir une %s.',
                        'greater_than' => 'kilometrage supérieur à 0',
                ),
            );
            array_push($config,$rule2);
            $indice++;
        }

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', 'verifier le kilometrage entrée');
            redirect('add-entretienpiece');
        }
        else
        {
            $idprofil=$this->input->post('profilentretien_id');
            $idpiece=$this->input->post('idpiece');
            $kilometrage=$this->input->post('kilometrage');
            $piece=array(
                array(
                    'idpiece' => $idpiece,
                    'kilometrage' => $kilometrage,
                    'identretien' => $idprofil
                ),
            );
        
            for($i=1;$i<$indice;$i++)
            {
                $array=array(
                    'idpiece' => $this->input->post('idpiece'.$i),
                    'kilometrage'  => $this->input->post('kilometrage'.$i),
                    'identretien' => $idprofil
                );
                array_push($piece,$array);
            }

            try
            {
                $this->Profilentretien->insertPiece($piece);
            }
            catch(Exception $e)
            {
                show_error( "veuiller verifier si cette piece n'existe pas déja et modifier la" , 505 , $heading = 'Une erreur a été rencontrée' );
                redirect('manage-profilentretien');
            }
            $this->session->set_flashdata('success', 'profil entretien ajouté avec success');
            redirect('manage-profilentretien');
        }
    }

    /*
    function for edit Profilentretien get
    returns  Profilentretien by id.
    created by your name
    created at 26-08-22.
    */
    public function editProfilentretien($profilentretien_id) {
        $data['profilentretien_id'] = $profilentretien_id;
        $data['profilentretien'] = $this->Profilentretien->getDataById($profilentretien_id);
        $data['page']='edit-profilentretien';
        $data['profilpieces']=$this->Profilpiece->getByEntretien($profilentretien_id);
        $data['pieces']=$this->Piece->getAllC();
        $this->load->view($this->index, $data);
    }
    /*
    function for edit Profilentretien post
    created by your name
    created at 26-08-22.
    */
    public function editProfilentretienPost() {
        $profilentretien_id = $this->input->post('profilentretien_id');
        $profilentretien = $this->Profilentretien->getDataById($profilentretien_id);
        $data['nom'] = $this->input->post('nom');
        $data['description'] = $this->input->post('description');
        $edit = $this->Profilentretien->update($profilentretien_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Profilentretien Updated');
            redirect('manage-profilentretien');
        }
    }
    /*
    function for view Profilentretien get
    created by your name
    created at 26-08-22.
    */
    public function viewProfilentretien($profilentretien_id) {
        $data['profilentretien_id'] = $profilentretien_id;
        $data['profilentretien'] = $this->Profilentretien->getDataById($profilentretien_id);
        $this->load->view('profilentretien/view-profilentretien', $data);
    }
    /*
    function for delete Profilentretien created by your name
    created at 26-08-22.
    */
    public function deleteProfilentretien($profilentretien_id) {
        $delete = $this->Profilentretien->delete($profilentretien_id);
        $this->session->set_flashdata('success', 'profilentretien deleted');
        redirect('manage-profilentretien');
    }
    /*
    function for activation and deactivation of Profilentretien.
    created by your name
    created at 26-08-22.
    */
    public function changeStatusProfilentretien($profilentretien_id) {
        $edit = $this->Profilentretien->changeStatus($profilentretien_id);
        $this->session->set_flashdata('success', 'profilentretien '.$edit.' Successfully');
        redirect('manage-profilentretien');
    }

    /**
     * ajax pour afficher la liste des pièces d' une voiture
     */
    public function listepieceProfil($idvoiture)
    {
        $pieces=$this->Profilpiece->getPiecesByVoiture($idvoiture);
        echo json_encode($pieces);
    }

    /**
     * ajax pour afficher la liste des pièces d' une entretien
     */
    public function getPieceByEntretien($identretien)
    {
        $pieces=$this->Profilpiece->getPiecesByEntretien($identretien);
        echo json_encode($pieces);
    }


    //ajax liste des pièces et leur kilometrage
    public function ajaxprofilentretienpiece()
    {
        

    }
    //end ajax
    
}