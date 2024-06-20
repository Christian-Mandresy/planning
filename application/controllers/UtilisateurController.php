<?php


class UtilisateurController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Utilisateur');
        $this->load->model('Roles');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    
    public function manageUtilisateur() { 
        $data['utilisateurs'] = $this->Utilisateur->getAll();
        $data['page']= 'manage-utilisateur';
        $this->load->view('index', $data);
    }
  
    public function index()
    {
      $this->load->view('login');
    }
    
    public function addUtilisateur() {
        $data['page']='add-utilisateur';
        $data['roles'] = $this->Roles->getAll();
        $this->load->view('index',$data);
    }
   
    public function addUtilisateurPost() {
        $data['username'] = $this->input->post('username');
        $data['mdp'] = md5($this->input->post('mdp'));
        $data['idrole'] = $this->input->post('idrole');
        $this->Utilisateur->insert($data);
        $this->session->set_flashdata('success', 'Utilisateur added Successfully');
        redirect('manage-utilisateur');
    }
    
    public function editUtilisateur($utilisateur_id) {
        $data['roles'] = $this->Roles->getAll();
        $data['utilisateur_id'] = $utilisateur_id;
        $data['utilisateur'] = $this->Utilisateur->getDataById($utilisateur_id);
        $data['page']='edit-utilisateur';
        $this->load->view('index', $data);
    }
    
    public function editUtilisateurPost() {
        $utilisateur_id = $this->input->post('utilisateur_id');
        $utilisateur = $this->Utilisateur->getDataById($utilisateur_id);
        $data['username'] = $this->input->post('username');
        $data['mdp'] = md5($this->input->post('mdp'));
        $verif=$this->Utilisateur->getDataByUser($this->input->post('username'));
        if(!empty($verif) && strcasecmp($data['username'],$utilisateur[0]->username)!=0)
        {
            $this->session->set_flashdata('error', 'nom d\'utilisateur déja pris');
            redirect('manage-utilisateur');
        }
        else
        {
            $edit = $this->Utilisateur->update($utilisateur_id,$data);
            if ($edit) {
                $this->session->set_flashdata('success', 'Utilisateur Updated');
                redirect('manage-utilisateur');
            }
        }
        
    }
    
    public function viewUtilisateur($utilisateur_id) {
        $data['utilisateur_id'] = $utilisateur_id;
        $data['utilisateur'] = $this->Utilisateur->getDataById($utilisateur_id);
        $this->load->view('utilisateur/view-utilisateur', $data);
    }
   

    public function deleteUtilisateur($utilisateur_id) {
        $delete = $this->Utilisateur->delete($utilisateur_id);
        $this->session->set_flashdata('success', 'utilisateur deleted');
        redirect('manage-utilisateur');
    }
    
    
    public function changeStatusUtilisateur($utilisateur_id) {
        $edit = $this->Utilisateur->changeStatus($utilisateur_id);
        $this->session->set_flashdata('success', 'utilisateur '.$edit.' Successfully');
        redirect('manage-utilisateur');
    }

    public function formLogin()
    {
    	$this->load->view('login');
    }

    public function Login()
    {
        if(!empty($this->session->utilisateur))
        {
            $user=$this->session->utilisateur;
            if($user['idrole']==1)
            {
                redirect('manage-entretien');
            }
            elseif($user['idrole'] == 2)
            {
                redirect('manage-circuit');
            }
            elseif($user['idrole'] == 3)
            {
                redirect('manage-circuit');
            }
        }
        else
        {
            $email = $this->input->post('username');
            $mdp = $this->input->post('mdp');
            
            $user=$this->Utilisateur->getDataByUsername($email,$mdp);
            if(!empty($user))
            {
                $role_id=$user[0]['idrole'];
                $newdata = array(
                    'utilisateur'  => $user[0],
                );
                
                $this->session->set_userdata($newdata);
                if($role_id == 1)
                {
                    redirect('manage-entretien');
                }
                else
                {
                    redirect('manage-circuit');
                }
                
            }
            else
            {
                $this->session->set_flashdata('error', 'verifier votre utilisateur et votre mot de passe');
                $this->load->view('login');
            }
        }
    	
    }

    public function formRegister()
    {
        $this->load->view('inscription');
    }

    public function Register()
    {

        $this->form_validation->set_rules('nom', 'nom', 'required');
        $this->form_validation->set_rules('mdp', 'Password', 'required',
            array('required' => 'vous devez fournir un mot de passe.')
        );
        $this->form_validation->set_rules('email', 'Email', 'required',
            array('required' => 'vous devez fournir votre email.'));

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('inscription');
        }
        else
        {
            $data['nom'] = $this->input->post('nom');
            $data['username'] = $this->input->post('username');
            $data['mdp'] = sha1($this->input->post('mdp'));
            $id=$this->Utilisateur->insert($data);
            $user=$this->Utilisateur->getDataByUsername($data['email'],$data['mdp']);
            $newdata = array(
                'utilisateur'  => $user[0],
            );

            $this->session->set_userdata($newdata);
            $data['page']='ajoutDemande';
            $cli=$this->session->userdata('utilisateur');
            $port=$this->Portefeuille->getDataByIdutilisateur($cli['id']);
            if(!empty($port))
            {
                $data['solde']=$port[0]->solde;
            }
            else
            {
                $data['solde']=0;
            }
            $this->load->view('index',$data);
        }

    }

    function logout()
    {
        unset($_SESSION['utilisateur']);
        $this->load->helper('url');
        redirect('form-login','refresh');
    }

    
}