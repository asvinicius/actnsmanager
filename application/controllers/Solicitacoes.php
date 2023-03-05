<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Solicitacoes extends CI_Controller {
    public function index() {
        if ($this->isLogged()){
			$this->load->model('FOModel');
			$this->load->model('OrderModel');
			$this->load->model('OrdersuperModel');
			$this->load->model('OrdercontentsModel');
			$fo = new FOModel();
			$orders = new OrderModel();
			$ordersuper = new OrdersuperModel();
			$ordercontents = new OrdercontentsModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$listing = $ordersuper->listsuper($this->session->userdata('superid'));
			$itens = count($ordersuper->getCount($this->session->userdata('superid')));
			$folisting = $fo->listsuper($this->session->userdata('superid'));
			$foitens = count($fo->getCount($this->session->userdata('superid')));
			
			if(($itens % 10) == 0) {
				$mult = true;
			} else {
				$mult = false;
			}
			
            $content = array("orders" => $listing, "financials" => $folisting, "page" => 0, "itens" => $itens, "mult" => $mult);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/requests', $content);
			
        }else{
            redirect(base_url('login'));
        }
    }
	
	public function inscricao($orderid) {
        if ($this->isLogged()){
			$this->load->model('OrderModel');
			$this->load->model('OrdersuperModel');
			$this->load->model('OrdercontentsModel');
			$orders = new OrderModel();
			$ordersuper = new OrdersuperModel();
			$ordercontents = new OrdercontentsModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$listing = $ordercontents->listorder($orderid);
			$orderitem = $orders->search($orderid);
			
            $content = array("oc_itens" => $listing, "orderitem" => $orderitem);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/subscriberequest', $content);
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
			"pageid" => 1,
			"notifications" => $notifications,
			"countnotify" => count($countnotify),
			"requests" => $requests,
			"countrequests" => count($countrequests)
		);
    }
}