<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function index() {
        if ($this->isLogged()){
            redirect(base_url('inicio'));
        } else {
            $this->load->view('public/login');
        }
    }
	public function signin() {
		if ($this->isLogged()){
			redirect(base_url('inicio'));
		} else {
			$this->load->model("LoginModel");
			
			$supernick = $this->input->post("supernick");
			$superpassword = md5($this->input->post("superpassword"));
			
			$super = $this->LoginModel->search($supernick, $superpassword);
			
			if($super){
				if($super['superstatus'] == '1'){
					$session = array(
						'superid' => $super["superid"],
						'supername' => $super["supername"],
						'super' => TRUE,
						'logged' => TRUE
					);

					$this->session->set_userdata($session);

					redirect(base_url('login'));
				} else {
					$alert = array(
						"class" => "warning",
						"message" => "Seu acesso esta bloqueado!<br />Entre em contato com um administrador.");

					$info = array("alert" => $alert);
				
					$this->load->view('public/login', $info);
				}
			}else {
				$alert = array(
					"class" => "danger",
					"message" => "Usuário ou senha incorretos");
				
				$info = array("alert" => $alert);
				
				$this->load->view('public/login', $info);
			}
		}
    }
    
    public function signout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}