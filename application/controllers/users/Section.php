<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Section extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tra_section_model');
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

		$this->load->view('users/basic_data/section/list');
	}

	// function show using jquery ajax
	public function allListSection()
	{
		$data = $this->Tra_section_model->getByFactory($this->schema, $this->dba);
		echo json_encode($data);
	}

	// function get data section using JQuery AJAX
	public function listActiveSection()
	{
		$data = $this->Tra_section_model->getActiveSection($this->schema, $this->dba);
		echo json_encode($data);
	}

	// function get data section by date using JQuery AJAX
	public function listSectionDate()
	{
		$indate = $this->input->post('indate', true);

		$data = $this->Tra_section_model->getSectionDate($this->schema, $this->dba, $indate);
		echo json_encode($data);
	}

	// function update line type
	public function updateLine()
	{
		$sec_no = $this->input->post('sec_no', true);
		$line = $this->input->post('line_type', true);

		$section = $this->Tra_section_model;
		$validation = $this->form_validation;
		$validation->set_rules($section->rules());

		// condition if validation is true
		if ($validation->run()) {
			$data = $section->updateLineType($this->schema, $this->dba, $sec_no, $line);
			echo json_encode($data);
		} else {
			echo json_encode(false);
		}
	}
}
