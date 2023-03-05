<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sacar extends CI_Controller {

    public function id($userid = null) {
        if ($this->isLogged()){
			$this->load->model('WalletModel');
			$wallet = new WalletModel();
			
            $getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$walletinfo = $wallet->search($userid);
					
            $content = array("walletinfo" => $walletinfo);
            
            $this->load->view('template/super/headermenu', $info);
			$this->load->view('super/cashout', $content);
        }else{
            redirect(base_url('login'));
        }
    }

    public function finalizar() {
        if ($this->isLogged()){
            $config = $this->getConfig();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
			$this->load->model('WalletModel');
			$this->load->model('BalanceModel');
			$this->load->model('FTRModel');
			$wallet = new WalletModel();
			$balance = new BalanceModel();
			$ftr = new FTRModel();
			
			
            $getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$fo_user = $this->input->post('fo_user');
			$fo_value = $this->input->post('fo_value');
			
			if($fo_value > 0){
			    if($this->upload->do_upload('fo_attach')){
			        
                    $imginfo = $this->upload->data();
                    $fo_attach = $imginfo['file_name'];
                    
                    $walletitem = $wallet->search($fo_user);
			        
			        if($walletitem['wallet_free'] >= $fo_value){
			            $walletdata['wallet_id'] = $walletitem['wallet_id'];
            		    $walletdata['wallet_user'] = $walletitem['wallet_user'];
            		    $walletdata['wallet_balance'] = $walletitem['wallet_balance'] - $fo_value;
            		    $walletdata['wallet_free'] = $walletitem['wallet_free'] - $fo_value;
            		    $walletdata['wallet_gift'] = $walletitem['wallet_gift'];
            		    
            		    if($wallet->update($walletdata)){
            		        
            		        date_default_timezone_set('America/Sao_Paulo');
            		        
            		        $ftrdata['ftr_id'] = null;
            		        $ftrdata['ftr_type'] = 2; // 1-deposito # 2-saque # 3-inscrição # 4-premiação
            		        $ftrdata['ftr_mode'] = 0; // 0-cash # 1-bonus
            		        $ftrdata['ftr_date'] = date('Y-m-d H:i:s');
            		        $ftrdata['ftr_user'] = $fo_user;
            		        $ftrdata['ftr_super'] = $this->session->userdata('superid');
            		        $ftrdata['ftr_value'] = $fo_value;
            		        $ftrdata['ftr_attachment'] = $fo_attach;
            		        $ftrdata['ftr_validator'] = $this->validgen($ftrdata);
            		        
            		        if($ftr->save($ftrdata)){
        		            
            		            $balanceitem = $balance->searchsuper($this->session->userdata('superid'));
        			    
                			    if($balanceitem){
                			        $balancedata['balanceid'] = $balanceitem['balanceid'];
                			        $balancedata['balancesuper'] = $balanceitem['balancesuper'];
                			        $balancedata['balancepend'] = $balanceitem['balancepend'];
                			        $balancedata['balanceconf'] = $balanceitem['balanceconf']-$fo_value;
                			        $balancedata['balancetotal'] = $balanceitem['balancetotal']-$fo_value;
                			        $balancedata['balancestatus'] = $balanceitem['balancestatus'];
                			        
                			        if($balance->update($balancedata)){
                    			        redirect(base_url('carteira/id/'.$fo_user));
                			        }
                			    }
            		            
            		        }
            		    }
			        } else {
			            $walletinfo = $wallet->search($fo_user);
			            
			            $alert = array(
    						"class" => "warning",
    						"message" => "Saldo insuficiente");
					
                        $content = array(
                            "walletinfo" => $walletinfo,
                            "alert" => $alert);
                            
                        $this->load->view('template/super/headermenu', $info);
            			$this->load->view('super/cashout', $content);
			        }
			        
        			
                    
                }else{
    				echo $this->upload->display_errors();
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
			"pageid" => 3,
			"notifications" => $notifications,
			"countnotify" => count($countnotify),
			"requests" => $requests,
			"countrequests" => count($countrequests)
		);
    }
}