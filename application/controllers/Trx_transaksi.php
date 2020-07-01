<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trx_transaksi extends CI_Controller {
    public function __construct() {
	parent::__construct();
        
        $this->load->model('Model_trx_transaksi');
        $this->load->model('Model_ref_kategori');
        $this->load->model('Model_trx_dompet');
        $this->load->library('parser');
        
        $this->load->library('parser');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        
        $this->load->library('pagination');
    }
    
    public function index(){
        CoreLogin();
        $pesan      = CorePesanTampil();
        
        $url_cari   = site_url('trx_transaksi/index');
        $url_add    = site_url('trx_transaksi/form');
        $url_update = site_url('trx_transaksi/form');
        $url_delete = site_url('trx_transaksi/delete');

        
        //filter data
        $post   = $this->input->post();
        $filter = CoreCari(@$post['cari']);
        unset($post['cari']);

        $list_kategori = $this->Model_ref_kategori->getList();
        foreach ($list_kategori as $key => $value) {
            if(@$filter['id_kategori']==$value['id']){
                $list_kategori[$key]['selected'] = "selected";
            }  
        }
        $data['ref_kategori']   = $list_kategori;
        $data['awal']           = $filter['awal'];
        $data['akhir']          = $filter['akhir'];
        $data['nama']           = $filter['nama'];
        //end filter data


        //paging
        $config                 = CorePaging();
        $config['per_page']     = 10;
        $start = $this->uri->segment(3);
        //end paging
        
        $data_raw       = $this->Model_trx_transaksi->viewData($config['per_page'],$start,$filter);
        $jumlah_data    = $this->Model_trx_transaksi->jumlahData();
        if($data_raw){
            $no = 1;

            $total  = $total_penambahan  = $total_pengurangan  = 0;
            foreach ($data_raw as $key => $value) {
                if($value['is_pengurangan']==1){
                    $status = "(-) Pengurang";
                    $total              = $total - $value['nominal'];
                    $total_pengurangan  = $total_pengurangan + $value['nominal'];
                }else{
                    $status = "(+) Penambah";
                    $total              = $total + $value['nominal'];
                    $total_penambahan   = $total_penambahan + $value['nominal'];
                }

                $jenis  = $this->Model_ref_kategori->getDetail($value['id_kategori']);
                $data_raw[$key]["jenis"]            = $jenis['nama'];
                $data_raw[$key]["nominal_label"]    = "Rp ".CoreMoney($value['nominal']);

                $data_raw[$key]["no"]       = $no;
                $data_raw[$key]["status"]   = $status;
                $data_raw[$key]["aksi"] = '
                        <a href="'.$url_update.'/?id='.$value['id'].'"><i class="fa fa-edit text-warning"></i> Perbarui</a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="'.$url_delete.'/?id='.$value['id'].'" onclick="return confirm(\'apa kamu yakin, untuk menghapus?\');"><i class="fa fa-eraser text-failed" ></i> Hapus</a>
                        ';
                $no++;
            }
        }
        $data["total"]              = "Rp. ".CoreMoney($total);
        $data["total_penambahan"]   = "Rp. ".CoreMoney($total_penambahan);
        $data["total_pengurangan"]  = "Rp. ".CoreMoney($total_pengurangan);

        //paging bag2
        $config['base_url']     = base_url().'index.php/trx_transaksi/index/';
        $config['total_rows']   = $jumlah_data;
        $this->pagination->initialize($config);		
        //end paging bag2
        
        
        $data["total_data"] = $jumlah_data;
        $data["data"]       = $data_raw;
        $data["pesan"]      = $pesan;
        $data["url_add"]    = $url_add;
        $data["url_cari"]   = $url_cari;
        
        $this->parser->parse('trx_transaksi/index',$data);
    }
    
    public function form(){
        $id     = $this->input->get('id', TRUE);
        
        $data = array();
        $data['url_save']   = site_url('trx_transaksi/save');
        
        //data
        $status_pengurangan = $data["status_pengurangan"] = $data["nama"] = $data["deskripsi"] =  "";
        $data["is_pengurangan"] = 0;
        //end data
        
        
        
        if($id != ""){
            $detail = $this->Model_trx_transaksi->getDetail($id);
            if($detail["is_pengurangan"]==1){
                $status_pengurangan = " checked";
            }
            $data["status_pengurangan"] = $status_pengurangan;
            $data = array_merge($data,$detail);
        }
        $data['id'] = $id;

        //referensi
        $list_kategori = $this->Model_ref_kategori->getList();
        foreach ($list_kategori as $key => $value) {
            if($value['id']==@$data['id_kategori']){
                $list_kategori[$key]['selected'] = "selected";
            }  
        }
        $data['ref_kategori'] = $list_kategori;
        
        //end referensi
        
        $this->parser->parse('trx_transaksi/form',$data);
    }
    
    public function save(){
        $post = $this->input->post();
        
        $result = TRUE;
        $this->db->trans_start();
        $params = array(
            "nama"              => $post['nama'],
            "id_kategori"       => $post['id_kategori'],
            "deskripsi"         => $post['deskripsi'],
            "nominal"           => $post['nominal'],
            "is_pengurangan"    => !empty($post['is_pengurangan'])?$post['is_pengurangan']:0,
        );
        
        
        if($post['id']){
            $result = $result && $this->Model_trx_transaksi->update($params,$post['id']);
            $id = $post['id'];
        }else{
            $result = $result && $this->Model_trx_transaksi->insert($params);
            $id = $this->db->insert_id();
        }
        

        //update dompet
        $dompet = $this->Model_trx_dompet->getDetail(1);
        $paramsDompet = array(
            "id_last_traksaksi"     => $id,
            "is_last_pengurangan"   => !empty($post['is_pengurangan'])?$post['is_pengurangan']:0,
            "saldo"                 => $this->Model_trx_dompet->getSaldo(),
            "saldo_sebelum"         => $dompet['saldo'],
            "total_pengeluaran"     => $this->Model_trx_dompet->getTotal(1),
            "total_pemasukan"       => $this->Model_trx_dompet->getTotal(),
        );
        $result = $result && $this->Model_trx_dompet->update($paramsDompet,1);
        //end update dompet

        $this->db->trans_complete(); 
        if($result){
            CorePesan("Sukses", "alert-success"); 
        }else {
            CorePesan("Gagal", "alert-danger");
        }
        redirect('trx_transaksi/', 'refresh');
    }
    
    public function delete(){
        $id     = $this->input->get('id', TRUE);
        
        $result = TRUE;
        $this->db->trans_start();
        $result = $result && $this->Model_trx_transaksi->delete($id);

        //update dompet
        $dompet = $this->Model_trx_dompet->getDetail(1);
        $paramsDompet = array(
            "id_last_traksaksi"     => $this->Model_trx_dompet->getId(),
            "is_last_pengurangan"   => !empty($post['is_pengurangan'])?$post['is_pengurangan']:0,
            "saldo"                 => $this->Model_trx_dompet->getSaldo(),
            "saldo_sebelum"         => $dompet['saldo'],
            "total_pengeluaran"     => $this->Model_trx_dompet->getTotal(1),
            "total_pemasukan"       => $this->Model_trx_dompet->getTotal(),
        );
        $result = $result && $this->Model_trx_dompet->update($paramsDompet,1);
        //end update dompet

        $this->db->trans_complete(); 
        
        if($result){
            CorePesan("Sukses", "alert-success"); 
        }else {
            CorePesan("Gagal", "alert-danger");
        }
        redirect('trx_transaksi/', 'refresh');
    }
}
