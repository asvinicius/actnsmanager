<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Editausuario extends CI_Controller {
    public function id($userid = null) {
        if ($this->isLogged()){
            $this->load->model('UserModel');
			$user = new UserModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$userdata = $user->searchid($userid);
			$itens = count($user->getCount());
			
			$content = array("userdata" => $userdata);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/editausuario', $content);
			
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function atualizar(){
        if ($this->isLogged()){
            $this->load->model('UserModel');
			$user = new UserModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$userid = $this->input->post('userid');
			$username = $this->input->post('username');
			$userphone = $this->input->post('userphone');
			$useremail = $this->input->post('useremail');
			$userkey = $this->input->post('userkey');
			
			$item = $user->searchid($userid);
			
			if($item){
			    if($useremail == $item['useremail']){
			        $userdata['userid'] = $userid;
        			$userdata['username'] = $username;
        			$userdata['useremail'] = $useremail;
        			$userdata['userphone'] = $userphone;
        			$userdata['userkey'] = $userkey;
        			$userdata['userpassword'] = $item['userpassword'];
        			$userdata['userstatus'] = $item['userstatus'];
        			
        			if($user->update($userdata)){
        			    redirect(base_url('usuarios')); // usuario atualizado
        			}
			    } else {
			        if($user->searchemail($useremail)){
			            redirect(base_url('usuarios')); // email ja existe
			        } else {
			            $userdata['userid'] = $userid;
            			$userdata['username'] = $username;
            			$userdata['useremail'] = $useremail;
            			$userdata['userphone'] = $userphone;
            			$userdata['userkey'] = $userkey;
            			$userdata['userpassword'] = $item['userpassword'];
            			$userdata['userstatus'] = $item['userstatus'];
            			
            			if($user->update($userdata)){
            			    redirect(base_url('usuarios')); // usuario atualizado
            			}
			        }
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