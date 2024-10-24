<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Process extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tra_process_model');
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

		$this->load->view('users/basic_data/process/list');
	}

	// function show using jquery ajax
	public function ajaxShow()
	{
		$data = $this->Tra_process_model->getByFactory($this->schema, $this->dba);
		echo json_encode($data);
	}

	// function add using jquery ajax
	public function ajaxAdd()
	{
		$this->form_validation->set_rules($this->Tra_process_model->rules());

		// condition if validation is true
		if ($this->form_validation->run()) {
			$data = $this->Tra_process_model->save($this->schema, $this->dba);
			echo json_encode($data);
		} else {
			echo json_encode(false);
		}
	}

	// function edit using jquery ajax 
	public function ajaxEdit()
	{
		$process_no = $this->input->post('process_no', true);
		$line_type = $this->input->post('line_type', true);

		if (!isset($process_no) || !isset($line_type)) {
			show_404();
		}

		$this->form_validation->set_rules($this->Tra_process_model->rules());

		// condition if validation is true
		if ($this->form_validation->run()) {
			$data = $this->Tra_process_model->update($this->schema, $this->dba);
			echo json_encode($data);
		} else {
			echo json_encode(false);
		}
	}

	// function delete using jquery ajax
	public function ajaxDelete($id = null)
	{
		$process_no = substr($id, 0, 3);
		$line_type = substr($id, 3, 1);

		if (!isset($process_no) || !isset($line_type)) {
			show_404();
		}

		$confirm = $this->Tra_process_model->check_delete($this->schema, $this->dba, $process_no, $line_type);
		if (!$confirm) {
			$data = $this->Tra_process_model->delete($this->schema, $this->dba, $process_no, $line_type);
			echo json_encode($data);
		} else {
			echo json_encode(false);
		}
	}
}
