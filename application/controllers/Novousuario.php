<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Novousuario extends CI_Controller {
    public function index() {
        if ($this->isLogged()){
            $this->load->model('UserModel');
			$user = new UserModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$listing = $user->listing();
			$itens = count($user->getCount());
			
			$content = array("users" => $listing, "itens" => $itens);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/novousuario', $content);
			
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function salvar(){
        if ($this->isLogged()){
            $this->load->model('UserModel');
            $this->load->model('WalletModel');
			$user = new UserModel();
			$wallet = new WalletModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$username = $this->input->post('username');
			$userphone = $this->input->post('userphone');
			$useremail = $this->input->post('useremail');
			$userkey = $this->input->post('userkey');
			$userpassword = md5($this->input->post('useremail'));
			
			$item = $user->searchemail($useremail);
			
			if($item){
			    $alert = array(
    				"class" => "danger",
    				"message" => "O E-mail inserido já existe em nossa base de dados!");
    				
    			$content = array("alert" => $alert);
			
                $this->load->view('template/super/headermenu', $info);
                $this->load->view('super/novousuario', $content);
			    
			} else {
    			
    			$userdata['userid'] = null;
    			$userdata['username'] = $username;
    			$userdata['useremail'] = $useremail;
    			$userdata['userphone'] = $userphone;
    			$userdata['userkey'] = $userkey;
    			$userdata['userpassword'] = $userpassword;
    			$userdata['userstatus'] = 1;
    			
    			if($user->save($userdata)){
    			    
    			    $lastuser = $user->lastinsert();
    			    
    			    $walletdata['wallet_id'] = null;
    			    $walletdata['wallet_user'] = $lastuser['userid'];
    			    $walletdata['wallet_balance'] = 0;
    			    $walletdata['wallet_free'] = 0;
    			    $walletdata['wallet_gift'] = 0;
    			    
    			    if($wallet->save($walletdata)){
    			        redirect(base_url('usuarios'));
    			    }
    			}
			}
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