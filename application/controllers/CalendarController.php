<?php

require('RoleCircuitController.php');
class CalendarController extends RoleCircuitController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Circuit');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function showCalendar() { 
        $data['page']='calendar';
        $this->load->view($this->index, $data);
    }

    public function listcircuit($daty)
    {
        $circuit=$this->Circuit->getCircuitMois($daty);
        echo json_encode($circuit);
    }

}

?>
