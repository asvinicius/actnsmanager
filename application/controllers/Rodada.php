<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rodada extends CI_Controller {
	public function id($spinid) {
        if ($this->isLogged()){
			$this->load->model('SpinModel');
			$this->load->model('PaidModel');
            $this->load->model('RegistryModel');
            $registry = new RegistryModel();
            $spin = new SpinModel();
            $paid = new PaidModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$reglisting = $registry->listing($spinid);
			$spindata = $spin->search($spinid);
			
			$content = array(
			    "teams" => $reglisting,
			    "spin" => $spinid,
			    "spindata" => $spindata);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/spindetail', $content);
			
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function lista($spinid) {
        if ($this->isLogged()){
			$this->load->model('SpinModel');
			$this->load->model('PaidModel');
            $this->load->model('RegistryModel');
            $registry = new RegistryModel();
            $spin = new SpinModel();
            $paid = new PaidModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$regdata = $registry->listspin($spinid);
			$status = $this->getstatus();
			
			if($status['fechamento']['dia'] > 9){
                $day = $status['fechamento']['dia'];
            }else{
                $day = $status['fechamento']['dia'];
            }
            if($status['fechamento']['mes'] > 9){
                $month = $status['fechamento']['mes'];
            }else{
                $month = $status['fechamento']['mes'];
            }
            if($status['fechamento']['hora'] > 10){
                $hour = $status['fechamento']['hora']-1;
            }else{
                $hour = $status['fechamento']['hora']-1;
            }
            if($status['fechamento']['minuto'] > 9){
                $minute = $status['fechamento']['minuto'];
            }else{
                $minute = $status['fechamento']['minuto'];
            }
			
            $content = array(
				"regdata" => $regdata, 
				"spin" => $spinid, 
				"status" => $status, 
				"day" => $day, 
				"month" => $month,
				"hour" => $hour,
				"minute" => $minute);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/listspin', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
	public function pesquisar() {
        if ($this->isLogged()){
			$this->load->model('SpinModel');
			$this->load->model('PaidModel');
            $this->load->model('RegistryModel');
            $registry = new RegistryModel();
            $spin = new SpinModel();
            $paid = new PaidModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$searchlabel = $this->input->post("searchlabel");
			$spinid = $this->input->post("spin");
			
			if($searchlabel){
    			$reglisting = $registry->spin($searchlabel, $spinid);
    			$spindata = $spin->search($spinid);
			} else{
			    if($spinid){
        			$reglisting = $registry->listing($spinid);
        			$spindata = $spin->search($spinid);
			    } else {
			        redirect(base_url('rodadas'));
			    }
			}
			
			$content = array(
			    "teams" => $reglisting,
			    "spin" => $spinid,
			    "spindata" => $spindata);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/spindetail', $content);
			
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function remover($parameter){
        if ($this->isLogged()){
			$this->load->model('TeamModel');
			$this->load->model('RegistryModel');
			$this->load->model('SpinModel');
			$this->load->model('PaidModel');
			$this->load->model('FTRModel');
			$this->load->model('WalletModel');
			$wallet = new WalletModel();
            $team = new TeamModel();
			$registry = new RegistryModel();
			$spin = new SpinModel();
			$paid = new PaidModel();
			$ftr = new FTRModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$exp = explode("-", $parameter);
            $spinid = $exp[0];
            $teamid = $exp[1];
			
			$teamitem = $team->search($teamid);
			$regitem = $registry->getreg($teamid, $spinid);
			$walletitem = $wallet->search($teamitem['teamuser']);
			$status = $this->getstatus();
			
			if($spinid >= $status['rodada_atual']){
			    if($status['status_mercado'] == 1){
    			    if($regitem){
    			        if($registry->delete($regitem['registryid'])){
    			            
    			            $spinaux = $spin->search($spinid);
    			            
    			            $spindata['spinid'] = $spinaux['spinid'];
        					$spindata['numteams'] = $spinaux['numteams']-1;
        					$spindata['status'] = $spinaux['status'];
        					
        					$spin->update($spindata);
    			            
    			        	if($regitem['registrypaid'] == 1){
    			        	    $paidaux = $paid->searchproduct($spinid);
    			        	    
    			        	    $paiddata['paidid'] = $paidaux['paidid'];
            					$paiddata['paidproduct'] = $paidaux['paidproduct'];
            					$paiddata['paidteams'] = $paidaux['paidteams']-1;
            					$paiddata['paidstatus'] = $paidaux['paidstatus'];
            					
            					$paid->update($paiddata);
            					
            					date_default_timezone_set('America/Sao_Paulo');
        		        
                    	        $ftrdata['ftr_id'] = null;
                    	        $ftrdata['ftr_type'] = 5; // 1-deposito # 2-saque # 3-inscrição # 4-premiação # 5-cancelamento de inscr
                    	        $ftrdata['ftr_mode'] = 0; // 0-cash # 1-bonus
                    	        $ftrdata['ftr_date'] = date('Y-m-d H:i:s');
                    	        $ftrdata['ftr_user'] = $teamitem['teamuser'];
                    	        $ftrdata['ftr_super'] = $this->session->userdata('superid');
                    	        $ftrdata['ftr_value'] = 10;
                    	        $ftrdata['ftr_attachment'] = null;
                    	        $ftrdata['ftr_validator'] = $this->validgen($ftrdata);
                    	        
                    	        $ftr->save($ftrdata);
                    	        
                    	        $walletdata['wallet_id'] = $walletitem['wallet_id'];
                                $walletdata['wallet_user'] = $walletitem['wallet_user'];
                                $walletdata['wallet_balance'] = $walletitem['wallet_balance'] + 10;
                                $walletdata['wallet_free'] = $walletitem['wallet_free'] + 10;
                                $walletdata['wallet_gift'] = $walletitem['wallet_gift'];
                                
                                if($wallet->update($walletdata)){
                                    redirect(base_url('rodada/id/'.$spinid));
                                }
                    	        
    			        	} else {
                                redirect(base_url('rodada/id/'.$spinid));
    			        	}
    			        }
    			    } else {
    			        // O time escolhido não está inscrito na rodada
    			    }
    			    
    			} else {
    			    if($spinid == $status['rodada_atual']){
    			    
            			$reglisting = $registry->listing($spinid);
            			$spindata = $spin->search($spinid);
            			
            			$alert = array(
    						"class" => "danger",
    						"message" => "Não é possível remover times desta rodada pois o mercado está fechado. Tente novamente com o mercado aberto.");
            			
            			$content = array(
            			    "teams" => $reglisting,
            			    "spin" => $spinid,
            			    "spindata" => $spindata,
        			        "alert" => $alert);
            			
                        $this->load->view('template/super/headermenu', $info);
                        $this->load->view('super/spindetail', $content);
    			    } else {
    			        if($regitem){
        			        if($registry->delete($regitem['registryid'])){
        			            
        			            $spinaux = $spin->search($spinid);
        			            
        			            $spindata['spinid'] = $spinaux['spinid'];
            					$spindata['numteams'] = $spinaux['numteams']-1;
            					$spindata['status'] = $spinaux['status'];
            					
            					$spin->update($spindata);
        			            
        			        	if($regitem['registrypaid'] == 1){
        			        	    $paidaux = $paid->searchproduct($spinid);
        			        	    
        			        	    $paiddata['paidid'] = $paidaux['paidid'];
                					$paiddata['paidproduct'] = $paidaux['paidproduct'];
                					$paiddata['paidteams'] = $paidaux['paidteams']-1;
                					$paiddata['paidstatus'] = $paidaux['paidstatus'];
                					
                					$paid->update($paiddata);
                					
                					date_default_timezone_set('America/Sao_Paulo');
            		        
                        	        $ftrdata['ftr_id'] = null;
                        	        $ftrdata['ftr_type'] = 5; // 1-deposito # 2-saque # 3-inscrição # 4-premiação # 5-cancelamento de inscr
                        	        $ftrdata['ftr_mode'] = 0; // 0-cash # 1-bonus
                        	        $ftrdata['ftr_date'] = date('Y-m-d H:i:s');
                        	        $ftrdata['ftr_user'] = $teamitem['teamuser'];
                        	        $ftrdata['ftr_super'] = $this->session->userdata('superid');
                        	        $ftrdata['ftr_value'] = 10;
                        	        $ftrdata['ftr_attachment'] = null;
                        	        $ftrdata['ftr_validator'] = $this->validgen($ftrdata);
                        	        
                        	        $ftr->save($ftrdata);
                        	        
                        	        $walletdata['wallet_id'] = $walletitem['wallet_id'];
                                    $walletdata['wallet_user'] = $walletitem['wallet_user'];
                                    $walletdata['wallet_balance'] = $walletitem['wallet_balance'] + 10;
                                    $walletdata['wallet_free'] = $walletitem['wallet_free'] + 10;
                                    $walletdata['wallet_gift'] = $walletitem['wallet_gift'];
                                    
                                    if($wallet->update($walletdata)){
                                        redirect(base_url('rodada/id/'.$spinid));
                                    }
                        	        
        			        	} else {
                                    redirect(base_url('rodada/id/'.$spinid));
        			        	}
        			        }
        			    } else {
        			        // O time escolhido não está inscrito na rodada
        			    }
    			    }
    			}
			} else {
			    $reglisting = $registry->listing($spinid);
    			$spindata = $spin->search($spinid);
    			
    			$alert = array(
					"class" => "danger",
					"message" => "Não é possível remover times desta rodada pois ela já está encerrada.");
    			
    			$content = array(
    			    "teams" => $reglisting,
    			    "spin" => $spinid,
    			    "spindata" => $spindata,
    			    "alert" => $alert);
    			
                $this->load->view('template/super/headermenu', $info);
                $this->load->view('super/spindetail', $content);
			}
		}else{
            redirect(base_url('login'));
        }
	}
    
    function validgen($ftrdata){
        $partialone = md5($ftrdata['ftr_type']."!".$ftrdata['ftr_mode']);
        $partialtwo = md5($ftrdata['ftr_date']."@".$ftrdata['ftr_user']);
        $validator = md5($partialone."#".$ftrdata['ftr_value']."$".$partialtwo);
        
        return $validator;
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