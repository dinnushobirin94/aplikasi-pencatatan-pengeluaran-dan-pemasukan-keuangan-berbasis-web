<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
	parent::__construct();
        
        $this->load->model('Model_core_user');
        $this->load->library('parser');
        $this->load->helper('url');
        $this->load->library('session');
    }
    
    public function index(){
        coreLoginHome();
        $data["pesan"] = CorePesanTampil();
        
        $this->parser->parse('login',$data);
    }
    
    public function login(){
        $post       = $this->input->post();
        $cekLogin   = $this->Model_core_user->cekLogin($post);
        
        $this->session->unset_userdata('userLogin');
        $this->session->unset_userdata('userLoginInfo');
        if($cekLogin){
            $this->session->userLogin       = $cekLogin;
            $this->session->userLoginInfo   = $this->Model_core_user->getDetail($cekLogin);
           
            CorePesan("Sukses Login", "alert-success");
            redirect('dashboard');
        }else{
            CorePesan("Login Failed", "alert-danger");
            redirect('auth/login/');
        }
    }

    public function logout(){
        $this->session->unset_userdata('userLogin');
        $this->session->unset_userdata('userLoginInfo');
        $pesan = '<script>alert("Log Out")</script>';   
        redirect('auth');
    }
}
