<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carteiras extends CI_Controller {
    public function index() {
        if ($this->isLogged()){
            $this->load->model('WalletModel');
			$wallet = new WalletModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$listing = $wallet->listing();
			
			$content = array("wallets" => $listing);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/carteiras', $content);
			
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function pesquisar(){
        if ($this->isLogged()){
            $this->load->model('UserModel');
			$user = new UserModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$searchlabel = $this->input->post("searchlabel");
			
			$listing = $user->search($searchlabel);
			$itens = count($user->getCount());
			
			$content = array("users" => $listing, "itens" => $itens);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/carteiras', $content);
			
        }else{
            redirect(base_url('login'));
        }
    }
    
	
    public function getInfo() {
        $this->load->model('SupernotifyModel');
        $this->load->model('OrdersuperModel');
		$snaux = new SupernotifyModel();
		$osaux = new OrdersuperModel();
		
		$notifications = $snaux->countlistsuper($this->session->userdata('superid'));
		$countnotify = $snaux->countlistsuper($this->session->userdata('superid'));
		$requests = $osaux->listsuper($this->session->userdata('userid'));
		$countrequests = $osaux->countlistsuper($this->session->userdata('superid'));
		
		return array(
			"pageid" => 7,
			"notifications" => $notifications,
			"countnotify" => count($countnotify),
			"requests" => $requests,
			"countrequests" => count($countrequests)
		);
    }
}