<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Tra_collection_model extends CI_Model {

    // function rules for validation
    public function rules(){
        return [
            ['field'=>'sec_no', 'label'=>'Section/Line', 'rules'=>'required'],
            ['field'=>'po_no', 'label'=>'PO', 'rules'=>'required'],
            ['field'=>'vbeln', 'label'=>'SO', 'rules'=>'required'],
            ['field'=>'process_no', 'label'=>'Process', 'rules'=>'required'],
            ['field'=>'check_qty', 'label'=>'Check QTY', 'rules'=>'required'],
            ['field'=>'pass_qty', 'label'=>'Pass QTY', 'rules'=>'required']
        ];
    }

    // function getAll data on the table
    public function getAll($schema, $dba){
        $dba->order_by('submit_date','DESC');
        return $dba->get($schema.'.tl_data_collection')->result(); 
    }

    // function get data by factory on the table
    public function getByFactory($schema, $dba){
        $factory = $this->session->userdata('factory');
        $dba->order_by('submit_date','DESC');
        return $dba->get_where($schema.'.tl_data_collection', ['fact_no' => $factory])->result(); 
    }

    // function get data by factory on the table
    public function getByFactoryColDet($schema, $dba){
        $factory = $this->session->userdata('factory');

        $sql = "SELECT a.*, b.submit_seq, b.defect_no, b.defect_qty det_def_qty, b.defect_rate det_def_rate 
                    FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b
                    WHERE a.fact_no = b.fact_no
                    AND a.submit_id = b.submit_id
                    AND a.fact_no = '$factory'
                    ORDER BY a.submit_date DESC";

        return $dba->query($sql)->result();
    }

    // function getById data on the table
    public function getById($schema, $dba, $id){
        $factory = $this->session->userdata('factory');
        return $dba->get_where($schema.'.tl_data_collection', ['fact_no' => $factory, 'submit_id' => $id])->row(); 
    }

    // function get data collection by sec_no AND date
    public function getCollection($schema, $dba, $sec_no, $datestart, $dateend){
        // get numeric value only
        $datestart = preg_replace("/[^0-9]/","",$datestart); 
        $dateend = preg_replace("/[^0-9]/","",$dateend); 
        
        $factory = $this->session->userdata('factory');
        
        $dba->where('fact_no', $factory);
        $dba->like('sec_no', $sec_no);
        $dba->where('substr(submit_date,1,8) >=', $datestart);
        $dba->where('substr(submit_date,1,8) <=', $dateend);
        $dba->order_by('submit_date','DESC');
        return $dba->get($schema.'.tl_data_collection')->result();
    }

    // function get detail data collection by sec_no AND date
    public function getDetailCollection($schema, $dba, $submit_id){        
        $factory = $this->session->userdata('factory');
        
        $sql = "SELECT DISTINCT b.*, c.defect_name 
                    FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b, $schema.tl_defect_list c
                    WHERE a.fact_no = b.fact_no 
                    AND a.fact_no = c.fact_no 
                    AND a.submit_id = b.submit_id
                    AND b.defect_no = c.defect_no 
                    AND b.fact_no = '$factory' 
                    AND a.submit_id = '$submit_id'
                    -- AND b.defect_qty <> 0
                    ORDER BY b.submit_seq";

        return $dba->query($sql)->result();
    }

    // function get data collection by area AND building
    public function getReportCollect($schema, $dba, $area, $build, $datestart, $dateend){        
        // get numeric value only
        $datestart = preg_replace("/[^0-9]/","",$datestart); 
        $dateend = preg_replace("/[^0-9]/","",$dateend); 

        $factory = $this->session->userdata('factory');
        
        $sql = "SELECT sc.area_no, sc.area_nm, sc.build_no, sc.build_nm, sc.sec_no, sc.sec_nm, sc.sum_check_qty, sc.sum_pass_qty, sc.sum_defect_qty, 
                    (SELECT sum(sum_defect_qty) total_defect_qty 
                        FROM (SELECT sc.area_no, sc.area_nm, sc.build_no, sc.build_nm, sc.sec_no, sc.sec_nm, sc.sum_check_qty, sc.sum_pass_qty, sc.sum_defect_qty, 
                                sum(sc.sum_pass_qty/sc.sum_check_qty*100) sum_pass_rate
                                FROM (SELECT d.prod_fact area_no, d.prod_fact_nm area_nm, c.build_no build_no, c.build_eng_nm build_nm, b.sec_no sec_no, b.sec_name sec_nm,
                                        sum(a.check_qty) sum_check_qty, sum(a.pass_qty) sum_pass_qty, sum(a.defect_qty) sum_defect_qty
                                        FROM $schema.tl_data_collection a, $schema.tl_sec b, $schema.tl_buildm c, $schema.tl_prod_factm d
                                        WHERE a.fact_no = b.fact_no
                                        AND a.fact_no = c.fact_no
                                        AND a.fact_no = d.fact_no
                                        AND a.sec_no = b.sec_no
                                        AND b.build_no = c.build_no
                                        AND c.prod_fact = d.prod_fact
                                        AND substr(a.submit_date,1,8) >= '$datestart' 
                                        AND substr(a.submit_date,1,8) <= '$dateend' 
                                        AND c.prod_fact LIKE '%$area%'
                                        AND b.build_no LIKE '%$build%'
                                        GROUP BY d.prod_fact, d.prod_fact_nm, c.build_no, c.build_eng_nm, b.sec_no, b.sec_name) sc
                                GROUP BY sc.area_no, sc.area_nm, sc.build_no, sc.build_nm, sc.sec_no, sc.sec_nm, sc.sum_check_qty, sc.sum_pass_qty, sc.sum_defect_qty) td
                    ) total_defect_qty
                FROM (SELECT d.prod_fact area_no, d.prod_fact_nm area_nm, c.build_no build_no, c.build_eng_nm build_nm, b.sec_no sec_no, b.sec_name sec_nm,
                        sum(a.check_qty) sum_check_qty, sum(a.pass_qty) sum_pass_qty, sum(a.defect_qty) sum_defect_qty
                        FROM $schema.tl_data_collection a, $schema.tl_sec b, $schema.tl_buildm c, $schema.tl_prod_factm d
                        WHERE a.fact_no = b.fact_no
                        AND a.fact_no = c.fact_no
                        AND a.fact_no = d.fact_no
                        AND a.sec_no = b.sec_no
                        AND b.build_no = c.build_no
                        AND c.prod_fact = d.prod_fact
                        AND substr(a.submit_date,1,8) >= '$datestart' 
                        AND substr(a.submit_date,1,8) <= '$dateend' 
                        AND c.prod_fact LIKE '%$area%'
                        AND b.build_no LIKE '%$build%'
                        GROUP BY d.prod_fact, d.prod_fact_nm, c.build_no, c.build_eng_nm, b.sec_no, b.sec_name) sc
                GROUP BY sc.area_no, sc.area_nm, sc.build_no, sc.build_nm, sc.sec_no, sc.sec_nm, sc.sum_check_qty, sc.sum_pass_qty, sc.sum_defect_qty
                ORDER BY sc.area_no, sc.build_no";

        return $dba->query($sql)->result();
    }

    // function get data collection report hourly defect
    public function getHourlyDefect($schema, $dba, $area, $build, $datestart){        
        // get numeric value only
        $datestart = preg_replace("/[^0-9]/","",$datestart); 

        $factory = $this->session->userdata('factory');
        
        $sql = "SELECT  d.prod_fact, d.prod_fact_nm, c.build_no, c.build_eng_nm, b.sec_no, b.sec_name,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '0000' AND '0629' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_1,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '0630' AND '0729' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_2,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '0730' AND '0829' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_3,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '0830' AND '0929' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_4,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '0930' AND '1029' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_5,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '1030' AND '1129' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_6,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '1130' AND '1229' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_7,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '1230' AND '1329' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_8,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '1330' AND '1429' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_9,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '1430' AND '1529' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_10,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '1530' AND '1629' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_11,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '1630' AND '1729' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_12,
                        sum(CASE WHEN substring(a.submit_date,9,4) BETWEEN '1730' AND '2329' THEN coalesce(a.defect_qty,0) ELSE 0 END) time_13,
                        sum(a.check_qty) check_qty,
                        sum(a.pass_qty) pass_qty,
                        sum(a.defect_qty) defect_qty	   
                FROM $schema.tl_data_collection a, $schema.tl_sec b, $schema.tl_buildm c, $schema.tl_prod_factm d
                WHERE a.fact_no = b.fact_no AND a.sec_no = b.sec_no 
                AND b.fact_no = c.fact_no AND b.build_no = c.build_no 
                AND c.fact_no = d.fact_no AND c.prod_fact = d.prod_fact 
                AND substring(a.submit_date,1,8) = '$datestart' 
                AND c.prod_fact LIKE '%$area%'
                AND b.build_no LIKE '%$build%'
                GROUP BY d.prod_fact, d.prod_fact_nm, c.build_no, c.build_eng_nm, b.sec_no, b.sec_name";

        return $dba->query($sql)->result();
    }    

    // function get visual display data
    public function getVisual($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');

        $sql = "SELECT sc.sec_name a, sc.line_type b, substr(sc.process_no,2,1) c, sum(sc.a) d, sum(sc.b) e, sum(sc.c) f
                FROM (
                        SELECT DISTINCT z.sec_name, z.line_type, x.process_no, sum(x.check_qty) a, sum(x.pass_qty) b, sum(x.defect_qty) c 
                        FROM $schema.tl_data_collection x, $schema.tl_sec z 
                        WHERE x.fact_no = z.fact_no
                        AND x.sec_no = z.sec_no 
                        AND x.fact_no = '$factory' 
                        AND x.sec_no = '$sec_no' 
                        AND substr(submit_date,1,8) = '$indate' 
                        GROUP BY z.sec_name, z.line_type, x.process_no
                      ) sc
                GROUP BY sc.sec_name, sc.line_type, substr(sc.process_no,2,1)";

        return $dba->query($sql)->result();
    }

    // function get visual display data between current time and current time - 2 hour
    public function getVisual2Hours($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');

        $sql = "SELECT sc.sec_name a, sc.line_type b, substr(sc.process_no,2,1) c, sum(sc.a) d, sum(sc.b) e, sum(sc.c) f
                FROM (
                        SELECT DISTINCT z.sec_name, z.line_type, x.process_no, sum(x.check_qty) a, sum(x.pass_qty) b, sum(x.defect_qty) c 
                        FROM $schema.tl_data_collection x, $schema.tl_sec z 
                        WHERE x.fact_no = z.fact_no
                        AND x.sec_no = z.sec_no 
                        AND x.fact_no = '$factory' 
                        AND x.sec_no = '$sec_no' 
                        AND substr(submit_date,1,8) = '$indate' 
						AND substr(submit_date,9,6) BETWEEN coalesce(to_char(current_timestamp - interval '2 hour', 'HH24MISS'), '') AND coalesce(to_char(current_timestamp, 'HH24MISS'), '')
                        GROUP BY z.sec_name, z.line_type, x.process_no
                      ) sc
                GROUP BY sc.sec_name, sc.line_type, substr(sc.process_no,2,1)";

        return $dba->query($sql)->result();
    }

    // function get defect by process AND date display data
    public function getDetail($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');

        $sql = "SELECT DISTINCT	b.sec_no sec_no, b.sec_name sec_name, b.line_type line_type, b.process process, b.process_no process_no, b.process_name process_name,
                        a.total_check_qty total_check_qty, a.total_pass_qty total_pass_qty, a.total_defect_qty total_defect_qty, a.submit_date submit_date
                FROM (
                        SELECT 	sc.sec_no sec_no, sc.sec_name sec_name, sc.line_type line_type, substr(sc.process_no,2,1) process, sum(sc.sum_check_qty) total_check_qty, 
                                sum(sc.sum_pass_qty) total_pass_qty, sum(sc.sum_defect_qty) total_defect_qty, sc.submit_date submit_date
                        FROM (
                                SELECT DISTINCT x.sec_no sec_no, z.sec_name sec_name, z.line_type line_type, x.process_no process_no, 
                                        sum(x.check_qty) sum_check_qty, sum(x.pass_qty) sum_pass_qty, sum(x.defect_qty) sum_defect_qty, 
                                        substr(x.submit_date,1,8) submit_date
                                FROM $schema.tl_data_collection x, $schema.tl_sec z 
                                WHERE x.fact_no = z.fact_no
                                AND x.sec_no = z.sec_no 
                                AND x.fact_no = '$factory' 
                                AND x.sec_no = '$sec_no' 
                                AND substr(submit_date,1,8) = '$indate' 
                                GROUP BY x.sec_no, z.sec_name, z.line_type, x.process_no, substr(x.submit_date,1,8)
                            ) sc
                        GROUP BY sc.sec_no, sc.sec_name, sc.line_type, substr(sc.process_no,2,1), sc.submit_date
                    ) a,
                    (	
                        SELECT DISTINCT	sc.sec_no sec_no, sc.sec_name sec_name, sc.line_type line_type, substr(sc.process_no,2,1) process, 
                                    sc.process_no process_no, sc.process_name process_name
                        FROM (
                                SELECT DISTINCT x.sec_no sec_no, z.sec_name sec_name, z.line_type line_type, x.process_no process_no, y.process_name process_name
                                FROM $schema.tl_data_collection x, $schema.tl_process y, $schema.tl_sec z
                                WHERE x.fact_no = z.fact_no
                                AND z.fact_no = y.fact_no 
                                AND z.line_type = y.line_type 
                                AND x.process_no = y.process_no 
                                AND x.sec_no = z.sec_no 
                                AND x.fact_no = '$factory' 
                                AND x.sec_no = '$sec_no' 
                                AND substr(submit_date,1,8) = '$indate' 
                                GROUP BY x.sec_no, z.sec_name, z.line_type, x.process_no, substr(x.submit_date,1,8), y.process_name 
                            ) sc
                    ) b
                WHERE a.line_type = b.line_type
                AND a.process = b.process";

        return $dba->query($sql)->result();
    }

    // function get defect by process AND date display data (interval last 2 hours)
    public function getDetail2Hours($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');

        $sql = "SELECT DISTINCT	b.sec_no sec_no, b.sec_name sec_name, b.line_type line_type, b.process process, b.process_no process_no, b.process_name process_name,
                        a.total_check_qty total_check_qty, a.total_pass_qty total_pass_qty, a.total_defect_qty total_defect_qty, a.submit_date submit_date
                FROM (
                        SELECT 	sc.sec_no sec_no, sc.sec_name sec_name, sc.line_type line_type, substr(sc.process_no,2,1) process, sum(sc.sum_check_qty) total_check_qty, 
                                sum(sc.sum_pass_qty) total_pass_qty, sum(sc.sum_defect_qty) total_defect_qty, sc.submit_date submit_date
                        FROM (
                                SELECT DISTINCT x.sec_no sec_no, z.sec_name sec_name, z.line_type line_type, x.process_no process_no, 
                                        sum(x.check_qty) sum_check_qty, sum(x.pass_qty) sum_pass_qty, sum(x.defect_qty) sum_defect_qty, 
                                        substr(x.submit_date,1,8) submit_date
                                FROM $schema.tl_data_collection x, $schema.tl_sec z 
                                WHERE x.fact_no = z.fact_no
                                AND x.sec_no = z.sec_no 
                                AND x.fact_no = '$factory' 
                                AND x.sec_no = '$sec_no' 
                                AND substr(submit_date,1,8) = '$indate' 
								AND substr(submit_date,9,6) BETWEEN coalesce(to_char(current_timestamp - interval '2 hour', 'HH24MISS'), '') AND coalesce(to_char(current_timestamp, 'HH24MISS'), '')
                                GROUP BY x.sec_no, z.sec_name, z.line_type, x.process_no, substr(x.submit_date,1,8)
                            ) sc
                        GROUP BY sc.sec_no, sc.sec_name, sc.line_type, substr(sc.process_no,2,1), sc.submit_date
                    ) a,
                    (	
                        SELECT DISTINCT	sc.sec_no sec_no, sc.sec_name sec_name, sc.line_type line_type, substr(sc.process_no,2,1) process, 
                                    sc.process_no process_no, sc.process_name process_name
                        FROM (
                                SELECT DISTINCT x.sec_no sec_no, z.sec_name sec_name, z.line_type line_type, x.process_no process_no, y.process_name process_name
                                FROM $schema.tl_data_collection x, $schema.tl_process y, $schema.tl_sec z
                                WHERE x.fact_no = z.fact_no
                                AND z.fact_no = y.fact_no 
                                AND z.line_type = y.line_type 
                                AND x.process_no = y.process_no 
                                AND x.sec_no = z.sec_no 
                                AND x.fact_no = '$factory' 
                                AND x.sec_no = '$sec_no' 
                                AND substr(submit_date,1,8) = '$indate' 
								AND substr(submit_date,9,6) BETWEEN coalesce(to_char(current_timestamp - interval '2 hour', 'HH24MISS'), '') AND coalesce(to_char(current_timestamp, 'HH24MISS'), '')
                                GROUP BY x.sec_no, z.sec_name, z.line_type, x.process_no, substr(x.submit_date,1,8), y.process_name 
                            ) sc
                    ) b
                WHERE a.line_type = b.line_type
                AND a.process = b.process";

        return $dba->query($sql)->result();
    }

    // function get sum(defect) by date display data
    public function getMostDef($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');

        $sql = "SELECT DISTINCT substr(x.process_no,2,1) process, sum(x.defect_qty) sum_defect_qty,
                    (SELECT DISTINCT sum(x.defect_qty) total_defect_qty 
                        FROM $schema.tl_data_collection x, $schema.tl_sec z 
                        WHERE x.fact_no = z.fact_no
                        AND x.sec_no = z.sec_no 
                        AND x.fact_no = '$factory' 
                        AND x.sec_no = '$sec_no' 
                        AND substr(submit_date,1,8) = '$indate') total_defect_qty
                FROM $schema.tl_data_collection x, $schema.tl_sec z 
                WHERE x.fact_no = z.fact_no
                AND x.sec_no = z.sec_no 
                AND x.fact_no = '$factory' 
                AND x.sec_no = '$sec_no' 
                AND substr(submit_date,1,8) = '$indate'
                GROUP BY substr(x.process_no,2,1)";

        return $dba->query($sql)->result();
    }

    // function get sum(defect) by date display data (interval last 2 hours)
    public function getMostDef2Hours($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');

        $sql = "SELECT DISTINCT substr(x.process_no,2,1) process, sum(x.defect_qty) sum_defect_qty,
                    (SELECT DISTINCT sum(x.defect_qty) total_defect_qty 
                        FROM $schema.tl_data_collection x, $schema.tl_sec z 
                        WHERE x.fact_no = z.fact_no
                        AND x.sec_no = z.sec_no 
                        AND x.fact_no = '$factory' 
                        AND x.sec_no = '$sec_no' 
                        AND substr(submit_date,1,8) = '$indate') total_defect_qty
                FROM $schema.tl_data_collection x, $schema.tl_sec z 
                WHERE x.fact_no = z.fact_no
                AND x.sec_no = z.sec_no 
                AND x.fact_no = '$factory' 
                AND x.sec_no = '$sec_no' 
                AND substr(submit_date,1,8) = '$indate'
				AND substr(submit_date,9,6) BETWEEN coalesce(to_char(current_timestamp - interval '2 hour', 'HH24MISS'), '') AND coalesce(to_char(current_timestamp, 'HH24MISS'), '')
                GROUP BY substr(x.process_no,2,1)";

        return $dba->query($sql)->result();
    }

    // get visual by current month AND date
    public function getRFT($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 
        // $datestart = date('Ym').'01';
        $datestart = substr($indate,0,6).'01';

        $factory = $this->session->userdata('factory');

        // $sql = "SELECT  sc.sec_name sec_name, sc.line_type line_type, sc.submit_date submit_date, 
        //                 sum(sc.sum_check_qty) total_check_qty, sum(sc.sum_pass_qty) total_pass_qty 
        // FROM (
        //         SELECT DISTINCT z.sec_name sec_name, z.line_type line_type, substr(x.submit_date,7,2) submit_date, 
        //                         sum(x.check_qty) sum_check_qty, sum(x.pass_qty) sum_pass_qty 
        //         FROM $schema.tl_data_collection x, $schema.tl_sec z 
        //         WHERE x.fact_no = z.fact_no
        //         AND x.sec_no = z.sec_no 
        //         AND x.fact_no = '$factory' 
        //         AND x.sec_no = '$sec_no'
        //         AND substr(submit_date,1,8) >= '$datestart' 
        //         AND substr(submit_date,1,8) <= '$indate' 
        //         GROUP BY z.sec_name, z.line_type, substr(x.submit_date,7,2)
        //       ) sc
        // GROUP BY sc.sec_name, sc.line_type, sc.submit_date";

        $sql = "SELECT  sc.sec_name sec_name, sc.line_type line_type, 
                        sum(CASE WHEN sc.submit_date = '01' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate1,
                        sum(CASE WHEN sc.submit_date = '02' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate2,
                        sum(CASE WHEN sc.submit_date = '03' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate3,
                        sum(CASE WHEN sc.submit_date = '04' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate4,
                        sum(CASE WHEN sc.submit_date = '05' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate5,
                        sum(CASE WHEN sc.submit_date = '06' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate6,
                        sum(CASE WHEN sc.submit_date = '07' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate7,
                        sum(CASE WHEN sc.submit_date = '08' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate8,
                        sum(CASE WHEN sc.submit_date = '09' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate9,
                        sum(CASE WHEN sc.submit_date = '10' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate10,
                        sum(CASE WHEN sc.submit_date = '11' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate11,
                        sum(CASE WHEN sc.submit_date = '12' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate12,
                        sum(CASE WHEN sc.submit_date = '13' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate13,
                        sum(CASE WHEN sc.submit_date = '14' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate14,
                        sum(CASE WHEN sc.submit_date = '15' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate15,
                        sum(CASE WHEN sc.submit_date = '16' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate16,
                        sum(CASE WHEN sc.submit_date = '17' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate17,
                        sum(CASE WHEN sc.submit_date = '18' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate18,
                        sum(CASE WHEN sc.submit_date = '19' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate19,
                        sum(CASE WHEN sc.submit_date = '20' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate20,
                        sum(CASE WHEN sc.submit_date = '21' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate21,
                        sum(CASE WHEN sc.submit_date = '22' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate22,
                        sum(CASE WHEN sc.submit_date = '23' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate23,
                        sum(CASE WHEN sc.submit_date = '24' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate24,
                        sum(CASE WHEN sc.submit_date = '25' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate25,
                        sum(CASE WHEN sc.submit_date = '26' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate26,
                        sum(CASE WHEN sc.submit_date = '27' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate27,
                        sum(CASE WHEN sc.submit_date = '28' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate28,
                        sum(CASE WHEN sc.submit_date = '29' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate29,
                        sum(CASE WHEN sc.submit_date = '30' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate30,
                        sum(CASE WHEN sc.submit_date = '31' THEN coalesce(sc.pass_rate,0) ELSE 0 END) pass_rate31,
                        sum(case when sc.submit_date = '01' then coalesce(sc.defect_rate,0) else 0 end) defect_rate1,
                        sum(case when sc.submit_date = '02' then coalesce(sc.defect_rate,0) else 0 end) defect_rate2,
                        sum(case when sc.submit_date = '03' then coalesce(sc.defect_rate,0) else 0 end) defect_rate3,
                        sum(case when sc.submit_date = '04' then coalesce(sc.defect_rate,0) else 0 end) defect_rate4,
                        sum(case when sc.submit_date = '05' then coalesce(sc.defect_rate,0) else 0 end) defect_rate5,
                        sum(case when sc.submit_date = '06' then coalesce(sc.defect_rate,0) else 0 end) defect_rate6,
                        sum(case when sc.submit_date = '07' then coalesce(sc.defect_rate,0) else 0 end) defect_rate7,
                        sum(case when sc.submit_date = '08' then coalesce(sc.defect_rate,0) else 0 end) defect_rate8,
                        sum(case when sc.submit_date = '09' then coalesce(sc.defect_rate,0) else 0 end) defect_rate9,
                        sum(case when sc.submit_date = '10' then coalesce(sc.defect_rate,0) else 0 end) defect_rate10,
                        sum(case when sc.submit_date = '11' then coalesce(sc.defect_rate,0) else 0 end) defect_rate11,
                        sum(case when sc.submit_date = '12' then coalesce(sc.defect_rate,0) else 0 end) defect_rate12,
                        sum(case when sc.submit_date = '13' then coalesce(sc.defect_rate,0) else 0 end) defect_rate13,
                        sum(case when sc.submit_date = '14' then coalesce(sc.defect_rate,0) else 0 end) defect_rate14,
                        sum(case when sc.submit_date = '15' then coalesce(sc.defect_rate,0) else 0 end) defect_rate15,
                        sum(case when sc.submit_date = '16' then coalesce(sc.defect_rate,0) else 0 end) defect_rate16,
                        sum(case when sc.submit_date = '17' then coalesce(sc.defect_rate,0) else 0 end) defect_rate17,
                        sum(case when sc.submit_date = '18' then coalesce(sc.defect_rate,0) else 0 end) defect_rate18,
                        sum(case when sc.submit_date = '19' then coalesce(sc.defect_rate,0) else 0 end) defect_rate19,
                        sum(case when sc.submit_date = '20' then coalesce(sc.defect_rate,0) else 0 end) defect_rate20,
                        sum(case when sc.submit_date = '21' then coalesce(sc.defect_rate,0) else 0 end) defect_rate21,
                        sum(case when sc.submit_date = '22' then coalesce(sc.defect_rate,0) else 0 end) defect_rate22,
                        sum(case when sc.submit_date = '23' then coalesce(sc.defect_rate,0) else 0 end) defect_rate23,
                        sum(case when sc.submit_date = '24' then coalesce(sc.defect_rate,0) else 0 end) defect_rate24,
                        sum(case when sc.submit_date = '25' then coalesce(sc.defect_rate,0) else 0 end) defect_rate25,
                        sum(case when sc.submit_date = '26' then coalesce(sc.defect_rate,0) else 0 end) defect_rate26,
                        sum(case when sc.submit_date = '27' then coalesce(sc.defect_rate,0) else 0 end) defect_rate27,
                        sum(case when sc.submit_date = '28' then coalesce(sc.defect_rate,0) else 0 end) defect_rate28,
                        sum(case when sc.submit_date = '29' then coalesce(sc.defect_rate,0) else 0 end) defect_rate29,
                        sum(case when sc.submit_date = '30' then coalesce(sc.defect_rate,0) else 0 end) defect_rate30,
                        sum(case when sc.submit_date = '31' then coalesce(sc.defect_rate,0) else 0 end) defect_rate31                        
                FROM (
                        SELECT DISTINCT z.sec_name sec_name, z.line_type line_type, substr(x.submit_date,7,2) submit_date, 
                                        sum(x.check_qty) sum_check_qty, sum(x.pass_qty) sum_pass_qty, 
                                        round(sum(x.pass_qty)/sum(x.check_qty)*100,2) pass_rate, round(sum(x.check_qty-x.pass_qty)/sum(x.check_qty)*100,2) defect_rate
                        FROM $schema.tl_data_collection x, $schema.tl_sec z 
                        WHERE x.fact_no = z.fact_no
                        AND x.sec_no = z.sec_no 
                        AND x.fact_no = '$factory' 
                        AND x.sec_no = '$sec_no'
                        AND substr(submit_date,1,8) >= '$datestart' 
                        AND substr(submit_date,1,8) <= '$indate' 
                        GROUP BY z.sec_name, z.line_type, substr(x.submit_date,7,2)
                    ) sc
                GROUP BY sc.sec_name, sc.line_type";

        return $dba->query($sql)->result();
    }

    // function get detail reason list by section
    public function getDefectList($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');

        $sql = "SELECT  aa.sec_no, aa.sec_name, string_agg(aa.defect_name||' (QTY: '||aa.defect_qty||')',', ') defect, aa.process_no, aa.process_name,
						(SELECT sum(check_qty) 
							FROM $schema.tl_data_collection 
							WHERE process_no = aa.process_no 
							AND fact_no = '$factory' 
							AND sec_no = '$sec_no' 
							AND substr(submit_date,1,8) = '$indate') check_qty,
						(SELECT sum(pass_qty) 
							FROM $schema.tl_data_collection 
							WHERE process_no = aa.process_no 
							AND fact_no = '$factory' 
							AND sec_no = '$sec_no' 
							AND substr(submit_date,1,8) = '$indate') pass_qty,  
						sum(aa.defect_qty) defect_qty 
                FROM (SELECT    a.sec_no, b.defect_no, c.sec_name, d.defect_name  defect_name, e.process_no, e.process_name, sum(b.defect_qty) defect_qty
                        FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b, $schema.tl_sec c, $schema.tl_defect_list d, $schema.tl_process e
                        WHERE a.fact_no = b.fact_no 
							AND a.fact_no = c.fact_no 
							AND a.fact_no = d.fact_no 
							AND a.fact_no = e.fact_no 
							AND a.submit_id = b.submit_id 
							AND a.sec_no = c.sec_no 
							AND b.defect_no = d.defect_no 
							AND a.process_no = e.process_no 
							AND a.line_type = e.line_type 
							AND a.fact_no = '$factory'
							AND a.sec_no = '$sec_no'
							AND substr(a.submit_date,1,8) = '$indate'
							AND b.defect_qty <> 0
						GROUP BY a.sec_no, b.defect_no, c.sec_name, d.defect_name, e.process_no, e.process_name
						ORDER BY e.process_no) aa
                GROUP BY aa.sec_no,aa.sec_name,aa.process_no,aa.process_name
                ORDER BY aa.process_no";        

        return $dba->query($sql)->result();
    }

    // function get detail reason list by section (interval 2 hours)
    public function getDefectList2Hours($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');

        $sql = "SELECT  aa.sec_no, aa.sec_name, string_agg(aa.defect_name||' (QTY: '||aa.defect_qty||')',', ') defect, aa.process_no, aa.process_name,
						(SELECT sum(check_qty) 
							FROM $schema.tl_data_collection 
							WHERE process_no = aa.process_no 
							AND fact_no = '$factory' 
							AND sec_no = '$sec_no' 
							AND substr(submit_date,1,8) = '$indate') check_qty,
						(SELECT sum(pass_qty) 
							FROM $schema.tl_data_collection 
							WHERE process_no = aa.process_no 
							AND fact_no = '$factory' 
							AND sec_no = '$sec_no' 
							AND substr(submit_date,1,8) = '$indate') pass_qty,  
						sum(aa.defect_qty) defect_qty 
				FROM (SELECT a.sec_no, b.defect_no, c.sec_name, d.defect_name  defect_name, e.process_no, e.process_name, sum(b.defect_qty) defect_qty
                        FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b, $schema.tl_sec c, $schema.tl_defect_list d, $schema.tl_process e
                        WHERE a.fact_no = b.fact_no 
							AND a.fact_no = c.fact_no 
							AND a.fact_no = d.fact_no 
							AND a.fact_no = e.fact_no 
							AND a.submit_id = b.submit_id 
							AND a.sec_no = c.sec_no 
							AND b.defect_no = d.defect_no 
							AND a.process_no = e.process_no 
							AND a.line_type = e.line_type 
							AND a.fact_no = '$factory'
							AND a.sec_no = '$sec_no'
							AND substr(a.submit_date,1,8) = '$indate'
							AND b.defect_qty <> 0
							AND substr(submit_date,9,6) BETWEEN coalesce(to_char(current_timestamp - interval '2 hour', 'HH24MISS'), '') AND coalesce(to_char(current_timestamp, 'HH24MISS'), '')
                        GROUP BY a.sec_no, b.defect_no, c.sec_name, d.defect_name, e.process_no, e.process_name
                        ORDER BY e.process_no) aa
                GROUP BY aa.sec_no,aa.sec_name,aa.process_no,aa.process_name
                ORDER BY aa.process_no";        

        return $dba->query($sql)->result();
    }

    // fucntion get detail reason by section AND process no
    public function getDefectListPro($schema, $dba, $sec_no, $indate, $process_no){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');
        
        $sql = "SELECT  aa.sec_no, aa.sec_name, string_agg(aa.defect_name||' (QTY: '||aa.defect_qty||')',', ') defect, aa.process_no, aa.process_name,
						(SELECT sum(check_qty) 
							FROM $schema.tl_data_collection 
							WHERE process_no = aa.process_no 
							AND fact_no = '$factory' 
							AND sec_no = '$sec_no' 
                            AND substr(process_no,2,1) = '$process_no'
							AND substr(submit_date,1,8) = '$indate') check_qty,
						(SELECT sum(pass_qty) 
							FROM $schema.tl_data_collection 
							WHERE process_no = aa.process_no 
							AND fact_no = '$factory' 
							AND sec_no = '$sec_no' 
                            AND substr(process_no,2,1) = '$process_no'
							AND substr(submit_date,1,8) = '$indate') pass_qty,  
						sum(aa.defect_qty) defect_qty 
				FROM (SELECT a.sec_no, b.defect_no, c.sec_name, d.defect_name  defect_name, e.process_no, e.process_name, sum(b.defect_qty) defect_qty
						FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b, $schema.tl_sec c, $schema.tl_defect_list d, $schema.tl_process e
						WHERE a.fact_no = b.fact_no 
							AND a.fact_no = c.fact_no 
							AND a.fact_no = d.fact_no 
							AND a.fact_no = e.fact_no 
							AND a.submit_id = b.submit_id 
							AND a.sec_no = c.sec_no 
							AND b.defect_no = d.defect_no 
							AND a.process_no = e.process_no 
							AND a.line_type = e.line_type 
							AND a.fact_no = '$factory'
							AND a.sec_no = '$sec_no'
							AND substr(a.submit_date,1,8) = '$indate'
							AND substr(a.process_no,2,1) = '$process_no'
							AND b.defect_qty <> 0
						GROUP BY a.sec_no, b.defect_no, c.sec_name, d.defect_name, e.process_no, e.process_name
						ORDER BY e.process_no) aa
				GROUP BY aa.sec_no,aa.sec_name,aa.process_no,aa.process_name
				ORDER BY aa.process_no";        

        return $dba->query($sql)->result();
    }

    // fucntion get detail reason by section AND process no (interval last 2 hours)
    public function getDefectListPro2Hours($schema, $dba, $sec_no, $indate, $process_no){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');
        
        $sql = "SELECT  aa.sec_no, aa.sec_name, string_agg(aa.defect_name||' (QTY: '||aa.defect_qty||')',', ') defect, aa.process_no, aa.process_name,
						(SELECT sum(check_qty) 
							FROM $schema.tl_data_collection 
							WHERE process_no = aa.process_no 
							AND fact_no = '$factory' 
							AND sec_no = '$sec_no' 
                            AND substr(process_no,2,1) = '$process_no'
							AND substr(submit_date,1,8) = '$indate') check_qty,
						(SELECT sum(pass_qty) 
							FROM $schema.tl_data_collection 
							WHERE process_no = aa.process_no 
							AND fact_no = '$factory' 
							AND sec_no = '$sec_no' 
                            AND substr(process_no,2,1) = '$process_no'
							AND substr(submit_date,1,8) = '$indate') pass_qty,  
						sum(aa.defect_qty) defect_qty 
				FROM (SELECT a.sec_no, b.defect_no, c.sec_name, d.defect_name  defect_name, e.process_no, e.process_name, sum(b.defect_qty) defect_qty
						FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b, $schema.tl_sec c, $schema.tl_defect_list d, $schema.tl_process e
						WHERE a.fact_no = b.fact_no 
							AND a.fact_no = c.fact_no 
							AND a.fact_no = d.fact_no 
							AND a.fact_no = e.fact_no 
							AND a.submit_id = b.submit_id 
							AND a.sec_no = c.sec_no 
							AND b.defect_no = d.defect_no 
							AND a.process_no = e.process_no 
							AND a.line_type = e.line_type 
							AND a.fact_no = '$factory'
							AND a.sec_no = '$sec_no'
							AND substr(a.submit_date,1,8) = '$indate'
							AND substr(a.process_no,2,1) = '$process_no'
							AND b.defect_qty <> 0
							AND substr(submit_date,9,6) BETWEEN coalesce(to_char(current_timestamp - interval '2 hour', 'HH24MISS'), '') AND coalesce(to_char(current_timestamp, 'HH24MISS'), '')
						GROUP BY a.sec_no, b.defect_no, c.sec_name, d.defect_name, e.process_no, e.process_name
						ORDER BY e.process_no) aa
				GROUP BY aa.sec_no,aa.sec_name,aa.process_no,aa.process_name
				ORDER BY aa.process_no";        

        return $dba->query($sql)->result();
    }

    // function get Suggest reason list by section
    public function getSuggestList($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');
        
        $sql = "SELECT DISTINCT	d.suggest_name, e.process_no, e.process_name, a.line_type
                FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b, $schema.tl_sec c, $schema.tl_suggest_list d, $schema.tl_process e
                WHERE a.fact_no = b.fact_no AND a.submit_id = b.submit_id
                AND a.fact_no = c.fact_no AND a.sec_no = c.sec_no 
                AND a.fact_no = d.fact_no AND a.process_no = d.process_no AND a.line_type = d.line_type 
                AND a.fact_no = e.fact_no AND a.process_no = e.process_no AND a.line_type = e.line_type 
                AND a.fact_no = '$factory'
                AND a.sec_no = '$sec_no'
                AND substr(a.submit_date,1,8) = '$indate'
                AND b.defect_qty <> 0
                ORDER BY e.process_no";

        return $dba->query($sql)->result();
    }

    // function get Suggest reason list by section (interval last 2 hours)
    public function getSuggestList2Hours($schema, $dba, $sec_no, $indate){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');
        
        $sql = "SELECT DISTINCT	d.suggest_name, e.process_no, e.process_name, a.line_type
                FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b, $schema.tl_sec c, $schema.tl_suggest_list d, $schema.tl_process e
                WHERE a.fact_no = b.fact_no AND a.submit_id = b.submit_id
                AND a.fact_no = c.fact_no AND a.sec_no = c.sec_no 
                AND a.fact_no = d.fact_no AND a.process_no = d.process_no AND a.line_type = d.line_type 
                AND a.fact_no = e.fact_no AND a.process_no = e.process_no AND a.line_type = e.line_type 
                AND a.fact_no = '$factory'
                AND a.sec_no = '$sec_no'
                AND substr(a.submit_date,1,8) = '$indate'
                AND b.defect_qty <> 0
				AND substr(submit_date,9,6) BETWEEN coalesce(to_char(current_timestamp - interval '2 hour', 'HH24MISS'), '') AND coalesce(to_char(current_timestamp, 'HH24MISS'), '')
                ORDER BY e.process_no";

        return $dba->query($sql)->result();
    }

    // function get Suggest reason list by section AND process
    public function getSuggestListPro($schema, $dba, $sec_no, $indate, $process_no){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');
        
        $sql = "SELECT DISTINCT	d.suggest_name, e.process_no, e.process_name, a.line_type
                FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b, $schema.tl_sec c, $schema.tl_suggest_list d, $schema.tl_process e
                WHERE a.fact_no = b.fact_no AND a.submit_id = b.submit_id
                AND a.fact_no = c.fact_no AND a.sec_no = c.sec_no 
                AND a.fact_no = d.fact_no AND a.process_no = d.process_no AND a.line_type = d.line_type 
                AND a.fact_no = e.fact_no AND a.process_no = e.process_no AND a.line_type = e.line_type 
                AND a.fact_no = '$factory'
                AND a.sec_no = '$sec_no'
                AND substr(a.submit_date,1,8) = '$indate'
                AND substr(a.process_no,2,1) = '$process_no'
                AND b.defect_qty <> 0
                ORDER BY e.process_no";

        return $dba->query($sql)->result();
    }

    // function get Suggest reason list by section AND process (interval last 2 hours)
    public function getSuggestListPro2Hours($schema, $dba, $sec_no, $indate, $process_no){
        // get numeric value only
        $indate = preg_replace("/[^0-9]/","",$indate); 

        $factory = $this->session->userdata('factory');
        
        $sql = "SELECT DISTINCT	d.suggest_name, e.process_no, e.process_name, a.line_type
                FROM $schema.tl_data_collection a, $schema.tl_data_collection_d b, $schema.tl_sec c, $schema.tl_suggest_list d, $schema.tl_process e
                WHERE a.fact_no = b.fact_no AND a.submit_id = b.submit_id
                AND a.fact_no = c.fact_no AND a.sec_no = c.sec_no 
                AND a.fact_no = d.fact_no AND a.process_no = d.process_no AND a.line_type = d.line_type 
                AND a.fact_no = e.fact_no AND a.process_no = e.process_no AND a.line_type = e.line_type 
                AND a.fact_no = '$factory'
                AND a.sec_no = '$sec_no'
                AND substr(a.submit_date,1,8) = '$indate'
                AND substr(a.process_no,2,1) = '$process_no'
                AND b.defect_qty <> 0
				AND substr(submit_date,9,6) BETWEEN coalesce(to_char(current_timestamp - interval '2 hour', 'HH24MISS'), '') AND coalesce(to_char(current_timestamp, 'HH24MISS'), '')
                ORDER BY e.process_no";

        return $dba->query($sql)->result();
    }

    // function save
    public function save($schema, $dba, $master_data, $detail_data){    
        // execute insert master data
        $master = $dba->insert($schema.'.tl_data_collection', $master_data); 
        
        if($detail_data != null){
            if($master){
                // execute insert multiple detail data
                return $dba->insert_batch($schema.'.tl_data_collection_d', $detail_data); 
                return $master;
            }
        }else{
            return $master;
        }
    }

    // function update
    public function update($schema, $dba, $master_data, $detail_data, $submit_id, $submit_seq, $defect_no){
        $factory = $this->session->userdata('factory');
        // execute update master data
        $master = $dba->update($schema.'.tl_data_collection', $master_data, array('fact_no' => $factory, 'submit_id' => $submit_id));

        // check data detail collection by submit ID
        $dba->where('fact_no', $factory);
        $dba->where('submit_id', $submit_id);
        $res = $dba->count_all_results($schema.'.tl_data_collection_d');

        // delete records when found old data
        if($res > 0){
            $dba->delete($schema.'.tl_data_collection_d', array('fact_no' => $factory, 'submit_id' => $submit_id));
        }

        if($detail_data != null){
            if($master){
                // execute insert new multiple detail data
                return $dba->insert_batch($schema.'.tl_data_collection_d', $detail_data); 
                return $master;
            }
        }else{
            return $master;
        }        
    }

    // funtion delete
    public function delete($schema, $dba, $id){
        $factory = $this->session->userdata('factory');

        // check data detail collection by submit ID
        $dba->where('fact_no', $factory);
        $dba->where('submit_id', $id);
        $res = $dba->count_all_results($schema.'.tl_data_collection_d');

        // delete records when found old data
        if($res > 0){
            $dba->delete($schema.'.tl_data_collection_d', array('fact_no' => $factory, 'submit_id' => $id));
        }
        
        return $dba->delete($schema.'.tl_data_collection', array('fact_no' => $factory, 'submit_id'=>$id)); 
    }
}
