<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Collection extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tra_process_model');
		$this->load->model('Tra_order_model');
		$this->load->model('Tra_section_model');
		$this->load->model('Tra_collection_model');
		$this->load->model('Tra_area_model');
		$this->load->model('Tra_build_model');
		$this->load->model('Tra_defect_model');
		$this->load->library('form_validation', 'session', 'datatables');

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
		if ($this->session->userdata('level') == null) {
			show_404();
		}
		$this->load->view('users/process/collection/list');
	}

	// get data collection by sec_no and date
	public function getCollect()
	{
		$sec_no = $this->input->post('sec_no_query', true);
		$datestart = $this->input->post('startdate', true);
		$dateend = $this->input->post('enddate', true);
		if (!isset($sec_no, $datestart, $dateend)) {
			$data = $this->Tra_collection_model->getCollection($this->schema, $this->dba, null, date('Ymd'), date('Ymd'));
			echo json_encode($data);
		} else {
			$data = $this->Tra_collection_model->getCollection($this->schema, $this->dba, $sec_no, $datestart, $dateend);
			echo json_encode($data);
		}
	}

	// get detail data collection by sec_no and date
	public function getDetailCollect()
	{
		$submit_id = $this->input->post('submit_id', true);

		if (!isset($submit_id)) {
			$data = $this->Tra_collection_model->getDetailCollection($this->schema, $this->dba, $submit_id);
			echo json_encode($data);
		} else {
			$data = $this->Tra_collection_model->getDetailCollection($this->schema, $this->dba, $submit_id);
			echo json_encode($data);
		}
	}

	// get data report by area and building
	public function getReport()
	{
		$area = $this->input->post('area', true);
		$build = $this->input->post('build', true);
		$datestart = $this->input->post('startdate', true);
		$dateend = $this->input->post('enddate', true);
		if (!isset($area, $build)) {
			$data = $this->Tra_collection_model->getReportCollect($this->schema, $this->dba, null, null, date('Ymd'), date('Ymd'));
			echo json_encode($data);
		} else {
			$data = $this->Tra_collection_model->getReportCollect($this->schema, $this->dba, $area, $build, $datestart, $dateend);
			echo json_encode($data);
		}
	}

	// get data report hourly defect
	public function getHourly()
	{
		$area = $this->input->post('area', true);
		$build = $this->input->post('build', true);
		$datestart = $this->input->post('startdate', true);
		if (!isset($area, $build)) {
			$data = $this->Tra_collection_model->getHourlyDefect($this->schema, $this->dba, null, null, date('Ymd'));
			echo json_encode($data);
		} else {
			$data = $this->Tra_collection_model->getHourlyDefect($this->schema, $this->dba, $area, $build, $datestart);
			echo json_encode($data);
		}
	}

	// function visualization
	public function visual($sec_no = null, $indate = null, $overall = null)
	{
		if ($this->schema == null && $this->dba == null) {
			show_404();
		}

		$collection = $this->Tra_collection_model;
		$sec_no = $this->input->post('sec_no', true);
		$indate = $this->input->post('indate', true);
		$overall = $this->input->post('overall', true);

		if (!isset($sec_no, $indate, $overall)) {
			// $data['tra_collection'] = $collection->getByFactory($this->schema, $this->dba); 
			// $data['tra_section']=$this->Tra_section_model->getByFactory($this->schema, $this->dba);
			// $this->load->view('users/process/visual/line', $data); 

			$this->load->view('users/process/visual/line');
		} else {
			if ($overall == '1') {
				// $data['tra_section']=$this->Tra_section_model->getByFactory($this->schema, $this->dba);
				$data = $collection->getVisual($this->schema, $this->dba, $sec_no, $indate);
				echo json_encode($data);
			} else {
				// $data['tra_section']=$this->Tra_section_model->getByFactory($this->schema, $this->dba);
				$data = $collection->getVisual2Hours($this->schema, $this->dba, $sec_no, $indate);
				echo json_encode($data);
			}
		}
	}

	// function visualization detail
	public function detail($sec_no = null, $indate = null, $overall = null)
	{
		$collection = $this->Tra_collection_model;
		$sec_no = $this->input->post('sec_no', true);
		$indate = $this->input->post('indate', true);
		$overall = $this->input->post('overall', true);

		if (!isset($sec_no, $indate, $overall) || $this->schema == null || $this->dba == null) {
			show_404();
		} else {
			if ($overall == '1') {
				$data['tra_collection'] = $collection->getDetail($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_mostdef'] = $collection->getMostDef($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_RFT'] = $collection->getRFT($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_deflist'] = $collection->getDefectList($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_suglist'] = $collection->getSuggestList($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_section'] = $this->Tra_section_model->getByFactory($this->schema, $this->dba);
				$data['overall'] = $overall;

				if (count($data['tra_collection']) > 0 && count($data['tra_mostdef']) > 0 && count($data['tra_RFT']) > 0) {
					$this->load->view('users/process/visual/detail', $data);
				} else {
					show_404();
				}
			} else {
				$data['tra_collection'] = $collection->getDetail2Hours($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_mostdef'] = $collection->getMostDef2Hours($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_RFT'] = $collection->getRFT($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_deflist'] = $collection->getDefectList2Hours($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_suglist'] = $collection->getSuggestList2Hours($this->schema, $this->dba, $sec_no, $indate);
				$data['tra_section'] = $this->Tra_section_model->getByFactory($this->schema, $this->dba);
				$data['overall'] = $overall;

				if (count($data['tra_collection']) > 0 && count($data['tra_mostdef']) > 0 && count($data['tra_RFT']) > 0) {
					$this->load->view('users/process/visual/detail', $data);
				} else {
					show_404();
				}
			}
		}
	}

	// function get data Area using JQuery AJAX
	public function listActiveArea()
	{
		$data = $this->Tra_area_model->getActiveArea($this->schema, $this->dba);
		echo json_encode($data);
	}

	// function JS detail
	public function ajaxLayout($sec_no = null, $indate = null, $overall = null)
	{
		$collection = $this->Tra_collection_model;
		$sec_no = $this->input->post('sec_no', true);
		$indate = $this->input->post('indate', true);
		$overall = $this->input->post('overall', true);

		if (!isset($sec_no, $indate, $overall) || $this->schema == null || $this->dba == null) {
			show_404();
		} else {
			if ($overall == '1') {
				$data = $collection->getDetail($this->schema, $this->dba, $sec_no, $indate);
			} else {
				$data = $collection->getDetail2Hours($this->schema, $this->dba, $sec_no, $indate);
			}

			if (count($data) > 0) {
				echo json_encode($data);
			} else {
				show_404();
			}
		}
	}

	// function JQuery mostdef
	public function ajaxMostDef($sec_no = null, $indate = null, $overall = null)
	{
		$collection = $this->Tra_collection_model;
		$sec_no = $this->input->post('sec_no', true);
		$indate = $this->input->post('indate', true);
		$overall = $this->input->post('overall', true);

		if (!isset($sec_no, $indate, $overall) || $this->schema == null || $this->dba == null) {
			show_404();
		} else {
			if ($overall == '1') {
				$data = $collection->getMostDef($this->schema, $this->dba, $sec_no, $indate);
			} else {
				$data = $collection->getMostDef2Hours($this->schema, $this->dba, $sec_no, $indate);
			}

			if (count($data) > 0) {
				echo json_encode($data);
			} else {
				show_404();
			}
		}
	}

	// function JQuery RFT
	public function ajaxRFT($sec_no = null, $indate = null)
	{
		$collection = $this->Tra_collection_model;
		$sec_no = $this->input->post('sec_no', true);
		$indate = $this->input->post('indate', true);

		if (!isset($sec_no, $indate) || $this->schema == null || $this->dba == null) {
			show_404();
		} else {
			$data = $collection->getRFT($this->schema, $this->dba, $sec_no, $indate);

			if (count($data) > 0) {
				echo json_encode($data);
			} else {
				show_404();
			}
		}
	}

	// function JQuery Defect List
	public function ajaxDefList($sec_no = null, $indate = null, $overall = null)
	{
		$collection = $this->Tra_collection_model;
		$sec_no = $this->input->post('sec_no', true);
		$indate = $this->input->post('indate', true);
		$overall = $this->input->post('overall', true);

		if (!isset($sec_no, $indate, $overall) || $this->schema == null || $this->dba == null) {
			show_404();
		} else {
			if ($overall == '1') {
				$data = $collection->getDefectList($this->schema, $this->dba, $sec_no, $indate);
			} else {
				$data = $collection->getDefectList2Hours($this->schema, $this->dba, $sec_no, $indate);
			}

			echo json_encode($data);
		}
	}

	// function JQuery Defect List Process
	public function ajaxDefListPro($sec_no = null, $indate = null, $process_no = null, $overall = null)
	{
		$collection = $this->Tra_collection_model;
		$sec_no = $this->input->post('sec_no', true);
		$indate = $this->input->post('indate', true);
		$process_no = $this->input->post('process_no', true);
		$overall = $this->input->post('overall', true);

		if (!isset($sec_no, $indate, $process_no, $overall) || $this->schema == null || $this->dba == null) {
			show_404();
		} else {
			if ($overall == '1') {
				$data = $collection->getDefectListPro($this->schema, $this->dba, $sec_no, $indate, $process_no);
			} else {
				$data = $collection->getDefectListPro2Hours($this->schema, $this->dba, $sec_no, $indate, $process_no);
			}

			echo json_encode($data);
		}
	}

	// function JQuery Defect List
	public function ajaxSugList($sec_no = null, $indate = null)
	{
		$collection = $this->Tra_collection_model;
		$sec_no = $this->input->post('sec_no', true);
		$indate = $this->input->post('indate', true);
		$overall = $this->input->post('overall', true);

		if (!isset($sec_no, $indate, $overall) || $this->schema == null || $this->dba == null) {
			show_404();
		} else {
			if ($overall == '1') {
				$data = $collection->getSuggestList($this->schema, $this->dba, $sec_no, $indate);
			} else {
				$data = $collection->getSuggestList2Hours($this->schema, $this->dba, $sec_no, $indate);
			}

			echo json_encode($data);
		}
	}

	// function JQuery Suggest List Process
	public function ajaxSugListPro($sec_no = null, $indate = null, $process_no = null)
	{
		$collection = $this->Tra_collection_model;
		$sec_no = $this->input->post('sec_no', true);
		$indate = $this->input->post('indate', true);
		$process_no = $this->input->post('process_no', true);
		$overall = $this->input->post('overall', true);

		if (!isset($sec_no, $indate, $process_no, $overall) || $this->schema == null || $this->dba == null) {
			show_404();
		} else {
			if ($overall == '1') {
				$data = $collection->getSuggestListPro($this->schema, $this->dba, $sec_no, $indate, $process_no);
			} else {
				$data = $collection->getSuggestListPro2Hours($this->schema, $this->dba, $sec_no, $indate, $process_no);
			}

			echo json_encode($data);
		}
	}

	// function add
	public function add()
	{
		$collection = $this->Tra_collection_model;
		$validation = $this->form_validation;
		$validation->set_rules($collection->rules());

		// condition if validation is ture
		if ($validation->run()) {
			// master data input
			$fact_no = $this->session->userdata('factory');
			$submit_id = 'TLS_' . $fact_no . '_' . md5(date('YmdHis.u'));
			$submit_user = $this->session->userdata('userno');;
			$submit_date = date('YmdHis');
			$sec_no = $this->input->post('sec_no', true);
			$po_no = $this->input->post('po_no', true);
			$vbeln = $this->input->post('vbeln', true);
			$process_no = $this->input->post('process_no', true);
			$check_qty = $this->input->post('check_qty', true);
			$pass_qty = $this->input->post('pass_qty', true);
			$pass_rate = $pass_qty / $check_qty * 100;
			$defect_qty = $check_qty - $pass_qty;
			$defect_rate = $defect_qty / $check_qty * 100;
			$line_type = $this->input->post('line_type', true);

			// detail data input
			$submit_seq = $this->input->post('defect_seq', true);
			$defect_no = $this->input->post('defect_no', true);
			$detail_def_qty = $this->input->post('defect_qty', true);

			// set parameters
			$master_data = array(
				'fact_no' => $fact_no,
				'submit_id' => $submit_id,
				'submit_user' => $submit_user,
				'submit_date' => $submit_date,
				'sec_no' => $sec_no,
				'po_no' => $po_no,
				'vbeln' => $vbeln,
				'process_no' => $process_no,
				'check_qty' => $check_qty,
				'pass_qty' => $pass_qty,
				'pass_rate' => $pass_rate,
				'defect_qty' => $defect_qty,
				'defect_rate' => $defect_rate,
				'line_type' => $line_type
			);

			// method to insert detail data when master data have defect QTY > 0
			if ($defect_qty > 0 && $submit_seq != null) {
				// set parameters
				$detail_data = array();
				$index = 0;

				foreach ($submit_seq as $sequence) {
					array_push($detail_data, array(
						'fact_no' => $fact_no,
						'submit_id' => $submit_id,
						'submit_seq' => $sequence,
						'defect_no' => $defect_no[$index],
						'defect_qty' => $detail_def_qty[$index],
						'defect_rate' => $detail_def_qty[$index] / $defect_qty * 100
					));

					$index++;
				}
			} else {
				$detail_data = null;
			}

			if ($detail_data != null) {
				$total_defect = array_sum(array_column($detail_data, 'defect_qty'));
			} else {
				$total_defect = 0;
			}

			// method for check defect QTY must be same
			if ($defect_qty == $total_defect) {
				// call function save in model using parameter
				$data = $collection->save($this->schema, $this->dba, $master_data, $detail_data);
				echo json_encode($data);
			} else {
				echo json_encode(false);
			}
		} else {
			show_404();
		}
	}

	// function edit
	public function edit()
	{
		// master data input
		$fact_no = $this->session->userdata('factory');
		$submit_id = $this->input->post('submit_id', true);
		$submit_user = $this->input->post('submit_user', true);
		$submit_date = $this->input->post('submit_date', true);
		$modify_user = $this->session->userdata('userno');
		$modify_date = date('YmdHis');
		$sec_no = $this->input->post('sec_no', true);
		$po_no = $this->input->post('po_no', true);
		$vbeln = $this->input->post('vbeln', true);
		$process_no = $this->input->post('process_no', true);
		$check_qty = $this->input->post('check_qty', true);
		$pass_qty = $this->input->post('pass_qty', true);
		$pass_rate = $pass_qty / $check_qty * 100;
		$defect_qty = $check_qty - $pass_qty;
		$defect_rate = $defect_qty / $check_qty * 100;
		$line_type = $this->input->post('line_type', true);

		// detail data input
		$submit_seq = $this->input->post('defect_seq', true);
		$defect_no = $this->input->post('defect_no', true);
		$detail_def_qty = $this->input->post('defect_qty', true);

		// check id variable
		if ($submit_id == null && $submit_seq == null && $defect_no == null) {
			echo json_encode(false);
		}

		$collection = $this->Tra_collection_model;
		$validation = $this->form_validation;
		$validation->set_rules($collection->rules());

		// condition if validation is true
		if ($validation->run()) {
			// set parameters
			$master_data = array(
				'fact_no' => $fact_no,
				'submit_id' => $submit_id,
				'submit_user' => $submit_user,
				'submit_date' => $submit_date,
				'modify_user' => $modify_user,
				'modify_date' => $modify_date,
				'sec_no' => $sec_no,
				'po_no' => $po_no,
				'vbeln' => $vbeln,
				'process_no' => $process_no,
				'check_qty' => $check_qty,
				'pass_qty' => $pass_qty,
				'pass_rate' => $pass_rate,
				'defect_qty' => $defect_qty,
				'defect_rate' => $defect_rate,
				'line_type' => $line_type
			);

			// method to insert detail data when master data have defect QTY > 0
			if ($defect_qty > 0 && $submit_seq != null) {
				// set parameters
				$detail_data = array();
				$index = 0;

				foreach ($submit_seq as $sequence) {
					array_push($detail_data, array(
						'fact_no' => $fact_no,
						'submit_id' => $submit_id,
						'submit_seq' => $sequence,
						'defect_no' => $defect_no[$index],
						'defect_qty' => $detail_def_qty[$index],
						'defect_rate' => $detail_def_qty[$index] / $defect_qty * 100
					));

					$index++;
				}
			} else {
				$detail_data = null;
			}

			if ($detail_data != null) {
				$total_defect = array_sum(array_column($detail_data, 'defect_qty'));
			} else {
				$total_defect = 0;
			}

			// method for check defect QTY must be same
			if ($defect_qty == $total_defect) {
				// call function update in model using parameter
				$data = $collection->update($this->schema, $this->dba, $master_data, $detail_data, $submit_id, $submit_seq, $defect_no);
				echo json_encode($data);
			} else {
				echo json_encode(false);
			}
		} else {
			show_404();
		}
	}

	// function delete
	public function delete($id = null)
	{
		if (!isset($id)) {
			show_404();
		}

		$data = $this->Tra_collection_model->delete($this->schema, $this->dba, $id);
		echo json_encode($data);
	}

	// function filter PO/SO by section/line
	public function getPOSO()
	{
		$order = $this->Tra_order_model;
		$sec_no = $this->input->post('sec_no', true);
		$data = $order->getPOSOInterval($this->schema, $this->dba, $sec_no);

		echo json_encode($data);
	}

	// function filter Process NO by section/line
	public function getPro()
	{
		$pro = $this->Tra_process_model;
		$sec_no = $this->input->post('sec_no', true);
		$data = $pro->getProLine($this->schema, $this->dba, $sec_no);

		echo json_encode($data);
	}

	// function filter Building by Area
	public function getBuild()
	{
		$build = $this->Tra_build_model;
		$area = $this->input->post('area', true);
		$data = $build->getBuilding($this->schema, $this->dba, $area);

		echo json_encode($data);
	}

	// defect list by process and line type
	public function getDefRes()
	{
		$defect = $this->Tra_defect_model;
		$line_type = $this->input->post('line_type', true);
		$process_no = $this->input->post('process_no', true);
		$data = $defect->getDefectPro($this->schema, $this->dba, $line_type, $process_no);

		echo json_encode($data);
	}

	// collection report
	public function report()
	{
		if ($this->schema == null && $this->dba == null) {
			show_404();
		}

		// $data['tra_area'] = $this->Tra_area_model->getByFactory($this->schema, $this->dba);
		// $data['tra_build'] = $this->Tra_build_model->getByFactory($this->schema, $this->dba);
		// $this->load->view('users/report/collection/report', $data);

		$this->load->view('users/report/collection/report');
	}

	// collection hourly defect report
	public function hourly()
	{
		if ($this->schema == null && $this->dba == null) {
			show_404();
		}

		// $data['tra_area'] = $this->Tra_area_model->getByFactory($this->schema, $this->dba);
		// $data['tra_build'] = $this->Tra_build_model->getByFactory($this->schema, $this->dba);
		// $this->load->view('users/report/collection/hourly', $data);

		$this->load->view('users/report/collection/hourly');
	}
}
