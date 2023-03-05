<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Novotime extends CI_Controller {

    public function usuario($userid = null) {
        if ($this->isLogged()){
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
            
            $content = array("userid" => $userid);
			
			$this->load->view('template/super/headermenu', $info);
			$this->load->view('super/addteam', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function pesquisar() {
        if ($this->isLogged()){
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
            $userid = $this->input->post("userid");
            $searchlabel = $this->input->post("searchlabel");
            $newlabel = preg_replace('/[ -]+/' , '%20' , $searchlabel);
            
            $json = $this->searchteams($newlabel);
            
            $content = array("userid" => $userid, "teams" => $json);
			
			$this->load->view('template/super/headermenu', $info);
			$this->load->view('super/addteam', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function searchteams($team=null) {
        
        $url = 'https://api.cartola.globo.com/times?q='.$team;
        
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

    public function escolher($parameter) {
        if ($this->isLogged()){			
			
            $this->load->model('TeamModel');
            $team = new TeamModel();
            
            $exp = explode("-", $parameter);
            $userid = $exp[0];
            $teamid = $exp[1];
			
			$json = $this->select($teamid);
			$selected = $json['time'];
            
            $teamdata['teamid'] = $selected['time_id'];
            $teamdata['teamuser'] = $userid;
            $teamdata['teamname'] = $selected['nome'];
            $teamdata['teamcoach'] = $selected['nome_cartola'];
            $teamdata['teamslug'] = $selected['slug'];
            $teamdata['teamshield'] = $selected['url_escudo_svg'];
            $teamdata['teamstatus'] = 1;
            
            $restriction = $team->search($teamdata['teamid']);
            
            if($restriction == null){
                if($team->save($teamdata)){
					redirect(base_url('usuario/id/'.$userid));
                }
            } else {
				if($restriction['teamuser']){
					if($restriction['teamuser'] == $userid){
						if($team->update($teamdata)){
					        redirect(base_url('usuario/id/'.$userid));
						}
					} else {
					    if($restriction['teamstatus'] == 0){
					        if($team->update($teamdata)){
    					        redirect(base_url('usuario/id/'.$userid));
    						}
					    } else {
					        redirect(base_url('usuario/id/'.$userid));
					    }
					}
				} else {
					if($team->update($teamdata)){
						redirect(base_url('usuario/id/'.$userid));
					}
				}
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
