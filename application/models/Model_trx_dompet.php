<?php
/*
* Dibuat    : dinnushobirin
* Tahun     : 2020
* Type      : model
* Nama      : Model_trx_dompet
*/
class Model_trx_dompet extends CI_Model {
	
    public function __construct() {
        parent::__construct();
    }
   
    function getDetail($id=null){
        $this->db->select(" 
                            a.*
                         ");
        $this->db->from("trx_dompet a");
        $this->db->where('a.id',$id);
        $query = $this->db->get(); 
        
        return $query->row_array();
    }

    function getId(){
        $this->db->select(" id AS nominal
                         ");
        $this->db->from("trx_transaksi a");
        $this->db->order_by('a.id DESC');
        $this->db->limit(1);

        $query  = $this->db->get(); 
        $result = $query->row_array();
        return $result['id'];
    }

    function getTotal($is_pengurangan=0){
        $this->db->select(" sum(a.nominal) AS nominal
                         ");
        $this->db->from("trx_transaksi a");
        $this->db->where('a.is_pengurangan',$is_pengurangan);
        $query  = $this->db->get(); 
        $result = $query->row_array();
        return $result['nominal'];
    }

    function getSaldo(){
        $this->db->select(" a.nominal AS nominal,
                            a.is_pengurangan AS is_pengurangan
                         ");
        $this->db->from("trx_transaksi a");
        $query  = $this->db->get(); 
        if($query->num_rows()>0){
            $data_raw   = $query->result_array();
            $result     = 0; 
            foreach ($data_raw as $key => $value) {
                if($value['is_pengurangan']==1){
                    $result = $result - $value['nominal'];
                }else{
                    $result = $result + $value['nominal'];
                }
            }
        }
        else{
            $result = 0;
        }
        return $result;
    }
 
    function insert($params){
        $params['insert_id']   = CoreUserId();
        $params['insert_time'] = date("Y-m-d H:i:s");
        $result = $this->db->insert("trx_dompet",$params);
        
        return $result;
    } 

    function update($params,$id){
        $params['update_id']   = CoreUserId();
        $params['update_time'] = date("Y-m-d H:i:s");
        
        $this->db->where('id',$id);
        $result =  $this->db->update("trx_dompet",$params);
        
        return $result;
    } 

}