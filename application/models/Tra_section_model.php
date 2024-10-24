<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tra_section_model extends CI_Model
{

	// function rules for validation
	public function rules()
	{
		return [
			['field' => 'sec_no', 'label' => 'Section No', 'rules' => 'required']
		];
	}

	// function getAll data on the table
	public function getAll($schema, $dba)
	{
		$dba->order_by('web_seq, dept_no', 'DESC');
		return $dba->get($schema . '.tl_sec')->result();
	}

	// function getdata by factory on the table
	public function getByFactory($schema, $dba)
	{
		$factory = $this->session->userdata('factory');
		$dba->order_by('web_seq, dept_no', 'DESC');
		return $dba->get_where($schema . '.tl_sec', ['fact_no' => $factory])->result();
	}

	// function getdata by factory on the table
	public function getActiveSection($schema, $dba)
	{
		$factory = $this->session->userdata('factory');
		$dba->order_by('web_seq, dept_no', 'DESC');
		return $dba->get_where($schema . '.tl_sec', ['fact_no' => $factory, 'stop_mk' => 'N'])->result();
	}

	// function getdata by date on the table
	public function getSectionDate($schema, $dba, $indate)
	{
		$factory = $this->session->userdata('factory');

		$sql = "SELECT DISTINCT ts.* FROM $schema.tl_sec ts, $schema.tl_data_collection tdc 
					WHERE ts.fact_no = tdc.fact_no 
					AND ts.sec_no = tdc.sec_no 
					AND ts.stop_mk = 'N'
					AND ts.fact_no = '$factory'
					AND substr(tdc.submit_date,1,8) = '$indate'
					ORDER BY ts.web_seq DESC";

		return $dba->query($sql)->result();
	}

	// function getById data on the table
	public function getById($schema, $dba, $id)
	{
		$factory = $this->session->userdata('factory');
		return $dba->get_where($schema . '.tl_sec', ['fact_no' => $factory, 'sec_no' => $id])->row();
	}

	// function save
	public function save($schema, $dba)
	{
		$post = $this->input->post();
		$factory = $this->session->userdata('factory');

		$this->fact_no = $factory;
		$this->sec_no = $post['sec_no'];
		$this->sec_name = $post['sec_name'];
		$this->dept_no = $post['dept_no'];
		$this->web_seq = $post['web_seq'];
		$this->build_no = $post['build_no'];
		$this->sec_sname = $post['sec_scname'];
		$this->stop_mk = $post['stop_mk'];
		$this->fee_fact = $post['fee_fact'];
		$this->arbpl = $post['arbpl'];

		return $dba->insert($schema . '.tl_sec', $this);
	}

	// function update
	public function update($schema, $dba)
	{
		$post = $this->input->post();
		$factory = $this->session->userdata('factory');

		$this->fact_no = $factory;
		$this->sec_no = ['sec_no'];
		$this->sec_name = $post['sec_name'];
		$this->dept_no = $post['dept_no'];
		$this->web_seq = $post['web_seq'];
		$this->build_no = $post['build_no'];
		$this->sec_sname = $post['sec_scname'];
		$this->stop_mk = $post['stop_mk'];
		$this->fee_fact = $post['fee_fact'];
		$this->arbpl = $post['arbpl'];

		return $dba->update($schema . '.tl_sec', $this, array('fact_no' => $factory, 'sec_no' => $post['sec_no']));
	}

	// function update line type
	public function updateLineType($schema, $dba, $sec_no, $line)
	{
		if (!isset($sec_no) && !isset($line)) {
			show_404();
		}

		$factory = $this->session->userdata('factory');

		$sql = "UPDATE $schema.tl_sec SET line_type = '$line' WHERE fact_no = '$factory' AND sec_no = '$sec_no'";
		return $dba->query($sql);
	}

	// funtion delete
	public function delete($schema, $dba, $id)
	{
		$factory = $this->session->userdata('factory');
		return $dba->delete($schema . '.tl_sec', array('fact_no' => $factory, 'sec_no' => $id));
	}
}
