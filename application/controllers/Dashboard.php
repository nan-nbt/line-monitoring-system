<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tra_section_model');
		$this->load->model('Tra_collection_model');
		$this->load->model('Tra_process_model');
		$this->load->library('form_validation');

		if ($this->session->userdata('factory') == '0228') {
			$this->schema = 'pcagleg';
			$this->dba = $this->load->database('db_pci', true);
			$this->session->set_userdata('schema', $this->schema);
		} else if ($this->session->userdata('factory') == 'B0CV') {
			$this->schema = 'pgdleg';
			$this->dba = $this->load->database('db_pgd', true);
			$this->session->set_userdata('schema', $this->schema);
		} else if ($this->session->userdata('factory') == 'B0EM') {
			$this->schema = 'pgsleg';
			$this->dba = $this->load->database('db_pgs', true);
			$this->session->set_userdata('schema', $this->schema);
		} else {
			$this->schema = null;
			$this->dba = null;
			$this->session->set_userdata('schema', $this->schema);
		}
	}

	public function index()
	{
		// if($this->schema != null && $this->dba != null){
		//     $data['tra_section']=$this->Tra_section_model->getByFactory($this->schema, $this->dba); 
		//     $data['tra_collection']=$this->Tra_collection_model->getByFactory($this->schema, $this->dba); 
		//     $data['tra_process']=$this->Tra_process_model->getByFactory($this->schema, $this->dba); 
		// }

		// $this->load->view('layouts/dashboard', $data);
		$this->load->view('layouts/dashboard');
	}
}
