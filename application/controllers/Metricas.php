<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Metricas extends CI_Controller {
    public function index() {
        if ($this->isLogged()){
            $this->load->model('SpinModel');
            $this->load->model('MetricsModel');
            $this->load->model('BalanceModel');
		    $spin = new SpinModel();
		    $metrics = new MetricsModel();
		    $balance = new BalanceModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$json = $this->getstatus();
			
			$rodadas = $spin->listing();
			$completed = $spin->spinmetrics();
			$contmetrics20 = $metrics->completed(2020);
			$contmetrics21 = $metrics->completed(2021);
			$balanceitem = $balance->listing();
			
			$content = array(
			    "rodadas" => $rodadas, 
			    "completed" => $completed, 
			    "contmetrics" => $contmetrics20, 
			    "contmetrics21" => $contmetrics21, 
			    "balanceitem" => $balanceitem, 
			    "json" => $json);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/dashboard', $content);
			
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
			"pageid" => 5,
			"notifications" => $notifications,
			"countnotify" => count($countnotify),
			"requests" => $requests,
			"countrequests" => count($countrequests)
		);
    }
}