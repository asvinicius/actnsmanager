<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {
    public function id($userid = null) {
        if ($this->isLogged()){
            $this->load->model('UserModel');
			$this->load->model('TeamModel');
			$this->load->model('WalletModel');
			$user = new UserModel();
			$team = new TeamModel();
			$wallet = new WalletModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$userdata = $user->searchid($userid);
			$userteams = $team->listinguser($userid);
			$walletinfo = $wallet->search($userid);
			
			$content = array(
			    "userdata" => $userdata, 
			    "teams" => $userteams,
			    "walletinfo" => $walletinfo);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/usuario', $content);
			
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function atualizartime($teamid = null) {
        if ($this->isLogged()){
            $this->load->model('UserModel');
			$this->load->model('TeamModel');
			$this->load->model('WalletModel');
			$user = new UserModel();
			$team = new TeamModel();
			$wallet = new WalletModel();
            
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$oldteam = $team->search($teamid);
            
            $json = $this->select($teamid);
            
            $newteam = $json['time'];
            
            $teamdata['teamid'] = $newteam['time_id'];
            $teamdata['teamuser'] = $oldteam['teamuser'];
            $teamdata['teamname'] = $newteam['nome'];
            $teamdata['teamcoach'] = $newteam['nome_cartola'];
            $teamdata['teamslug'] = $newteam['slug'];
            $teamdata['teamshield'] = $newteam['url_escudo_svg'];
            $teamdata['teamstatus'] = 1;
            
            if($team->update($teamdata)){
				$userdata = $user->searchid($oldteam['teamuser']);
    			$userteams = $team->listinguser($oldteam['teamuser']);
    			$walletinfo = $wallet->search($oldteam['teamuser']);
    			
    			$alert = array(
    				"class" => "success",
    				"message" => "Time atualizado");
    			
    			$content = array(
    			    "userdata" => $userdata, 
    			    "teams" => $userteams,
    			    "walletinfo" => $walletinfo, 
    			    "alert" => $alert);
    			
                $this->load->view('template/super/headermenu', $info);
                $this->load->view('super/usuario', $content);
			}
			
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function select($teamid=null) {
        
        $url = 'https://api.cartola.globo.com/time/id/'.$teamid;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER ,[
          'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36',
          'Content-Type: application/json',
        ]);
        $result = curl_exec($ch);
        
        if ($result === FALSE) {
            die(curl_error($ch));
        }
        
        curl_close($ch);
        
        $json = json_decode($result, true);
        
        return $json;
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