<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Defect extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tra_defect_model');
		$this->load->library('form_validation', 'session');

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

	// function index
	public function index()
	{
		if ($this->schema == null && $this->dba == null) {
			show_404();
		}

		// set admin only
		if ($this->session->userdata('level') != 'S') {
			show_404();
		}

		$this->load->view('users/basic_data/defect/list');
	}

	// function get data defect using JQuery AJAX
	public function getList()
	{
		$data = $this->Tra_defect_model->getByFactory($this->schema, $this->dba);
		echo json_encode($data);
	}
}
