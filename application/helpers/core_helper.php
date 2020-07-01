<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function CoreCari($cari=null){
    $ci=& get_instance();
    $ci->load->library('session');
    $ci->session->unset_userdata('cari');
    $ci->session->cari = $cari;

    $result = $ci->session->cari;
    
    return $result;
}

function CoreUserId(){
    $ci=& get_instance();
    $ci->load->library('session');
    
    $result = $ci->session->userLogin;
    
    return $result;
}

function CoreUserInfo(){
    $ci=& get_instance();
    $ci->load->library('session');
    
    $result = $ci->session->userLoginInfo;
    
    return $result;
}

function CorePaging(){  
    $config['query_string_segment'] = 'start';
    $config['full_tag_open'] = '<nav><ul class="pagination pagination-sm no-margin pull-right" style="margin-top:0px">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['first_link'] = 'Awal';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'Terakhir';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = 'Selanjutnya';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = 'Sebelumnya';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a>';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    
    return $config;
}

function CorePesan($pesan,$css){
    $ci =& get_instance();
    $ci->load->library('session');
    $result = '
                <div class="alert '.$css.' alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>'.$pesan.'</h4>
                </div>
            '; 
    $ci->session->pesan = $result;
}

function CorePesanTampil(){
    $ci =& get_instance();
    $ci->load->library('session');
    $result = $ci->session->pesan;
    $ci->session->unset_userdata('pesan');
    
    return $result;
}

function CoreLogin(){
    $ci =& get_instance();
    $ci->load->library('session');
    $ci->load->helper('url');
    
    $data = $ci->session->userLogin;
    if(empty($data)){
        redirect('auth');
        exit();
    }  
    
}

function CoreLoginHome(){
    $ci =& get_instance();
    $ci->load->library('session');
    $ci->load->helper('url');
    
    $data = $ci->session->userLogin;
    if(!empty($data)){
        redirect('dashboard');
        exit();
    }  
    
}

function CoreMoneyOld($amount=0){
	$ci=& get_instance();
	$format = $ci->db->query('
		SELECT * FROM xbs_settings 
	')->result_array();
	$p1 = '.';
	$p2 = ',';
	$decimal = 2;
	foreach ($format as $key => $value) {
		if($value['setting_name'] == 'money_format'){
			$dt = explode("|", $value['setting_value']);
			$p1 = $dt[0];
			$p2 = $dt[1];
		}
		if($value['setting_name'] == 'money_decimal'){
			$decimal = $value['setting_value'];	
		}
	}

	return number_format($amount,$decimal,$p1,$p2);
}

function CoreMoney($amount=0){
	$hasil_rupiah = number_format($amount,2,'.',',');
	return $hasil_rupiah;
}

function CoreDebug(){
    $ci=& get_instance();
    echo '<pre>';
    print_r($ci->db->last_query());
    echo '</pre>';
}

function CoreDebugPree($data,$die=NULL){
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if(!empty($die)){
        die();
    }
}

function CoreAngkaKoma($angka=0,$decimals=2){
    $expo = pow(10,$decimals);
    $result = intval($angka*$expo)/$expo;
    
    return $result;
}

function CoreMoneyToString($amount=0){
    $raw_data   = explode(".",$amount);
    $result     = str_replace(",","",$raw_data['0']);
    
    return $result;
}

function CoreDateIndo($date=NULL){
    if(empty($date)){
        $date = date("Y-m-d");
    }
    $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
    );
    $pecahkan = explode('-', $date);
	
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function CoreConvertDate($date=NULL){
    $res = explode("/", $date);
    $result = $res[2]."-".$res[0]."-".$res[1];
    
    return $result;
}

function CoreConvertTerbilang($nilai=NULL){
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }     		
    return $hasil.' rupiah';
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function getBulanHelper(){
	$data =  array(1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember");

	return $data;
}
