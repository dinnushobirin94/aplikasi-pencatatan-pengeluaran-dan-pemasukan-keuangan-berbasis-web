<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ref_kategori extends CI_Controller {
    public function __construct() {
	parent::__construct();
        
        $this->load->model('Model_ref_kategori');
        $this->load->library('parser');
        
        $this->load->library('parser');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        
        $this->load->library('pagination');
    }
    
    public function index(){
        CoreLogin();
        $pesan      = CorePesanTampil();
        
        $url_cari   = site_url('ref_kategori/index');
        $url_add    = site_url('ref_kategori/form');
        $url_update = site_url('ref_kategori/form');
        $url_delete = site_url('ref_kategori/delete');

        
        //filter data
        $post   = $this->input->post();
        $filter = CoreCari(@$post['cari']);
        unset($post['cari']);
        //end filter data


        //paging
        $config                 = CorePaging();
        $config['per_page']     = 10;
        $start = $this->uri->segment(3);
        //end paging
        
        $data_raw       = $this->Model_ref_kategori->viewData($config['per_page'],$start,$filter);
        $jumlah_data    = $this->Model_ref_kategori->jumlahData();
        if($data_raw){
            $no = 1;
            foreach ($data_raw as $key => $value) {
                if($value['is_pengurangan']==1){
                    $status = "(-) Pengurang";
                }else{
                    $status = "(+) Penambah";
                }

                $data_raw[$key]["no"]       = $no;
                $data_raw[$key]["status"]   = $status;
                $data_raw[$key]["aksi"] = '
                        <a href="'.$url_update.'/?id='.$value['id'].'"><i class="fa fa-edit text-warning"></i> Perbarui</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="'.$url_delete.'/?id='.$value['id'].'" onclick="return confirm(\'apa kamu yakin, untuk menghapus?\');"><i class="fa fa-eraser text-failed" ></i> Hapus</a>
                        ';
                $no++;
            }
        }

        //paging bag2
        $config['base_url']     = base_url().'index.php/ref_kategori/index/';
        $config['total_rows']   = $jumlah_data;
        $this->pagination->initialize($config);		
        //end paging bag2
        
        
        $data["total_data"] = $jumlah_data;
        $data["data"]       = $data_raw;
        $data["pesan"]      = $pesan;
        $data["url_add"]    = $url_add;
        $data["url_cari"]   = $url_cari;
        
        $this->parser->parse('ref_kategori/index',$data);
    }
    
    public function form(){
        $id     = $this->input->get('id', TRUE);
        
        $data = array();
        $data['url_save']   = site_url('ref_kategori/save');
        
        //data
        $status_pengurangan = $data["status_pengurangan"] = $data["nama"] = $data["deskripsi"] =  "";
        $data["is_pengurangan"] = 0;
        //end data
        
        
        
        if($id != ""){
            $detail = $this->Model_ref_kategori->getDetail($id);
            if($detail["is_pengurangan"]==1){
                $status_pengurangan = " checked";
            }
            $data["status_pengurangan"] = $status_pengurangan;
            $data = array_merge($data,$detail);
        }
        $data['id'] = $id;

        
        
        $this->parser->parse('ref_kategori/form',$data);
    }
    
    public function save(){
        $post = $this->input->post();
        
        $result = TRUE;
        $this->db->trans_start();
        $params = array(
            "nama"              => $post['nama'],
            "deskripsi"         => $post['deskripsi'],
            "is_pengurangan"    => !empty($post['is_pengurangan'])?$post['is_pengurangan']:0,
        );
        
        if($post['id']){
            $result = $result && $this->Model_ref_kategori->update($params,$post['id']);
        }else{
            $result = $result && $this->Model_ref_kategori->insert($params);
        }
        
        $this->db->trans_complete(); 
        if($result){
            CorePesan("Sukses", "alert-success"); 
        }else {
            CorePesan("Gagal", "alert-danger");
        }
        redirect('ref_kategori/', 'refresh');
    }
    
    public function delete(){
        $id     = $this->input->get('id', TRUE);
        
        $result = TRUE;
        $this->db->trans_start();
        $result = $result && $this->Model_ref_kategori->delete($id);
        $this->db->trans_complete(); 
        
        if($result){
            CorePesan("Sukses", "alert-success"); 
        }else {
            CorePesan("Gagal", "alert-danger");
        }
        redirect('ref_kategori/', 'refresh');
    }
}
