<?php
/*
* Dibuat    : dinnushobirin
* Tahun     : 2020
* Type      : model
* Nama      : Model_trx_transaksi
*/
class Model_trx_transaksi extends CI_Model {
	
    public function __construct() {
        parent::__construct();
    }

    function jumlahData(){   
        $query = $this->db->query('SELECT FOUND_ROWS() AS `Count`');
        return $query->row()->Count;
    }
    
    function viewData($limit=null,$start=null,$filter=null){
        $this->db->select(" SQL_CALC_FOUND_ROWS
                            a.*
                         ", FALSE);
        $this->db->from("trx_transaksi a");
        
        //filter data
        if(!empty($filter['nama'])){
            $this->db->group_start();
            $this->db->like(" a.nama",$filter['nama']);
            $this->db->group_end();
        }
        if(!empty($filter['id_kategori'])){
            $this->db->where(" a.id_kategori",$filter['id_kategori']);
        }
        if(!empty($filter['awal']) AND !empty($filter['akhir'])){
            $this->db->where(" ( DATE_FORMAT(a.insert_time,'%Y-%m-%d') BETWEEN '$filter[awal]' AND '$filter[akhir]' OR  DATE_FORMAT(a.update_time,'%Y-%m-%d') BETWEEN '$filter[awal]' AND '$filter[akhir]' ) ");
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
        $this->db->select(" a.*
                         ");
        $this->db->from("trx_transaksi a");
        $this->db->where('a.id',$id);
        $query = $this->db->get(); 
        
        return $query->row_array();
    }
 
    function insert($params){
        $params['insert_id']   = CoreUserId();
        $params['insert_time'] = date("Y-m-d H:i:s");
        $result = $this->db->insert("trx_transaksi",$params);
        
        return $result;
    } 

    function update($params,$id){
        $params['update_id']   = CoreUserId();
        $params['update_time'] = date("Y-m-d H:i:s");
        
        $this->db->where('id',$id);
        $result =  $this->db->update("trx_transaksi",$params);
        
        return $result;
    } 

    function delete($id=null){
        $this->db->where('id',$id);
        return $this->db->delete("trx_transaksi");
    } 
}