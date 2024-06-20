<?php

require('RoleEntretienController.php');
class PieceController extends RoleEntretienController {

    public function __construct() {
        parent::__construct();
        $this->load->model('Piece');
        $this->load->library('session');
        $this->load->library("pagination");
    }
    /*
    function for manage Piece.
    return all Pieces.
    created by your name
    created at 01-09-22.
	santosh salve
    */
    public function managePiece() {
        $config = array();
        $config["base_url"] = base_url() . "manage-piece";
        $config["total_rows"] = $this->Piece->get_count();
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
        $data['page']='manage-piece';
        $data['pieces'] = $this->Piece->getAll($config["per_page"], $page);
        $this->load->view($this->index, $data);
    }
    /*
    function for  add Piece get
    created by your name
    created at 01-09-22.
    */
    public function addPiece() {
        $this->load->view('piece/add-piece');
    }
    /*
    function for add Piece post
    created by your name
    created at 01-09-22.
    */
    public function addPiecePost() {
        $data['nom'] = $this->input->post('nom');
    $this->Piece->insert($data);
        $this->session->set_flashdata('success', 'Piece added Successfully');
        redirect('manage-piece');
    }
    /*
    function for edit Piece get
    returns  Piece by id.
    created by your name
    created at 01-09-22.
    */
    public function editPiece($piece_id) {
        $data['piece_id'] = $piece_id;
        $data['piece'] = $this->Piece->getDataById($piece_id);
        $data['page']='edit-piece';
        $this->load->view($this->index, $data);
    }
    /*
    function for edit Piece post
    created by your name
    created at 01-09-22.
    */
    public function editPiecePost() {
        $piece_id = $this->input->post('piece_id');
        $piece = $this->Piece->getDataById($piece_id);
        $data['nom'] = $this->input->post('nom');
    $edit = $this->Piece->update($piece_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'Piece Updated');
            redirect('manage-piece');
        }
    }
    /*
    function for view Piece get
    created by your name
    created at 01-09-22.
    */
    public function viewPiece($piece_id) {
        $data['piece_id'] = $piece_id;
        $data['piece'] = $this->Piece->getDataById($piece_id);
        $this->load->view('piece/view-piece', $data);
    }
    /*
    function for delete Piece    created by your name
    created at 01-09-22.
    */
    public function deletePiece($piece_id) {
        $delete = $this->Piece->delete($piece_id);
        $this->session->set_flashdata('success', 'piece deleted');
        redirect('manage-piece');
    }
    /*
    function for activation and deactivation of Piece.
    created by your name
    created at 01-09-22.
    */
    public function changeStatusPiece($piece_id) {
        $edit = $this->Piece->changeStatus($piece_id);
        $this->session->set_flashdata('success', 'piece '.$edit.' Successfully');
        redirect('manage-piece');
    }
    
}