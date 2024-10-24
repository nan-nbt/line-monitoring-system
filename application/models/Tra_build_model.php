<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tra_build_model extends CI_Model {

    // function rules for validation
    public function rules(){
        return [
            ['field'=>'fact_no', 'label'=>'Factory', 'rules'=>'required']
        ];
    }

    // function getAll data on the table
    public function getAll($schema, $dba){
        return $dba->get($schema.'.tl_buildm')->result(); 
    }

    // function get data by factory on the table
    public function getByFactory($schema, $dba){
        $factory = $this->session->userdata('factory');
        $dba->order_by('fact_no','DESC');
        return $dba->get_where($schema.'.tl_buildm', ['fact_no' => $factory])->result(); 
    }

    // function getById data on the table
    public function getById($schema, $dba, $fact_no){
        return $dba->get_where($schema.'.tl_buildm', ['fact_no' => $fact_no])->result();
    }

    // function get building by area
    public function getBuilding($schema, $dba, $area){
        $factory = $this->session->userdata('factory');
        return $dba->get_where($schema.'.tl_buildm', ['fact_no' => $factory, 'prod_fact' => $area])->result(); 
    }
    
}