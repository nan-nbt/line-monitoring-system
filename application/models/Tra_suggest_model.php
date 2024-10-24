<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tra_suggest_model extends CI_Model {

    // function rules for validation
    public function rules(){
        return [
            ['field'=>'fact_no', 'label'=>'Factory', 'rules'=>'required']
        ];
    }

    // function getAll data on the table
    public function getAll($schema, $dba){
        return $dba->get($schema.'.tl_suggest_list')->result(); 
    }

    // function get data by factory on the table
    public function getByFactory($schema, $dba){
        $factory = $this->session->userdata('factory');
        $dba->order_by('suggest_no','DESC');
        return $dba->get_where($schema.'.tl_suggest_list', ['fact_no' => $factory])->result(); 
    }

    // function getById data on the table
    public function getById($schema, $dba, $fact_no){
        return $dba->get_where($schema.'.tl_suggest_list', ['fact_no' => $fact_no])->result();
    }

    // function get defect list by process and line type
    public function getSuggestPro($schema, $dba, $line_type, $process_no){
        $factory = $this->session->userdata('factory');
        return $dba->get_where($schema.'.tl_suggest_list', ['fact_no' => $factory, 'line_type' => $line_type, 'process_no' => $process_no, 'stop_mk' => 'N'])->result();
    }
}