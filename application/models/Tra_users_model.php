<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tra_users_model extends CI_Model
{

	// function rules for validation
	public function rules()
	{
		return [
			['field' => 'fact_no', 'label' => 'Factory', 'rules' => 'required'],
			['field' => 'user_no', 'label' => 'User NO', 'rules' => 'required']
		];
	}

	// function getAll data on the table
	public function getAll($schema, $dba)
	{
		return $dba->get($schema . '.tl_users')->result();
	}

	// function get data by factory on the table
	public function getByFactory($schema, $dba)
	{
		$factory = $this->session->userdata('factory');
		return $dba->get_where($schema . '.tl_users', ['fact_no' => $factory])->result();
	}

	// function getById data on the table
	public function getById($schema, $dba, $fact_no, $user_no)
	{
		return $dba->get_where($schema . '.tl_users', ['fact_no' => $fact_no, 'user_no' => $user_no])->result();
	}

	// function getByPCCUID data on the table
	public function getByPCCUID($schema, $dba, $fact_no, $pccuid)
	{
		return $dba->get_where($schema . '.tl_users', ['fact_no' => $fact_no, 'pcc_id' => $pccuid])->result();
	}

	// function update last login time
	public function updateLoginTime($schema, $dba, $user_no)
	{
		$factory = $this->session->userdata('factory');
		$login_time = date('YmdHis');

		if (!isset($user_no)) {
			show_404();
		}

		$sql = "UPDATE $schema.tl_users SET l_login_time = '$login_time' WHERE fact_no = '$factory' AND user_no = '$user_no'";
		$dba->query($sql);
	}
}
