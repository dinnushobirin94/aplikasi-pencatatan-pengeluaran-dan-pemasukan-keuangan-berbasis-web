<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core_user extends CI_Controller {
    public function __construct() {
	parent::__construct();
        
        $this->load->model('Model_core_user');
        $this->load->model('Model_kar_karyawan');
        $this->load->model('Model_kar_perusahaan');
        $this->load->library('parser');
        $this->load->helper('url');
        
        $this->load->library('pagination');
    }
    
    public function index(){
        CoreLogin();
        $pesan      = CorePesanTampil();
        //url
        $url_cari   = site_url('core_user/index');
        $url_add    = site_url('core_user/input');
        $url_update = site_url('core_user/input');
        $url_delete = site_url('core_user/delete');
        $title_menu = "Pengguna";
        //end url
        
        
        
        //filter data
        $post   = $this->input->post();
        $filter = CoreCari(@$post['cari']);
        unset($post['cari']);
        
        //refensi
        $data['nama']       = $filter['nama'];
        //end refensi
        
        //end filter data
        
        
        //paging bag1
        $config     = CorePaging();
        $config['per_page']     = 10;
        $start = $this->uri->segment(3);
        //end paging bag1
        
        $data_raw       = $this->Model_core_user->viewData($config['per_page'],$start,$filter);
        $jumlah_data    = $this->Model_core_user->jumlahData();
        if($data_raw){
            $no = 1;
            foreach ($data_raw as $key => $value) {
                $data_raw[$key]["no"]   = $no;
                if($value['user_id']!=1){
                    $data_raw[$key]["aksi"] = '
                        <a href="'.$url_update.'/?id='.$value['id'].'" title="update"><i class="fa fa-edit text-warning"></i></a>
                        <a href="'.$url_delete.'/?id='.$value['id'].'" title="delete"><i class="fa fa-eraser text-failed"></i></a>
                    ';
                }
                else{
                    $data_raw[$key]["aksi"] = '';
                }
                $no++;
            }
        }
        
        //paging bag2
        $config['base_url']     = base_url().'index.php/ref_kabupaten/index/';
        $config['total_rows']   = $jumlah_data;
        $this->pagination->initialize($config);		
        //end paging bag2
        
        
        
        $data["total_data"] = $jumlah_data;
        $data["data"]       = $data_raw;
        $data["pesan"]      = $pesan;
        $data["url_add"]    = $url_add;
        $data["url_cari"]   = $url_cari;
        $data["title_menu"] = $title_menu;
        
        $this->parser->parse('core_user/viewCoreUser',$data);
    }
    
    public function input(){
        $id     = $this->input->get('id', TRUE);
        $title_menu = "Form User Pengguna";
        
        $data = array();
        $data['url_save']   = site_url('core_user/save');
        
        //data
        $data["user_password"]=$data["user_deskripsi"]=$data["user_nama"]=$data["user_username"]=$data["user_nama_panjang"]=$data["user_email"]   = "";
        //end data
        
        
        if($id != ""){
            $detail = $this->Model_core_user->getKabupatenDetail($id);
            $data = array_merge($data,$detail);
        }
        $data['id'] = $id;
        //refensi
        $list_grup = $this->Model_core_user->getListGrupUser();
        foreach ($list_grup as $key => $value) {
            if($value['id']==@$data['user_key_ref_id']){
                $list_grup[$key]['selected'] = "selected";
            }  
        }
        $data['ref_grup'] = $list_grup;
        
        
        $list_karyawan = $this->Model_kar_karyawan->getListKaryawan();
        foreach ($list_karyawan as $key => $value) {
            if($value['id']==@$data['user_key_ref_id']){
                $list_karyawan[$key]['selected'] = "selected";
            }  
        }
        $data['ref_kaitan_pelamar'] = $list_karyawan;
        
        $list_perusahaan = $this->Model_kar_perusahaan->getListPerusahaan();
        foreach ($list_perusahaan as $key => $value) {
            if($value['id']==@$data['user_key_ref_id']){
                $list_perusahaan[$key]['selected'] = "selected";
            }  
        }
        $data['ref_kaitan_perusahaan'] = $list_perusahaan;
        //end refensi
        
        $data["title_menu"]     = $title_menu;
        $this->parser->parse('core_user/viewCoreUserInput',$data);
    }
    
    public function save(){
        $post = $this->input->post();
        
        $result = TRUE;
        $this->db->trans_start();
        $nama_file = $post['user_nama'].".jpg";
        $params = array(
            "user_nama"         => $post['user_nama'],
            "user_username"     => $post['user_username'],
            "user_password"     => md5($post['user_password']),
            "user_nama_panjang" => $post['user_nama_panjang'],
            "user_email"        => $post['user_email'],
            "user_foto"         => $nama_file,
            "user_deskripsi"    => $post['user_deskripsi'],
        );
        if($post['id']){
            $result = $result && $this->Model_core_user->update($params,$post['id']);
        }else{
            if($post['user_key_ref_id']=="2"){
                $params['user_key_ref_id']  = $post['user_key_ref_id'];
                $params['user_key_id']      = $post['user_key_id_pelamar'];
            }elseif ($post['user_key_ref_id']=="3") {
                $params['user_key_ref_id']  = $post['user_key_ref_id'];
                $params['user_key_id']      = $post['user_key_id_perusahaan'];
            }
            
            $result     = $result && $this->Model_core_user->insert($params);            
            $insert_id  = $this->db->insert_id();

            $params_grub = array(
                "user_id"         => $insert_id,
                "grup_id"         => $post['user_key_ref_id'],
            );
            $result = $result && $this->Model_core_user->insertGrup($params_grub);            
            
        }
        
        $this->db->trans_complete(); 
        
        if($result){
            CorePesan("Sukses", "alert-success");
            
        }else {
            CorePesan("Gagal", "alert-danger");
        }
        
        redirect('core_user/', 'refresh');
    }
    
    public function delete(){
        $id     = $this->input->get('id', TRUE);
        
        $result = TRUE;
        $this->db->trans_start();
        $result = $result && $this->Model_core_user->delete($id);
        $this->db->trans_complete(); 
        
        if($result){
            CorePesan("Sukses", "alert-success");    
        }else {
            CorePesan("Gagal", "alert-danger");
        }
        
        redirect('core_user/', 'refresh');
    }
}
