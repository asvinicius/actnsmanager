<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {
    public function index() {
        if ($this->isLogged()){
            $this->load->model('SpinModel');
			$this->load->model('FOModel');
			$this->load->model('OrderModel');
			$this->load->model('OrdersuperModel');
			$this->load->model('OrdercontentsModel');
			$fo = new FOModel();
			$orders = new OrderModel();
			$ordersuper = new OrdersuperModel();
			$ordercontents = new OrdercontentsModel();
		    $spin = new SpinModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$json = $this->getstatus();
			
			$rodadas = $spin->listing();
			$completed = $spin->completed();
			$numreq = count($ordersuper->getCount2($this->session->userdata('superid')))+count($fo->getCount($this->session->userdata('superid')));
			
			
			$content = array("rodadas" => $rodadas, "completed" => $completed, "json" => $json, "numreq" => $numreq);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/home', $content);
			
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
			"pageid" => 0,
			"notifications" => $notifications,
			"countnotify" => count($countnotify),
			"requests" => $requests,
			"countrequests" => count($countrequests)
		);
    }
}