<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
	parent::__construct();
     
        $this->load->library('parser');
        $this->load->helper('url');
        
        $this->load->library('session');
    }
    
    public function index(){
        coreLogin();
        $data["pesan"] = CorePesanTampil();
        
        $this->load->model('Model_ref_kategori');
        $this->load->model('Model_trx_dompet');
        $this->load->model('Model_trx_transaksi');
        


        $dompet         = $this->Model_trx_dompet->getDetail(1);
        $transaksi      = $this->Model_trx_transaksi->getDetail($dompet['id_last_traksaksi']);
        $jenis          = $this->Model_ref_kategori->getDetail($transaksi['id_kategori']);
        if($dompet['is_last_pengurangan']==1){
            $status = "-";
        }else{
            $status = "+";
        }
        
        $data["jenis"]                  = $jenis['nama'];
        $data["transaksi_terakhir"]     = $status." Rp. ".CoreMoney($transaksi['nominal']);
        $data["total_pemasukan"]        = "Rp. ".CoreMoney($dompet['total_pemasukan']);
        $data["total_pengeluaran"]      = "Rp. ".CoreMoney($dompet['total_pengeluaran']);
        $data["saldo"]                  = "Rp. ".CoreMoney($dompet['saldo']);

        
        $this->parser->parse('dashboard',$data);
    }
}
