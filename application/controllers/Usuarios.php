<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {
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
            $this->load->view('super/usuarios', $content);
			
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
            $this->load->view('super/usuarios', $content);
			
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function desativar($userid = null){
        if ($this->isLogged()){
            $this->load->model('UserModel');
			$user = new UserModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$item = $user->searchid($userid);
			
			if($item){
			    $userdata['userid'] = $item['userid'];
    			$userdata['username'] = $item['username'];
    			$userdata['useremail'] = $item['useremail'];
    			$userdata['userphone'] = $item['userphone'];
    			$userdata['userkey'] = $item['userkey'];
    			$userdata['userpassword'] = $item['userpassword'];
    			$userdata['userstatus'] = 0;
    			
    			if($user->update($userdata)){
    			    $alert = array(
        				"class" => "danger",
        				"message" => "Usuário desativado");
        				
        				$listing = $user->listing();
            			$itens = count($user->getCount());
            			
            			$content = array("users" => $listing, "itens" => $itens, "alert" => $alert);
            			
                        $this->load->view('template/super/headermenu', $info);
                        $this->load->view('super/usuarios', $content);
    			}
			} else {
			    redirect(base_url('usuarios'));
			}
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function ativar($userid = null){
        if ($this->isLogged()){
            $this->load->model('UserModel');
			$user = new UserModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$item = $user->searchid($userid);
			
			if($item){
			    $userdata['userid'] = $item['userid'];
    			$userdata['username'] = $item['username'];
    			$userdata['useremail'] = $item['useremail'];
    			$userdata['userphone'] = $item['userphone'];
    			$userdata['userkey'] = $item['userkey'];
    			$userdata['userpassword'] = $item['userpassword'];
    			$userdata['userstatus'] = 1;
    			
    			if($user->update($userdata)){
    			    $alert = array(
        				"class" => "success",
        				"message" => "Usuário ativado");
        				
        				$listing = $user->listing();
            			$itens = count($user->getCount());
            			
            			$content = array("users" => $listing, "itens" => $itens, "alert" => $alert);
            			
                        $this->load->view('template/super/headermenu', $info);
                        $this->load->view('super/usuarios', $content);
    			}
			} else {
			    redirect(base_url('usuarios'));
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