<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tra_area_model extends CI_Model
{

	// function rules for validation
	public function rules()
	{
		return [
			['field' => 'fact_no', 'label' => 'Factory', 'rules' => 'required']
		];
	}

	// function getAll data on the table
	public function getAll($schema, $dba)
	{
		return $dba->get($schema . '.tl_prod_factm')->result();
	}

	// function get data by factory on the table
	public function getByFactory($schema, $dba)
	{
		$factory = $this->session->userdata('factory');
		$dba->order_by('fact_no', 'DESC');
		return $dba->get_where($schema . '.tl_prod_factm', ['fact_no' => $factory])->result();
	}

	// function getById data on the table
	public function getById($schema, $dba, $fact_no)
	{
		return $dba->get_where($schema . '.tl_prod_factm', ['fact_no' => $fact_no])->result();
	}

	// function getdata by factory on the table
	public function getActiveArea($schema, $dba)
	{
		$factory = $this->session->userdata('factory');
		$dba->order_by('sort_seq, prod_fact', 'ASC');
		return $dba->get_where($schema . '.tl_prod_factm', ['fact_no' => $factory, 'stop_mk' => 'N'])->result();
	}
}
