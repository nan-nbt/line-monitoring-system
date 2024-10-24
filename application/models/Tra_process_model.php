<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tra_process_model extends CI_Model {

    // function rules for validation
    public function rules(){
        return [
            ['field'=>'process_no', 'label'=>'Porcess No', 'rules'=>'required'],
            ['field'=>'line_type', 'label'=>'Line Type', 'rules'=>'required']
        ];
    }

    // function getAll data on the table
    public function getAll($schema, $dba){
        $dba->order_by('process_no','DESC');
        return $dba->get($schema.'.tl_process')->result();
    }

    // function get data by factory on the table
    public function getByFactory($schema, $dba){
        $factory = $this->session->userdata('factory');
        $dba->order_by('process_no','DESC');
        return $dba->get_where($schema.'.tl_process', ['fact_no' => $factory])->result();
    }

    // function getById data on the table
    public function getById($schema, $dba, $process_no, $line_type){
        $factory = $this->session->userdata('factory');
        return $dba->get_where($schema.'.tl_process', ['fact_no' => $factory, 'process_no' => $process_no, 'line_type' => $line_type])->row(); 
    }

    // function save
    public function save($schema, $dba){
        $post = $this->input->post(); 

        $factory = $this->session->userdata('factory');

        $this->fact_no = $factory; 
        $this->process_no = $post['process_no'];  
        $this->process_name = $post['process_name']; 
        $this->line_type = $post['line_type']; 
        $this->stop_mk = $post['stop_mk']; 

        return $dba->insert($schema.'.tl_process', $this); 
    }    

    // function update
    public function update($schema, $dba){
        $post = $this->input->post(); 
        $factory = $this->session->userdata('factory');

        $this->fact_no = $factory; 
        $this->process_no = $post['process_no'];  
        $this->process_name = $post['process_name']; 
        $this->line_type = $post['line_type']; 
        $this->stop_mk = $post['stop_mk']; 

        return $dba->update($schema.'.tl_process', $this, array('fact_no' => $factory, 'process_no' => $post['process_no'], 'line_type' => $post['line_type'])); 
    }

    // funtion delete
    public function delete($schema, $dba, $process_no, $line_type){
        $dba->where('process_no', $process_no);
        $dba->where('line_type', $line_type);
        $factory = $this->session->userdata('factory');
        $res = $dba->count_all_results($schema.'.tl_data_collection');

        if($res > 0) {
            return $dba->select($schema.'.tl_process', array('fact_no' => $factory, 'process_no' => $process_no, 'line_type' => $line_type)); 
        } else {
            return $dba->delete($schema.'.tl_process', array('fact_no' => $factory, 'process_no' => $process_no, 'line_type' => $line_type));  
        }
    }

    // function to check used data 
    public function check_delete($schema, $dba, $process_no, $line_type){
        $dba->where('process_no', $process_no);
        $dba->where('line_type', $line_type);
        $res = $dba->count_all_results($schema.'.tl_data_collection');
        return $res;
    }

    // function get process by line/section
    public function getProLine($schema, $dba, $sec_no){
        $factory = $this->session->userdata('factory');

        $sql = "SELECT p.* 
                FROM $schema.tl_sec s, $schema.tl_process p 
                WHERE s.fact_no = p.fact_no
                AND s.line_type = p.line_type 
                AND s.fact_no = '$factory' 
                AND s.sec_no = '$sec_no'
                AND p.stop_mk = 'N'
                ORDER BY p.process_no ASC";
        return $dba->query($sql)->result();
    }
}