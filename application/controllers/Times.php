<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Times extends CI_Controller {
	
	public function index() {
        if ($this->isLogged()){
			$this->load->model('TeamModel');
			$team = new TeamModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$listing = $team->listview();
			
            $content = array("teams" => $listing);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/teams', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function pesquisar() {
        if ($this->isLogged()){
			$this->load->model('TeamModel');
			$team = new TeamModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$searchlabel = $this->input->post("searchlabel");
			
			$listing = $team->specific($searchlabel);
			
            $content = array("teams" => $listing);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/teams', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function remover($teamid = null) {
        if ($this->isLogged()){
            $this->load->model('TeamModel');
			$this->load->model('CartModel');
            $team = new TeamModel();
			$cart = new CartModel();
            
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$teamitem = $team->search($teamid);
            
            $teamdata['teamid'] = $teamitem['teamid'];
            $teamdata['teamuser'] = $teamitem['teamuser'];
            $teamdata['teamname'] = $teamitem['teamname'];
            $teamdata['teamcoach'] = $teamitem['teamcoach'];
            $teamdata['teamslug'] = $teamitem['teamslug'];
            $teamdata['teamshield'] = $teamitem['teamshield'];
            $teamdata['teamstatus'] = 0;
            
            if($team->update($teamdata)){
                $cartaux = $cart->listremove($teamid);
                
                foreach($cartaux as $carrinho){
                    $cart->delete($carrinho->cartid);
                }
                
				$listing = $team->listview();
    			
    			$alert = array(
    				"class" => "info",
    				"message" => "Time removido");
    			
    			$content = array("teams" => $listing, "alert" => $alert);
    			
    			$this->load->view('template/super/headermenu', $info);
    			$this->load->view('super/teams', $content);
			}
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function usuario($userid = null) {
        if ($this->isLogged()){
            $this->load->model('TeamModel');
            $this->load->model('UserModel');
            $team = new TeamModel();
            $user = new UserModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$teamdata = $team->listinguser($userid);
			$userdata = $user->searchid($userid);
			$content = array("teams" => $teamdata, "user" => $userdata);
			
			$this->load->view('template/super/headermenu', $info);
			$this->load->view('super/teams', $content);
            
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function atualizar($teamid = null) {
        if ($this->isLogged()){
            $this->load->model('TeamModel');
            $team = new TeamModel();
            
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
				$listing = $team->listview();
    			
    			$alert = array(
    				"class" => "success",
    				"message" => "Time atualizado");
    			
    			$content = array("teams" => $listing, "alert" => $alert);
    			
    			$this->load->view('template/super/headermenu', $info);
    			$this->load->view('super/teams', $content);
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
			"pageid" => 4,
			"notifications" => $notifications,
			"countnotify" => count($countnotify),
			"requests" => $requests,
			"countrequests" => count($countrequests)
		);
    }
}