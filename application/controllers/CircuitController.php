<?php

require('RoleCircuitController.php');
class CircuitController extends RoleCircuitController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Circuit');
        $this->load->model('Vehicule');
        $this->load->model('Chauffeur');
        $this->load->model('Lieu');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->library("pagination");
    }


    
    function compareDate($str) {
        
        $startDate = strtotime($_POST['datedebut']);
        $endDate = strtotime($str);

        if ($endDate >= $startDate)
          return True;
        else {
          $this->form_validation->set_message('compareDate', 'la date de debut devrais être antérieur à la date de fin');
          return False;
        }
    }

    /**
     * 
     * comparer si la date est antérieur  à la date du premier trajet
     */
    function compareDaty($str,$id) {
        $startDate = "";
        if($id==1)
        {
            $startDate = strtotime($_POST['datedebut']);
        }
        else
        {
            $startDate = strtotime($_POST['datefin'.($id-1)]);
        }
        
        $endDate = strtotime($str);

        if ($endDate >= $startDate)
          return True;
        else {
          $this->form_validation->set_message('compareDaty', 'la date de debut devrais être antérieur à la date de fin');
          return False;
        }
    }

    /*
    function for manage Circuit.
    return all Circuits.
    created by your name
    created at 13-09-22.
	santosh salve
    */
    public function manageCircuit() {
        $config = array();
        $config["base_url"] = base_url() . "manage-circuit";
        $config["total_rows"] = $this->Circuit->get_count();
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

        $data['circuits'] = $this->Circuit->getAll($config["per_page"], $page);

        $data['page']='manage-circuit';
        $this->load->view($this->index, $data);
    }
    /*
    function for  add Circuit get
    created by your name
    created at 13-09-22.
    */
    public function addCircuit() {
        $data['page']='add-circuit';
        $data['lieus']=$this->Lieu->getAllC();
        $this->load->view($this->index,$data);
    }
    /*
    function for add Circuit post
    created by your name
    created at 13-09-22.
    */
    public function addCircuitPost() {

        $config = array(
            array(
                    'field' => 'place',
                    'label' => 'place',
                    'rules' => 'required|is_natural_no_zero',
                    'errors' => array(
                        'required' => 'vous devez fournir un %s.',
                        'is_natural_no_zero' => 'place supérieur ou égal à un',
                    ),
            ),
            array(
                    'field' => 'datedebut',
                    'label' => 'datedebut',
                    'rules' => 'required|callback_compareDate',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                    ),
                ),
            array(
                    'field' => 'datefinc',
                    'label' => 'datefinc',
                    'rules' => 'required|callback_compareDate',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                    ),
            )
        );
        

        $indice=1;

        while(!empty($this->input->post('gestiontransport'.$indice)) || $this->input->post('gestiontransport'.$indice)=="0")
        {
            $rule1=array(
                'field' => 'place'.$indice,
                'label' => 'place'.$indice,
                'rules' => 'required|is_natural_no_zero',
                'errors' => array(
                    'required' => 'vous devez fournir un %s.',
                    'is_natural_no_zero' => 'place supérieur ou égal à un',
                )
            );
            $rule2=array(
                    'field' => 'datefin'.$indice,
                    'label' => 'datefin'.$indice,
                    'rules' => 'required|callback_compareDaty['.$indice.']',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                            'callback_compareDaty['.$indice.']' => 'veuiller verifier la date',
                    ),
            );

            array_push($config,$rule1,$rule2);
            $indice++;
        }

        $this->form_validation->set_rules($config);

            $client=$this->input->post('client');
            $datedebut=$this->input->post('datedebut');
            $datefin=$this->input->post('datefinc');
            $circuit=array(
                'client' => $client,
                'datedebut' => $datedebut,
                'datefin' => $datefin
            );
            $detailcircuit=array(
                array(
                    'depart' => $this->input->post('depart'),
                    'place' => $this->input->post('place'),
                    'arrive' => $this->input->post('arrive'),
                    'gestiontransport' => $this->input->post('gestiontransport'),
                    'datedebut' => $this->input->post('datedebut'),
                    'datefin' => $this->input->post('datefin'),
                    'idcircuit' => null,
                ),
            );
    
        
            for($i=1;$i<$indice;$i++)
            {
                if($i==1)
                {
                    $array=array(
                        'depart' => $this->input->post('arrive'),
                        'place' => $this->input->post('place'.$i),
                        'arrive' => $this->input->post('arrive'.$i),
                        'gestiontransport' => $this->input->post('gestiontransport'.$i),
                        'datedebut' => $this->input->post('datefin'),
                        'datefin' => $this->input->post('datefin'.$i),
                        'idcircuit' => null,
                    );
                }
                else
                {
                    $array=array(
                        'depart' => $this->input->post('arrive'.($i-1)),
                        'place' => $this->input->post('place'.$i),
                        'arrive' => $this->input->post('arrive'.$i),
                        'gestiontransport' => $this->input->post('gestiontransport'.$i),
                        'datedebut' => $this->input->post('datefin'.($i-1)),
                        'datefin' => $this->input->post('datefin'.$i),
                        'idcircuit' => null,
                    );
                }
                array_push($detailcircuit,$array);
            }

        if ($this->form_validation->run() == FALSE)
        {
            $data['page']='add-circuit';
            $data['lieus']=$this->Lieu->getAll();
            $data['dataTrajet']=$detailcircuit;
            $data['circuit']=$circuit;
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view($this->index,$data);
        }
        else
        {

            $this->Circuit->insertWithTrajet($detailcircuit,$circuit);
            $this->session->set_flashdata('success', 'Circuit added Successfully');
            redirect('manage-circuit');
        }
        
    }


    public function planningvoiture()
    {
        $config["base_url"] = base_url() . "planning-voiture/";
        $config["total_rows"] = $this->Vehicule->countall();
        $config["per_page"] = 10;
        $config["uri_segment"] = 2;
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
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["links"] = $this->pagination->create_links();

        $data['page'] = 'planning-voiture';
        $data['vehicules'] = $this->Vehicule->getAll($config["per_page"], $page);
        $this->load->view ($this->index, $data);
    }

    public function planningparvoiture($numero)
    {
    $config["base_url"] = base_url() . "planning-parvoiture/".$numero;
    $config["total_rows"] = $this->Circuit->countplanning($numero);
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
        $data['vehicule_id'] = $numero;
        $data['trajets'] = $this->Circuit->planningvoiture($numero,$config["per_page"], $page);
        $data['page'] = 'planning-parvoiture';
        $this->load->view($this->index, $data);
    }


    /**
     * liste des chauffeurs
     */
    public function planningchauffeur()
    {
        $config = array();
        $config["base_url"] = base_url() . "planning-chauffeur";
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
        $data['page'] = 'planning-chauffeur';
        $this->load->view($this->index, $data);
    }


    public function planningparchauffeur($idchauffeur)
    {
        $config["base_url"] = base_url() . "planning-parchauffeur/".$idchauffeur;
        $config["total_rows"] = $this->Circuit->countplanningchauffeur($idchauffeur);
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
        $data['trajets'] = $this->Circuit->planningchauffeur($idchauffeur,$config["per_page"], $page);
        $data['page'] = 'planning-parchauffeur';
        $this->load->view($this->index, $data);
    }
    /*
    function for edit Circuit get
    returns  Circuit by id.
    created by your name
    created at 13-09-22.
    */
    public function editCircuit($circuit_id) {
        $data['circuit_id'] = $circuit_id;
        $data['circuit'] = $this->Circuit->getDataById($circuit_id);
        $data['trajets'] = $this->Circuit->getAlltrajets($circuit_id);
        $data['page'] = 'detail-circuit';
        $this->load->view($this->index, $data);
    }


    /**
     * fonction pour modifier le circuit
     */
    public function modifycircuit($circuit_id)
    {
        $data['circuit_id'] = $circuit_id;
        $data['page']='modify-circuit';
        $data['lieus']=$this->Lieu->getAllC();
        $data['dataTrajet']=$this->Circuit->getAlltrajetsArray($circuit_id);
        $data['circuit']=$this->Circuit->getDataByIdArray($circuit_id)[0];
        $this->load->view($this->index,$data);
    }

    /**
     * fonction pour modifier les trajets sans voiture
     */

     public function modifyTrajet($idtrajet)
     {
        $data['trajet_id']=$idtrajet;
        $data['trajet']=$this->Circuit->getTrajet($idtrajet);
        $data['voisin']=$this->Circuit->getVoisin($idtrajet,$data['trajet'][0]->idcircuit);
        $data['lieus']=$this->Lieu->getAllC();
        $data['circuit']=$this->Circuit->getDataByIdArray($data['trajet'][0]->idcircuit)[0];
        $verif=$this->Circuit->verifyTrajet($data['voisin'][0],$data['voisin'][1]);
        $data['verif']=-1;
        if($this->Circuit->AvecVoiture($idtrajet))
        {
            $data['circuit'] = $this->Circuit->getDataById($data['trajet'][0]->idcircuit);
            $data['trajets'] = $this->Circuit->getAlltrajets($data['trajet'][0]->idcircuit);
            $data['page'] = 'detail-circuit';
            $this->session->set_flashdata('error', 'le trajet avec une voiture ne peut etre modifier veuiller enlever la voiture du trajet');
            $this->load->view($this->index, $data);
        }
        else
        {
            $data['verif']=$verif;
            $data['page']='edit-trajet';
            $this->load->view($this->index,$data);
        }
        
     }

     /**
      * modif trajet
      */
     public function modiftrajetpost()
     {
        $data['idtrajet']=$this->input->post('idtrajet');
        $data['verif']=$this->input->post('verif');
        $data['idavant']=$this->input->post('idavant');
        $data['idapres']=$this->input->post('idapres');
        $data['depart']=$this->input->post('depart');
        $data['arrive']=$this->input->post('arrive');
        $data['datedepart']=$this->input->post('datedebut');
        $data['datefin']=$this->input->post('datefin');
        $data['gestiontransport']=$this->input->post('gestiontransport');
        
        $message=$this->Circuit->TrajetAvecAdj($data);
        if($message)
        {
            $dataP['trajet']=$this->Circuit->getTrajet($data['idtrajet']);
            $dataP['circuit'] = $this->Circuit->getDataById($dataP['trajet'][0]->idcircuit);
            $dataP['trajets'] = $this->Circuit->getAlltrajets($dataP['trajet'][0]->idcircuit);
            $dataP['page'] = 'detail-circuit';
            $this->session->set_flashdata('success', 'trajet modifié avec succès');
            $this->load->view($this->index, $dataP);
        }
        else
        {
            
            $idtrajet=$data['idtrajet'];
            $dataP['trajet']=$this->Circuit->getTrajet($idtrajet);
            $dataP['voisin']=$this->Circuit->getVoisin($idtrajet,$data['trajet'][0]->idcircuit);
            $dataP['lieus']=$this->Lieu->getAllC();
            $dataP['circuit']=$this->Circuit->getDataByIdArray($data['trajet'][0]->idcircuit)[0];
            $verif=$this->Circuit->verifyTrajet($data['voisin'][0],$data['voisin'][1]);
            $dataP['verif']=$verif;
            $dataP['page']='edit-trajet';
            $this->session->set_flashdata('error', $message);
            $this->load->view($this->index,$dataP);    
        }
        
        
     }


    public function editCircuitPost() {

        $config = array(
            array(
                    'field' => 'place',
                    'label' => 'place',
                    'rules' => 'required|is_natural_no_zero',
                    'errors' => array(
                        'required' => 'vous devez fournir un %s.',
                        'is_natural_no_zero' => 'place supérieur ou égal à un',
                    ),
            ),
            array(
                    'field' => 'datedebut',
                    'label' => 'datedebut',
                    'rules' => 'required|callback_compareDate',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                    ),
                ),
            array(
                    'field' => 'datefinc',
                    'label' => 'datefinc',
                    'rules' => 'required|callback_compareDate',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                    ),
            )
        );
        

        $indice=1;

        while(!empty($this->input->post('gestiontransport'.$indice)) || $this->input->post('gestiontransport'.$indice)=="0")
        {
            $rule1=array(
                'field' => 'place'.$indice,
                'label' => 'place'.$indice,
                'rules' => 'required|is_natural_no_zero',
                'errors' => array(
                    'required' => 'vous devez fournir un %s.',
                    'is_natural_no_zero' => 'place supérieur ou égal à un',
                )
            );
            $rule2=array(
                    'field' => 'datefin'.$indice,
                    'label' => 'datefin'.$indice,
                    'rules' => 'required|callback_compareDaty['.$indice.']',
                    'errors' => array(
                            'required' => 'vous devez fournir une %s.',
                            'callback_compareDaty['.$indice.']' => 'veuiller verifier la date',
                    ),
            );

            array_push($config,$rule1,$rule2);
            $indice++;
        }

        $this->form_validation->set_rules($config);

            $client=$this->input->post('client');
            $datedebut=$this->input->post('datedebut');
            $datefin=$this->input->post('datefinc');
            $circuit=array(
                'client' => $client,
                'datedebut' => $datedebut,
                'datefin' => $datefin
            );
            $detailcircuit=array(
                array(
                    'depart' => $this->input->post('depart'),
                    'place' => $this->input->post('place'),
                    'arrive' => $this->input->post('arrive'),
                    'gestiontransport' => $this->input->post('gestiontransport'),
                    'datedebut' => $this->input->post('datedebut'),
                    'datefin' => $this->input->post('datefin'),
                    'idcircuit' => null,
                ),
            );
    
        
            for($i=1;$i<$indice;$i++)
            {
                if($i==1)
                {
                    $array=array(
                        'depart' => $this->input->post('arrive'),
                        'place' => $this->input->post('place'.$i),
                        'arrive' => $this->input->post('arrive'.$i),
                        'gestiontransport' => $this->input->post('gestiontransport'.$i),
                        'datedebut' => $this->input->post('datefin'),
                        'datefin' => $this->input->post('datefin'.$i),
                        'idcircuit' => null,
                    );
                }
                else
                {
                    $array=array(
                        'depart' => $this->input->post('arrive'.($i-1)),
                        'place' => $this->input->post('place'.$i),
                        'arrive' => $this->input->post('arrive'.$i),
                        'gestiontransport' => $this->input->post('gestiontransport'.$i),
                        'datedebut' => $this->input->post('datefin'.($i-1)),
                        'datefin' => $this->input->post('datefin'.$i),
                        'idcircuit' => null,
                    );
                }
                array_push($detailcircuit,$array);
            }
            $circuit_id = $this->input->post('idcircuit');
        if ($this->form_validation->run() == FALSE)
        {
            $data['circuit_id'] = $circuit_id;
            $data['page']='modify-circuit';
            $data['lieus']=$this->Lieu->getAllC();
            $data['dataTrajet']=$this->Circuit->getAlltrajetsArray($circuit_id);
            $data['circuit']=$this->Circuit->getDataByIdArray($circuit_id)[0];
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view($this->index,$data);
        }
        else
        {

            if($this->Circuit->ModifWithTrajet($detailcircuit,$circuit,$circuit_id)==false)
            {
                $this->session->set_flashdata('error', 'le(s) trajet(s) possède déja une voiture assigné');
                redirect('manage-circuit');
            }
            else
            {
                $this->session->set_flashdata('success', 'Circuit modifié avec succès');
                redirect('manage-circuit');
            }
            
        }
        
    }

	/**
	 * liste des trajets pour assigner une voiture
	 */
	public function choixTrajet($circuit_id)
	{
		$data['trajets']=$this->Circuit->getAlltrajets($circuit_id);
		$data['circuit'] = $this->Circuit->getDataById($circuit_id);
		$data['page']='choix-assignement';
		$this->load->view($this->index, $data);
	}

	/**
	 * Voiture dispo pour les trajets
	 */
	public function VoitureDispoMultiple()
	{
		$debut=$this->input->post('debut');
		$fin=$this->input->post('fin');
		if($debut>$fin)
		{
			$debut=$this->input->post('fin');
			$fin=$this->input->post('debut');
		}
		$datedebut1=$this->input->post('datedebut'.$debut);
		$datedebut2=$this->input->post('datedebut'.$fin);
		$idcircuit=$this->input->post('idcircuit');
		$data['trajets']=$this->Circuit->trajetsbetween($idcircuit,$datedebut1,$datedebut2);
		$datefin=$this->input->post('datefin'.$fin);
		$data['vehicules']=$this->Circuit->getDispo($datedebut1,$datefin);
		$data['avides']=$this->Circuit->voitureavide($datedebut1,$datefin);
		$data['page']='assign-voiture-multiple';
		$this->load->view($this->index, $data);
	}

	/**
	 * rentrer d'un trajet
	 */
    public function rentrerpost()
	{
		$data['idtrajet']=$this->input->post('idtrajet');
		$data['numero'] = $this->input->post('numero');
		$data['idlocation'] = null;
		$data['idchauffeur'] = $this->input->post('idchauffeur');
        if($data['idchauffeur']=="")
		{
			$data['idchauffeur']=null;
		}
		$data['datedepart']=$this->input->post('datedepart');
		$data['datearrive']=$this->input->post('arriveparking');

		$this->Circuit->rentrer($data);
		$this->session->set_flashdata('success', 'ajout du trajet de retour réussie');
		redirect('assignement-voiture/'.$this->input->post('idtrajet'));
	}

    /**
     * enlever une voiture d'un trajet
     */
    public function enleverpost()
    {

        $idavant=$this->input->post('idavant');
        $actu=$this->input->post('idtrajet');
        $idapres=$this->input->post('idapres');
        $numero=$this->input->post('numero');
        
        if(!empty($idapres))
        {
            $data['avantadjacent']=$this->Circuit->adjacentAvant($numero,$idavant);
            $data['idactu']=$actu;
            $data['numero']=$numero;
            $data['apresadjacent']=$this->Circuit->adjacentApres($numero,$idapres);
            $data['trajet']=$this->Circuit->getTrajet($actu);
            if($data['avantadjacent'][0]->departapres==21)
                $data['page']='enlever-voiture';
            else
            {
                $data['page']='enlever-voiture-liaison';
            }
            $this->load->view($this->index,$data);
        }
        elseif(!empty($this->input->post('suppression')))
        {
            $data['suppression']=$this->input->post('suppression');
            //trajet d'ou on enlève la voiture
            $data['idtrajetactu']=$this->input->post('idtrajetactu');
            //trajet avant actu
            $data['idtrajetavant']=$this->input->post('idtrajetavant');
            //date de depart nouveau trajet
            $data['depart']=$this->input->post('depart');
            //date d'arrive
            $data['arrive']=$this->input->post('datefinarrive');
            //lieux
            $data['lieudepart']=$this->input->post('idregiondepart');
            $data['lieuarrive']=$this->input->post('idregionarrive');
            //trajet suivant adjacent au nouveau trajet de liaison crée
            $data['iddernierlieu']=$this->input->post('idderniertrajet');
            //trajet de liaison si il'y en a
            $data['liaison']=$this->input->post('idtrajetliaison');
            $data['numero']=$this->input->post('numero');
            //premier trajet
            $data['adjavant']=$this->input->post('adjavant');

            //trajet cas 3 
            //trajet avant different de depart parking
                //premier trajet de liaison à supprimer
            $data['liaisonavant']=$this->input->post('liaisonavant');

                //premier à créer
            $data['idregiondepart1']=$this->input->post('idregiondepart1');
            $data['datedebut1']=$this->input->post('datedebut1');
            $data['datearrive1']=$this->input->post('datearrive1');
                //deuxieme à créer
            $data['idregionarrive2']=$this->input->post('idregionarrive2');
            $data['datearrive2']=$this->input->post('datearrive2');
            $data['datedepart2']=$this->input->post('datedepart2');
            //dernier trajet apres le nouveau trajet de liaison
            $data['idderniertrajet2']=$this->input->post('idderniertrajet2');
            $data['idtrajetliaison2']=$this->input->post('idtrajetliaison2');
            //cas 3-2
            $data['idregiondepart']=$this->input->post('idregiondepart');
            $data['idregionarrive']=$this->input->post('idregionarrive');
            $data['idderniertrajet']=$this->input->post('idderniertrajet');
            $data['datedepart']=$this->input->post('datedepart');
            $data['datefinarrive']=$this->input->post('datefinarrive');

            $verif=$this->Circuit->enleverapres($data);
            if($verif == -1)
            {
                $this->session->set_flashdata('error', 'la voiture n est plus sur ce trajet');
                redirect('assignement-voiture/'.$this->input->post('idtrajetactu'));
            }
            $this->session->set_flashdata('success', 'voiture enlever');
            redirect('assignement-voiture/'.$this->input->post('idtrajetactu'));
        }
        else
        {
            $int=$this->Circuit->enlever($idavant,$actu,$idapres,$numero);
            if($int == -1)
            {
                $this->session->set_flashdata('error', 'la voiture n est plus sur ce trajet');
                redirect('assignement-voiture/'.$this->input->post('idtrajet'));
            }
            $this->session->set_flashdata('success', 'voiture enlever');
            redirect('assignement-voiture/'.$this->input->post('idtrajet'));
        }

		
    }


    /**
     * assigner une voiture à un trajet
     */
    public function assignvoiture($idtrajet)
    {
        $data['trajet']=$this->Circuit->getTrajet($idtrajet);
        if(empty($data['trajet'][0]->idcircuit))
        {
            redirect('manage-circuit');
        }

        $data['page']='assign-voiture';
        //si la gestion des transports est autre qu'une voiture
        if($data['trajet'][0]->gestiontransport == 1)
        {

        }
        else
        {
            $datefin=$data['trajet'][0]->datefin.' '.$data['trajet'][0]->heurefin;
            $datedebut=$data['trajet'][0]->datedebut.' '.$data['trajet'][0]->heuredebut;
            $data['vehicules']=$this->Circuit->getDispo($datedebut,$datefin);
            $data['avides']=$this->Circuit->voitureavide($datedebut,$datefin);
            $data['chauffeurs']=$this->Circuit->getChauffeurDispo($datedebut,$datefin);
            $choix=rand(0,count($data['chauffeurs'])-1);
            $data['choix']=$data['chauffeurs'][$choix];
            $data['vehiculesAssigner']=$this->Circuit->getVehiculeAssigner($idtrajet);
            
        }
        $data['voisin']=$this->Circuit->getVoisin($idtrajet,$data['trajet'][0]->idcircuit);
        $data['trajetav']="0";
        $data['retAvant']=-1;
        if(!empty($data['voisin'][0]))
        {
            $data['trajetav']=$this->Circuit->getTrajet($data['voisin'][0]);
            $data['retAvant']=$data['trajetav'][0]->gestiontransport;
        }
        
        $this->load->view($this->index, $data);
    }

    public function assignvoiturepost()
    {
        $dataTrajetVoiture['idtrajet']=$this->input->post('idtrajet');
        if(!empty($this->input->post('iddebut')))
        {
            $dataTrajetVoiture['idtrajet']=$this->input->post('iddebut');
        }
        $dataTrajetVoiture['numero'] = $this->input->post('numero');
        $dataTrajetVoiture['idlocation'] = null;
        $dataTrajetVoiture['idchauffeur']=$this->input->post('idchauffeur');
        if(empty($dataTrajetVoiture['idchauffeur']))
        {
            $dataTrajetVoiture['idchauffeur']=null;
        }

        /**
         *  id des lieux dernier trajet depart actuelle et depart prochain
         */
        $data['lieuavant']=$this->input->post('idregionavant');
        $data['lieuapres']=$this->input->post('idregionapres');
        $data['lieuactuelle']=$this->input->post('idregionactuelle');
        /**
         * id des trajets avant actuelle et apres
         */
        $data['idactuelle']=$this->input->post('idactuelle');
        $data['idsuivant']=$this->input->post('idprochain');
        $data['idavant']=$this->input->post('idavant');
        /**
         * date de depart si dernier Arrêt Parking
         * date de dernier arrêt
         * date de debut trajet à assigner
         */
        $data['datedepart']=$this->input->post('datedepart');
        $data['datedernier']=$this->input->post('datedernier');
        $data['datedebut']=$this->input->post('datedebut');

        /**
         * date arriver au parking si il y a un prochain trajet
         */
        $data['datefin']=$this->input->post('datefin');

        /**
         *  trajet normal 
         */
        if($data['lieuavant'] == $this->input->post('idregionapres') && $data['lieuavant']=="21" && empty($this->input->post('datedebut1')))
        {
            $data['avantadjacent']=$this->Circuit->adjacentAvant($dataTrajetVoiture['numero'],$data['idavant']);
            $data['apresadjacent']=$this->Circuit->adjacentApres($dataTrajetVoiture['numero'],$data['idsuivant']);
            $data['trajet']=$this->Circuit->getTrajet($data['idactuelle']);
            $data['page']='choix-avide';
			$data['idtrajet']=$this->input->post('idtrajet');
			$data['numero'] = $this->input->post('numero');
			$data['idlocation'] = null;
			$data['idchauffeur'] = $this->input->post('idchauffeur');
            if(empty($dataTrajetVoiture['idchauffeur']))
            {
                $data['idchauffeur']=null;
            }
            $this->load->view($this->index, $data);
        }
        elseif(!empty($this->input->post('avideparking')))
		{
			$dataP['avideparking']=$this->input->post('avideparking');
			$dataP['idavantP1']=$this->input->post('idavantP1');
			$dataP['idavant']=$this->input->post('idavant');
			$dataP['idarriveavant']=$this->input->post('idarriveavant');
			$dataP['iddepartactu']=$this->input->post('iddepartactu');
			$dataP['idapresP1']=$this->input->post('idapresP1');
			$dataP['idapres']=$this->input->post('idapres');
			$dataP['idtrajet']=$this->input->post('idtrajet');
			$dataP['numero']=$this->input->post('numero');

			$this->Circuit->assignSansParking($dataP);
			$this->session->set_flashdata('success', 'voiture ajouté avec success');
			redirect('assignement-voiture/'.$this->input->post('idtrajet'));

		}
        elseif(empty($this->input->post('avide')) && empty($this->input->post('datedebut1')))
        {
            //verification si la date de depart n'est pas nulle ou avant la date de dernier arrêt
            if(empty($data['idavant']) && empty($data['datedepart']))
            {
                $this->session->set_flashdata('error', 'veuiller entrer la date de départ de la voiture');
                redirect('assignement-voiture/'.$this->input->post('idtrajet'));
            }
            elseif($data['lieuavant']=='21' && strtotime($data['datedernier'])>strtotime($data['datedepart']))
            {
                $this->session->set_flashdata('error', "la voiture à encore un trajet le".$data['datedepart']);
                redirect('assignement-voiture/'.$this->input->post('idtrajet'));
            }

            /**
             * Assigner une voiture à un trajet
             */

            $this->Circuit->assignVoiture($dataTrajetVoiture,$data);
            $this->session->set_flashdata('success', 'voiture ajouté avec success');
            redirect('assignement-voiture/'.$this->input->post('idtrajet'));
        }
        elseif(!empty($this->input->post('datedebut1')))
		{
			//les premiers et derniers trajets de la liste
			$data['datedebut1']=$this->input->post('datedebut1');
			$data['datefin1']=$this->input->post('datefin1');
			$data['iddebut']=$this->input->post('iddebut');
			$data['datedebut2']=$this->input->post('datedebut2');
			$data['idfin']=$this->input->post('idfin');
			$data['idcircuit']=$this->input->post('idcircuit');
			$this->Circuit->assignToMulti($dataTrajetVoiture,$data);
			$this->session->set_flashdata('success', 'voiture ajouté avec success');
			redirect('assignement-voiture/'.$this->input->post('idfin'));
		}
        /** trajet à vide */
        else
        {
            $this->Circuit->assignVoitureavide($dataTrajetVoiture,$data);
            $this->session->set_flashdata('success', 'voiture ajouté avec success');
            redirect('assignement-voiture/'.$this->input->post('idtrajet'));
        }
        
        

       
    }

    /**
     * voiture en attente 
     */
    public function enAttente()
    {
        $data['trajets']=$this->Circuit->getAttente();
        $data['page']='list-attente';
        $this->load->view($this->index, $data);
    }



    /*
     * assignement chauffeur
     */
	public function assignchauffeur()
	{
		$data['numero']=$this->input->post('numero');
		$data['datedebut']=$this->input->post('datedebut');
        $data['idchauffeur']=$this->input->post('idchauffeur');
        $data['idavant']=$this->input->post('idavant');
        $this->Circuit->assignchauffeur($data);
        redirect('assignement-voiture/'.$this->input->post('idtrajet'));
	}

    /**
     * formulaire de recherche de circuit
     */
    public function formFind()
    {
        $data['vehicules']=$this->Vehicule->getAllEntreprise();
        $data['lieus']=$this->Lieu->getAllC();
        $data['chauffeurs']=$this->Chauffeur->getAllC();
        $data['page']='find-circuit';
        $this->load->view($this->index,$data);
    }

    /**
     * traitement recherche
     */
    public function findpost()
    {
        $data['trajets']=$this->Circuit->find($this->input->post('numero'),$this->input->post('chauffeur'),$this->input->post('client'),$this->input->post('depart'),$this->input->post('arrive'),$this->input->post('datedebut'),$this->input->post('datearrive'));
        $data['page']='result-circuit';
        $this->load->view($this->index,$data);
    }

    /*
    function for view Circuit get
    created by your name
    created at 13-09-22.
    */
    public function viewCircuit($circuit_id) {
        $data['circuit_id'] = $circuit_id;
        $data['circuit'] = $this->Circuit->getDataById($circuit_id);
        $this->load->view('circuit/view-circuit', $data);
    }
    /*
    function for delete Circuit  created by your name
    created at 13-09-22.
    */
    public function deleteCircuit($circuit_id) {
        $delete = $this->Circuit->delete($circuit_id);
        if($delete == false)
        {
            $this->session->set_flashdata('error', 'le circuit ne doit pas contenir de voiture');
            redirect('manage-circuit');
        }
        else
        {
            $this->session->set_flashdata('success', 'circuit supprimé');
            redirect('manage-circuit');
        }
        
    }
    /*
    function for activation and deactivation of Circuit.
    created by your name
    created at 13-09-22.
    */
    public function changeStatusCircuit($circuit_id) {
        $edit = $this->Circuit->changeStatus($circuit_id);
        $this->session->set_flashdata('success', 'circuit '.$edit.' Successfully');
        redirect('manage-circuit');
    }
    
}
