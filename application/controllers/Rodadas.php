<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rodadas extends CI_Controller {
    public function index() {
        if ($this->isLogged()){
            $this->load->model('SpinModel');
		    $spin = new SpinModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$rodadas = $spin->listing();
			
			$content = array("rodadas" => $rodadas);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/spins', $content);
			
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
			"pageid" => 2,
			"notifications" => $notifications,
			"countnotify" => count($countnotify),
			"requests" => $requests,
			"countrequests" => count($countrequests)
		);
    }
}