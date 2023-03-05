<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscrever extends CI_Controller {
    public function usuario($userid = null) {
        if ($this->isLogged()){
            $this->load->model('TeamModel');
            $team = new TeamModel();
            
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$teams = $team->listinguser($userid);
            
            $content = array("userid" => $userid, "teams" => $teams);
			
			$this->load->view('template/super/headermenu', $info);
			$this->load->view('super/subscribe', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function rodadas() {
        if ($this->isLogged()){
            $this->load->model('TeamModel');
			$this->load->model('RegistryModel');
			$this->load->model('SpinModel');
            $team = new TeamModel();
			$registry = new RegistryModel();
			$spin = new SpinModel();
            
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$userid = $this->input->post("userid");
			$teamcheck = $this->input->post("teamcheck");
			
			$phase = 0;
			$restrictions = 0;
			if($teamcheck){
			    $phase = 1;
    			foreach($teamcheck as $tcheck){
    			    $tcaux = $registry->listrestrict($tcheck);
    			    $restrictions += count($tcaux);
    			}
			} else {
			    redirect(base_url('inscrever/usuario/'.$userid));
			}
			
			$alert = null;
			if($restrictions > 0){
    			if($restrictions == 1){
        			$alert = array(
        				"class" => "warning",
        				"message" => "Já existe ".$restrictions." registro de inscrição entre os times selecionados. Esteja atento!");
    			} else {
        			$alert = array(
        				"class" => "warning",
        				"message" => "Já existem ".$restrictions." registros de inscrição entre os times selecionados. Esteja atento!");
    			}
			}
			
			$listspin = $spin->waiting();
			
			$status = $this->getstatus();
            
            $content = array(
                "userid" => $userid, 
                "teamcheck" => $teamcheck, 
                "spins" => $listspin, 
                "phase" => $phase, 
                "alert" => $alert,
                "status" => $status);
			
			$this->load->view('template/super/headermenu', $info);
			$this->load->view('super/subscribe', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function tipo() {
        if ($this->isLogged()){
            $this->load->model('TeamModel');
			$this->load->model('RegistryModel');
			$this->load->model('SpinModel');
            $team = new TeamModel();
			$registry = new RegistryModel();
			$spin = new SpinModel();
            
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$userid = $this->input->post("userid");
			$teamcheck = $this->input->post("teamcheck");
			$spincheck = $this->input->post("spincheck");
			
			$restrictions = 0;
			foreach($teamcheck as $tcheck){
			    foreach($spincheck as $scheck){
			        $tsaux = $registry->getreg($tcheck, $scheck);
			        if($tsaux){
			            $restrictions ++;
			        }
			    }
			}
			$alert = null;
			if($restrictions > 0){
    			$alert = array(
    				"class" => "warning",
    				"message" => "Já temos algum dos times selecionados inscrito em pelo menos uma das rodadas escolhidas. Os times já inscritos serão removidos para continuarmos a inscrição.");
			}
			
			if($teamcheck){
			    if($spincheck){
    			    $phase = 2;
    			} else {
    			    redirect(base_url());
    			}
			} else {
			    redirect(base_url());
			}
            
            $content = array(
                "userid" => $userid, 
                "teamcheck" => $teamcheck, 
                "spincheck" => $spincheck, 
                "phase" => $phase, 
                "alert" => $alert);
			
			$this->load->view('template/super/headermenu', $info);
			$this->load->view('super/subscribe', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function fonte() {
        if ($this->isLogged()){
            $this->load->model('TeamModel');
			$this->load->model('SpinModel');
			$this->load->model('WalletModel');
			$this->load->model('RegistryModel');
            $team = new TeamModel();
			$spin = new SpinModel();
			$wallet = new WalletModel();
			$registry = new RegistryModel();
            
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$userid = $this->input->post("userid");
			$teamcheck = $this->input->post("teamcheck");
			$spincheck = $this->input->post("spincheck");
			$paidtype = $this->input->post("paidtype");
			$walletinfo = $wallet->search($userid);
			$total = 0;
			
			if($teamcheck){
			    if($spincheck){
    			    if($paidtype){
    			        $restrictions = 0;
            			foreach($teamcheck as $tcheck){
            			    foreach($spincheck as $scheck){
            			        $tsaux = $registry->getreg($tcheck, $scheck);
            			        if($tsaux){
            			            $restrictions ++;
            			        }
            			    }
            			}
            			$alert = null;
            			if($restrictions > 0){
                			$alert = array(
                				"class" => "warning",
                				"message" => "Algumas seleções foram removidas pois já constam como times inscritos. Por favor, verifique a situação.");
            			} 
    			        if($paidtype == 2){
    			            $nteams = count($teamcheck);
    			            $nspins = count($spincheck);
    			            
    			            $total = (($nteams*$nspins)-$restrictions)*10;
    			            
    			            
        			        $phase = 3;
    			        } else {
    			            
    			            $this->subsfree($teamcheck, $spincheck);
    			            
    			            $phase = 5;
    			        }
        			} else {
        			    redirect(base_url());
        			}
    			} else {
    			    redirect(base_url());
    			}
			} else {
			    redirect(base_url());
			}
            
            $content = array(
                "userid" => $userid, 
                "teamcheck" => $teamcheck, 
                "spincheck" => $spincheck, 
                "paidtype" => $paidtype, 
                "phase" => $phase, 
                "total" => $total,
			    "walletinfo" => $walletinfo, 
                "alert" => $alert);
			
			$this->load->view('template/super/headermenu', $info);
			$this->load->view('super/subscribe', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function comprovante() {
        if ($this->isLogged()){
            $this->load->model('TeamModel');
			$this->load->model('SpinModel');
			$this->load->model('WalletModel');
			$this->load->model('RegistryModel');
            $team = new TeamModel();
			$spin = new SpinModel();
			$wallet = new WalletModel();
			$registry = new RegistryModel();
            
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$userid = $this->input->post("userid");
			$paidtype = $this->input->post("paidtype");
			$teamcheck = $this->input->post("teamcheck");
			$spincheck = $this->input->post("spincheck");
			$paidfont = $this->input->post("paidfont");
			
			$walletinfo = $wallet->search($userid);
			$total = 0;
			
			if($teamcheck){
			    if($spincheck){
    			    if($paidtype){
    			        $restrictions = 0;
            			foreach($teamcheck as $tcheck){
            			    foreach($spincheck as $scheck){
            			        $tsaux = $registry->getreg($tcheck, $scheck);
            			        if($tsaux){
            			            $restrictions ++;
            			        }
            			    }
            			}
            			$alert = null;
            			if($restrictions > 0){
                			$alert = array(
                				"class" => "warning",
                				"message" => "Algumas seleções foram removidas pois já constam como times inscritos. Por favor, verifique a situação.");
            			} 
    			        if($paidtype == 2){
    			            if($paidfont == 2){
        			            $nteams = count($teamcheck);
        			            $nspins = count($spincheck);
    			                $total = (($nteams*$nspins)-$restrictions)*10;
    			                
    			                if($total == 0){
        			                redirect(base_url('inscrever/usuario/'.$userid));
    			                } else{
            			            $phase = 4;
    			                }
        			        } else {
        			            $nteams = count($teamcheck);
        			            $nspins = count($spincheck);
    			                $total = (($nteams*$nspins)-$restrictions)*10;
        			            
        			            if($walletinfo['wallet_balance'] >= $total){
        			            
            			            $attachment = null;
            			            if($this->subspaid($userid, $teamcheck, $spincheck, $attachment)){
            			                 $phase = 5;
            			            } else {
            			                redirect(base_url());
            			            }
        			            } else {
        			                redirect(base_url('inscrever/usuario/'.$userid));
        			            }
        			        }
    			        } else {
    			            redirect(base_url());
    			        }
        			} else {
        			    redirect(base_url());
        			}
    			} else {
    			    redirect(base_url());
    			}
			} else {
			    redirect(base_url());
			}
            
            $content = array(
                "userid" => $userid, 
                "teamcheck" => $teamcheck, 
                "spincheck" => $spincheck, 
                "paidtype" => $paidtype, 
                "phase" => $phase, 
                "total" => $total,
			    "walletinfo" => $walletinfo, 
                "alert" => $alert);
			
			$this->load->view('template/super/headermenu', $info);
			$this->load->view('super/subscribe', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function finalizar() {
        if ($this->isLogged()){
			$config = $this->getConfig();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            $this->load->model('TeamModel');
			$this->load->model('SpinModel');
			$this->load->model('WalletModel');
            $team = new TeamModel();
			$spin = new SpinModel();
			$wallet = new WalletModel();
            
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$userid = $this->input->post("userid");
			$paidtype = $this->input->post("paidtype");
			$teamcheck = $this->input->post("teamcheck");
			$spincheck = $this->input->post("spincheck");
			
			$walletinfo = $wallet->search($userid);
			$total = 0;
			
			if($teamcheck){
			    if($spincheck){
			        
		            $attachment = null;
			        
			        if($this->upload->do_upload('attachment')){
                        $imginfo = $this->upload->data();
                        $attachment = $imginfo['file_name'];
                    }else{
        				echo $this->upload->display_errors();
        			}
		            if($this->subspaid($userid, $teamcheck, $spincheck, $attachment)){
		                 $phase = 5;
		            } else {
	                    redirect(base_url());
		            }
    			} else {
    			    redirect(base_url());
    			}
			} else {
			    redirect(base_url());
			}
            
            $content = array(
                "userid" => $userid, 
                "teamcheck" => $teamcheck, 
                "spincheck" => $spincheck, 
                "paidtype" => $paidtype, 
                "phase" => $phase, 
                "total" => $total,
			    "walletinfo" => $walletinfo);
			
			$this->load->view('template/super/headermenu', $info);
			$this->load->view('super/subscribe', $content);
        }else{
            redirect(base_url('login'));
        }
    }
	
	public function subsfree($teamcheck, $spincheck){
        if ($this->isLogged()){
			$this->load->model('TeamModel');
			$this->load->model('RegistryModel');
			$this->load->model('SpinModel');
			$this->load->model('CartModel');
            $team = new TeamModel();
			$registry = new RegistryModel();
			$spin = new SpinModel();
			$cart = new CartModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			foreach($teamcheck as $teamitem){
			    foreach($spincheck as $spinitem){
			        $tsaux = $registry->getreg($teamitem, $spinitem);
			        
			        if(!$tsaux){
    			        $regdata['registryid'] = null;
    					$regdata['registryteam'] = $teamitem;
    					$regdata['registryspin'] = $spinitem;
    					$regdata['registrysuper'] = $this->session->userdata('superid');
    					$regdata['registrypaid'] = 0;
    					
    					if($registry->save($regdata)){
    						$spinaux = $spin->search($spinitem);
    						
    						$spindata['spinid'] = $spinaux['spinid'];
    						$spindata['numteams'] = $spinaux['numteams']+1;
    						$spindata['status'] = $spinaux['status'];
    						
    						$spin->update($spindata);
    						
    						$cartaux = $cart->getrestrict($spinitem, $teamitem);
                
                            if($cartaux){
                                $cart->delete($cartaux['cartid']);
                            }
    					}
			        }
			    }
			}
			return true;
		}else{
            redirect(base_url('login'));
        }
	}
	
	public function subspaid($userid, $teamcheck, $spincheck, $attachment){
        if ($this->isLogged()){
			$this->load->model('TeamModel');
			$this->load->model('RegistryModel');
			$this->load->model('SpinModel');
			$this->load->model('PaidModel');
			$this->load->model('BalanceModel');
			$this->load->model('FTRModel');
			$this->load->model('WalletModel');
			$this->load->model('CartModel');
			$wallet = new WalletModel();
            $team = new TeamModel();
			$registry = new RegistryModel();
			$spin = new SpinModel();
			$paid = new PaidModel();
			$ftr = new FTRModel();
			$balance = new BalanceModel();
			$cart = new CartModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$restrictions = 0;
			foreach($teamcheck as $teamitem){
			    foreach($spincheck as $spinitem){
			        $tsaux = $registry->getreg($teamitem, $spinitem);
			        
			        if($tsaux){
			            $restrictions ++;
			        } else {
    			        $regdata['registryid'] = null;
    					$regdata['registryteam'] = $teamitem;
    					$regdata['registryspin'] = $spinitem;
    					$regdata['registrysuper'] = $this->session->userdata('superid');
    					$regdata['registrypaid'] = 1;
    					
    					if($registry->save($regdata)){
    						$spinaux = $spin->search($spinitem);
    						$paidaux = $paid->searchproduct($spinitem);
    						
    						$spindata['spinid'] = $spinaux['spinid'];
    						$spindata['numteams'] = $spinaux['numteams']+1;
    						$spindata['status'] = $spinaux['status'];
    						
    						$paiddata['paidid'] = $paidaux['paidid'];
    						$paiddata['paidproduct'] = $paidaux['paidproduct'];
    						$paiddata['paidteams'] = $paidaux['paidteams']+1;
    						$paiddata['paidstatus'] = $paidaux['paidstatus'];
    						
    						$spin->update($spindata);
    						$paid->update($paiddata);
    						
    						$cartaux = $cart->getrestrict($spinitem, $teamitem);
                
                            if($cartaux){
                                $cart->delete($cartaux['cartid']);
                            }
    					}
			        }
			    }
			}
			
			$nteams = count($teamcheck);
            $nspins = count($spincheck);
            
            $total = (($nteams*$nspins)-$restrictions)*10;
			
			date_default_timezone_set('America/Sao_Paulo');
        		        
	        $ftrdata['ftr_id'] = null;
	        $ftrdata['ftr_type'] = 3; // 1-deposito # 2-saque # 3-inscrição # 4-premiação
	        $ftrdata['ftr_mode'] = 1; // 0-cash # 1-bonus
	        $ftrdata['ftr_date'] = date('Y-m-d H:i:s');
	        $ftrdata['ftr_user'] = $userid;
	        $ftrdata['ftr_super'] = $this->session->userdata('superid');
	        $ftrdata['ftr_value'] = $total;
	        $ftrdata['ftr_attachment'] = $attachment;
	        $ftrdata['ftr_validator'] = $this->validgen($ftrdata);
	        
	        if($ftr->save($ftrdata)){
	            if($attachment == null){
	                $walletitem = $wallet->search($userid);
                    if($walletitem['wallet_balance'] >= $total){
                        if($walletitem['wallet_gift'] >= $total){
                            $walletdata['wallet_id'] = $walletitem['wallet_id'];
                            $walletdata['wallet_user'] = $walletitem['wallet_user'];
                            $walletdata['wallet_balance'] = $walletitem['wallet_balance'] - $total;
                            $walletdata['wallet_free'] = $walletitem['wallet_free'];
                            $walletdata['wallet_gift'] = $walletitem['wallet_gift'] - $total;
                            
                            if($wallet->update($walletdata)){
                                return true;
                            }
                        } else {
                            $walletdata['wallet_id'] = $walletitem['wallet_id'];
                            $walletdata['wallet_user'] = $walletitem['wallet_user'];
                            $walletdata['wallet_balance'] = $walletitem['wallet_balance'] - $total;
                            $total = $total - $walletitem['wallet_gift'];
                            $walletdata['wallet_free'] = $walletitem['wallet_free'] - $total;
                            $walletdata['wallet_gift'] = 0;
                            
                            if($wallet->update($walletdata)){
                                return true;
                            }
                        }
                    } else {
                        return false;
                    }
	            } else {
	                // atualizo balance do super
	                $balanceitem = $balance->searchsuper($this->session->userdata('superid'));
	                
	                if($balanceitem){
	                    $balancedata['balanceid'] = $balanceitem['balanceid'];
    			        $balancedata['balancesuper'] = $balanceitem['balancesuper'];
    			        $balancedata['balancepend'] = $balanceitem['balancepend'];
    			        $balancedata['balanceconf'] = $balanceitem['balanceconf'] + $total;
    			        $balancedata['balancetotal'] = $balanceitem['balancetotal'] + $total;
    			        $balancedata['balancestatus'] = $balanceitem['balancestatus'];
    			        
    			        if($balance->update($balancedata)){
                            return true;
                        }
	                }
	            }
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
	
	public function getConfig(){
		$config = array(
			"upload_path" => "assets/comprovantes",
			"allowed_types" => "jpg|jpeg|png|pdf",
			"encrypt_name" => true
		);
		
		return $config;
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