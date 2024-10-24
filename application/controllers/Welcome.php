<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('Tra_section_model');
        $this->load->model('Tra_collection_model');
        $this->load->model('Tra_process_model');
        $this->load->library('form_validation');
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($id=null){
		// $this->load->view('welcome_message');

		$data['tra_section']=$this->Tra_section_model->getByFactory(); 
		$data['tra_collection']=$this->Tra_collection_model->getByFactory(); 
		$data['tra_process']=$this->Tra_process_model->getByFactory(); 
		$this->template->load('layouts/dashboard','welcome_message', $data);
	}

	public function default(){
		$this->load->view('welcome_message');
	}

	public function test_db()
	{
		$this->load->database();
		$query = $this->db->get("pcagleg.tl_factory");
		echo "<pre>";
		print_r($query->result());

		$db_pgd = $this->load->database('db_pgd', TRUE); 
		$query2 = $db_pgd->get("pgdleg.tl_factory");
		print_r($query2->result());

		$db_pgs = $this->load->database('db_pgs', TRUE); 
		$query3 = $db_pgs->get("pgsleg.tl_factory");
		print_r($query3->result());

		exit;
	}

}
