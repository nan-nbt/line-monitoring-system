<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tra_factory_model extends CI_Model {

    // function rules for validation
    public function rules(){
        return [
            ['field'=>'fact_no', 'label'=>'Factory', 'rules'=>'required']
        ];
    }

    // function getAll data on the table
    public function getAll($schema, $dba){
        return $dba->get($schema.'.tl_factory')->result(); 
    }

    // function get data by factory on the table
    public function getByFactory($schema, $dba){
        $factory = $this->session->userdata('factory');
        $dba->order_by('fact_no','DESC');
        return $dba->get_where($schema.'.tl_factory', ['fact_no' => $factory])->result(); 
    }

    // function getById data on the table
    public function getById($schema, $dba, $fact_no){
        return $dba->get_where($schema.'.tl_factory', ['fact_no' => $fact_no])->result();
    }

}