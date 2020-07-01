<?php
/*
* Dibuat    : dinnushobirin
* Tahun     : 2020
* Type      : model
* Nama      : Model_trx_dompet
*/
class Model_core_user extends CI_Model {
	
    public function __construct() {
        parent::__construct();
    }
    
    function jumlahData(){   
        $query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
        return $query->row()->Count;
    }
    
    function viewData($limit=null,$start=null,$filter=null){
        $this->db->select(" SQL_CALC_FOUND_ROWS
                            a.*,
                         ");
        $this->db->from("core_user a");
        
        //filter data
        if(!empty($filter['nama'])){
            $this->db->group_start();
            $this->db->like(" a.nama",$filter['nama']);
            $this->db->or_like(" a.username",$filter['nama']);
            $this->db->or_like(" a.nama_panjang",$filter['nama']);
            $this->db->or_like(" a.email",$filter['nama']);
            $this->db->or_like(" a.deskripsi",$filter['nama']);
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
        $this->db->select(" a.* ");
        $this->db->from("core_user a");
        $this->db->where('a.id',$id);
        $query = $this->db->get(); 
        
        return $query->row_array();
    }

    function insert($params){
        $params['insert_id']   = CoreUserId();
        $params['insert_time'] = date("Y-m-d H:i:s");
        $result = $this->db->insert("core_user",$params);
        
        return $result;
    }

    function update($params,$id){
        $params['update_id']   = CoreUserId();
        $params['update_time'] = date("Y-m-d H:i:s");
        
        $this->db->where('id',$id);
        $result =  $this->db->update("core_user",$params);
        
        return $result;
    }

    function delete($id=null){
        $this->db->where('id',$id);
        return $this->db->delete("core_user");
    } 
    
    function cekLogin($post){
        $this->db->select('*');
        $this->db->from("core_user a");
        $this->db->where('username',$post['username']);
        $this->db->where('password',md5($post['password']));
        $query = $this->db->get(); 
        $data = $query->row_array();
        
        $result = 0;
        if($data){
            $result = $data['id'];
        }
        
        return $result;
    }
    

}