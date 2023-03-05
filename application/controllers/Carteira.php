<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Carteira extends CI_Controller {

    public function id($userid = null) {
        if ($this->isLogged()){
			$this->load->model('WalletModel');
			$this->load->model('FOModel');
			$wallet = new WalletModel();
			$fo = new FOModel();
			
            $getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$walletinfo = $wallet->search($userid);
			$orderinfo = $fo->listingbyuser($userid);
					
            $content = array("walletinfo" => $walletinfo, "orderinfo" => $orderinfo);
            
            $this->load->view('template/super/headermenu', $info);
			$this->load->view('super/wallet', $content);
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
			"pageid" => 3,
			"notifications" => $notifications,
			"countnotify" => count($countnotify),
			"requests" => $requests,
			"countrequests" => count($countrequests)
		);
    }
}