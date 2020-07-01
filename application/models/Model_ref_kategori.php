<?php
/*
* Dibuat    : dinnushobirin
* Tahun     : 2020
* Type      : model
* Nama      : Model_ref_kategori
*/
class Model_ref_kategori extends CI_Model {
	
    public function __construct() {
        parent::__construct();
    }

    function jumlahData(){   
        $query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
        return $query->row()->Count;
    }
    
    function viewData($limit=null,$start=null,$filter=null){
        $this->db->select(" SQL_CALC_FOUND_ROWS
                            a.id,
                            a.nama,
                            a.deskripsi,
                            a.is_pengurangan
                         ", FALSE);
        $this->db->from("ref_kategori a");
        
        //filter data
        if(!empty($filter['nama'])){
            $this->db->group_start();
            $this->db->like(" a.nama",$filter['nama']);
            $this->db->group_end();
        }
        //end filter data
        
        
        $this->db->limit($limit,$start);
        $query = $this->db->get();
        
        if($query->num_rows()>0){
            $result = $query->result_array();
        }
        else{
            $result = array();
        }
        
        return $result;
    }
   
    function getDetail($id=null){
        $this->db->select(" SQL_CALC_FOUND_ROWS
                            a.*
                         ", FALSE);
        $this->db->from("ref_kategori a");
        $this->db->where('a.id',$id);
        $query = $this->db->get(); 
        
        return $query->row_array();
    }

    function getList(){
         $this->db->select("a.*,
                            '' AS 'selected'
                         ");
        $this->db->from("ref_kategori a");
        $query = $this->db->get(); 
        
        return $query->result_array();
    }
 
    function insert($params){
        $params['insert_id']   = CoreUserId();
        $params['insert_time'] = date("Y-m-d H:i:s");
        $result = $this->db->insert("ref_kategori",$params);
        
        return $result;
    } 

    function update($params,$id){
        $params['update_id']   = CoreUserId();
        $params['update_time'] = date("Y-m-d H:i:s");
        
        $this->db->where('id',$id);
        $result =  $this->db->update("ref_kategori",$params);
        
        return $result;
    } 

    function delete($id=null){
        $this->db->where('id',$id);
        return $this->db->delete("ref_kategori");
    } 
}