<?php
require('RoleEntretienController.php');
class EtatpiecevoitureController extends RoleEntretienController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Etatpiecevoiture');
        $this->load->library('session');
        $this->load->helper('url');
    }

    /*
    function for manage Etatpiecevoiture.
    return all Etatpiecevoitures.
    created by your name
    created at 31-08-22.
    santosh salve
    */
    public function manageEtatpiecevoiture() { 
        $data['etatpiecevoitures'] = $this->Etatpiecevoiture->getAll();
        $data['page'] = 'manage-etatpiecevoiture';
        $this->load->view($this->index, $data);
    }

    public function EtatPieceVoiture($numero)
    {
        $data['etatpiecevoitures'] = $this->Etatpiecevoiture->etatpiece($numero);
        $data['page'] = 'manage-etatpiecevoiture';
        $this->load->view($this->index, $data);
    }


}