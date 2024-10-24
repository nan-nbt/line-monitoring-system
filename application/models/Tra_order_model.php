<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tra_order_model extends CI_Model
{

	// function rules for validation
	public function rules()
	{
		return [
			['field' => 'po_no', 'label' => 'PO', 'rules' => 'required']
		];
	}

	// function getAll data on the table
	public function getAll($schema, $dba)
	{
		$dba->order_by('po_no', 'DESC');
		return $dba->get($schema . 'tl_so_purdm')->result(); // SELECT * FROM TL_PO_PURDM;
	}

	// function get data by factory on the table
	public function getByFactory($schema, $dba)
	{
		$factory = $this->session->userdata('factory');
		$dba->order_by('po_no', 'DESC');
		return $dba->get_where($schema . '.tl_so_purdm', ['fact_no' => $factory])->result();
	}

	// function get PO/SO with condition not yet shipping and cancel data by sec_no on the table
	public function getPOSOSec($schema, $dba, $sec_no)
	{
		$factory = $this->session->userdata('factory');
		return $dba->get_where($schema . '.tl_so_purdm', ['fact_no' => $factory, 'cancel_date' => null, 'ship_mk' => 'N', 'sec_no' => $sec_no])->result(); // SELECT * FROM TL_PO_PURDM WHERE FACT_NO = '0228' AND CANCEL_DATE = NULL AND SHIP_MK = 'N';
	}

	// function getById data on the table
	public function getById($schema, $dba, $id)
	{
		$factory = $this->session->userdata('factory');
		return $dba->get_where($schema . '.tl_so_purdm', ['fact_no' => $factory, 'po_no' => $id])->row(); // SELECT * FROM TL_PO_PURDM WHERE FACT_NO = '0228' AND PO_NO = $ID;
	}

	// function get PO/SO with condition not yet shipping and cancel data by sec_no on the table
	public function getPOSOInterval($schema, $dba, $sec_no)
	{
		$factory = $this->session->userdata('factory');

		$sql = "SELECT DISTINCT a.po_no, a.vbeln 
					FROM $schema.tl_mps_caclhist a, $schema.tl_so_purdm b 
					WHERE a.fact_no = b.fact_no 
					AND a.po_no = b.po_no 
					AND a.vbeln = b.vbeln 
					AND a.fact_no = '$factory'
					AND a.ymd BETWEEN to_char((now() - interval '7 day'), 'YYYYMMDD') AND to_char((now() + interval '7 day'), 'YYYYMMDD') 
					AND a.chg_code <> 'D'
					AND b.sec_no = '$sec_no'
					AND b.ship_mk = 'N'
					AND b.cancel_date IS NULL
					ORDER BY a.po_no, a.vbeln";

		return $dba->query($sql)->result();
	}
}
