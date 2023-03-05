<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordemfinanc extends CI_Controller {
	public function id($fo_id) {
        if ($this->isLogged()){
			$this->load->model('FOModel');
			$fo = new FOModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$foitem = $fo->search($fo_id);
			
            $content = array("foitem" => $foitem);
			
            $this->load->view('template/super/headermenu', $info);
            $this->load->view('super/finrequest', $content);
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function confirmar($fo_id) {
        if ($this->isLogged()){
			$this->load->model('FOModel');
			$this->load->model('UserModel');
			$this->load->model('BalanceModel');
			$this->load->model('FTRModel');
			$this->load->model('WalletModel');
			$fo = new FOModel();
			$user = new UserModel();
			$balance = new BalanceModel();
			$ftr = new FTRModel();
			$wallet = new WalletModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$foitem = $fo->search($fo_id);
			
			if($foitem['fo_status'] == 1){
			    
			    if($foitem['fo_type'] == 1){
			        
					$walletitem = $wallet->search($foitem['fo_user']);
			
        			$walletdata['wallet_id'] = $walletitem['wallet_id'];
        		    $walletdata['wallet_user'] = $walletitem['wallet_user'];
        		    $walletdata['wallet_balance'] = $walletitem['wallet_balance']+$foitem['fo_value'];
        		    $walletdata['wallet_free'] = $walletitem['wallet_free']+$foitem['fo_value'];
        		    $walletdata['wallet_gift'] = $walletitem['wallet_gift'];
        		    
        		    if($wallet->update($walletdata)){
					    
					    date_default_timezone_set('America/Sao_Paulo');
        		        
        		        $ftrdata['ftr_id'] = null;
        		        $ftrdata['ftr_type'] = 1; // 1-deposito # 2-saque # 3-inscrição # 4-premiação
        		        $ftrdata['ftr_mode'] = 0; // 0-cash # 1-bonus
        		        $ftrdata['ftr_date'] = date('Y-m-d H:i:s');
        		        $ftrdata['ftr_user'] = $foitem['fo_user'];
        		        $ftrdata['ftr_super'] = $this->session->userdata('superid');
        		        $ftrdata['ftr_value'] = $foitem['fo_value'];
        		        $ftrdata['ftr_attachment'] = $foitem['fo_attach'];
        		        $ftrdata['ftr_validator'] = $this->validgen($ftrdata);
        		        
        		        if($ftr->save($ftrdata)){
        		            
        		            $balanceitem = $balance->searchsuper($this->session->userdata('superid'));
    			    
            			    if($balanceitem){
            			        $balancedata['balanceid'] = $balanceitem['balanceid'];
            			        $balancedata['balancesuper'] = $balanceitem['balancesuper'];
            			        $balancedata['balancepend'] = $balanceitem['balancepend']-$foitem['fo_value'];
            			        $balancedata['balanceconf'] = $balanceitem['balanceconf']+$foitem['fo_value'];
            			        $balancedata['balancetotal'] = $balanceitem['balancetotal'];
            			        $balancedata['balancestatus'] = $balanceitem['balancestatus'];
            			        
            			        if($balance->update($balancedata)){
            			            
            			            $fodata['fo_id'] = $foitem['fo_id'];
            			            $fodata['fo_user'] = $foitem['fo_user'];
            			            $fodata['fo_super'] = $foitem['fo_super'];
            			            $fodata['fo_value'] = $foitem['fo_value'];
            			            $fodata['fo_type'] = $foitem['fo_type'];
            			            $fodata['fo_attach'] = $foitem['fo_attach'];
            			            $fodata['fo_date'] = $foitem['fo_date'];
            			            $fodata['fo_status'] = 0;
            			            
            			            if($fo->update($fodata)){
            						    $useritem = $user->searchid($foitem['fo_user']);
            						    if($this->sendmail($useritem)){
                							redirect(base_url('solicitacoes'));
                						}
            			            }
            			        }
            			    }
        		        }
					}
			    } else {
			        $content = array("foitem" => $foitem);
			
                    $this->load->view('template/super/headermenu', $info);
                    $this->load->view('super/financialconf', $content);
			    }
			} else {
				redirect(base_url('solicitacoes'));
			}
        } else {
            redirect(base_url('login'));
        }
    }
    
    public function confsaque(){
        if ($this->isLogged()){
			$config = $this->getConfig();
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
			$this->load->model('FOModel');
			$this->load->model('UserModel');
			$this->load->model('BalanceModel');
			$this->load->model('FTRModel');
			$fo = new FOModel();
			$user = new UserModel();
			$balance = new BalanceModel();
			$ftr = new FTRModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$fo_id = $this->input->post('fo_id');
			$fo_attach = null;
			
			$foitem = $fo->search($fo_id);
			
			if($foitem){
			    if($foitem['fo_status'] == 1){
    			    if($this->upload->do_upload('fo_attach')){
                        $imginfo = $this->upload->data();
                        $fo_attach = $imginfo['file_name'];
                    }else{
        				echo $this->upload->display_errors();
        			}
        			
        			date_default_timezone_set('America/Sao_Paulo');
            		        
    		        $ftrdata['ftr_id'] = null;
    		        $ftrdata['ftr_type'] = 2; // 1-deposito # 2-saque # 3-inscrição # 4-premiação
    		        $ftrdata['ftr_mode'] = 0; // 0-cash # 1-bonus
    		        $ftrdata['ftr_date'] = date('Y-m-d H:i:s');
    		        $ftrdata['ftr_user'] = $foitem['fo_user'];
    		        $ftrdata['ftr_super'] = $this->session->userdata('superid');
    		        $ftrdata['ftr_value'] = $foitem['fo_value'];
    		        $ftrdata['ftr_attachment'] = $fo_attach;
    		        $ftrdata['ftr_validator'] = $this->validgen($ftrdata);
    		        
    		        if($ftr->save($ftrdata)){
    		            
    		            $balanceitem = $balance->searchsuper($this->session->userdata('superid'));
    		    
        			    if($balanceitem){
        			        $balancedata['balanceid'] = $balanceitem['balanceid'];
        			        $balancedata['balancesuper'] = $balanceitem['balancesuper'];
        			        $balancedata['balancepend'] = $balanceitem['balancepend']+$foitem['fo_value'];
        			        $balancedata['balanceconf'] = $balanceitem['balanceconf']-$foitem['fo_value'];
        			        $balancedata['balancetotal'] = $balanceitem['balancetotal'];
        			        $balancedata['balancestatus'] = $balanceitem['balancestatus'];
        			        
        			        if($balance->update($balancedata)){
        			            
        			            $fodata['fo_id'] = $foitem['fo_id'];
        			            $fodata['fo_user'] = $foitem['fo_user'];
        			            $fodata['fo_super'] = $foitem['fo_super'];
        			            $fodata['fo_value'] = $foitem['fo_value'];
        			            $fodata['fo_type'] = $foitem['fo_type'];
        			            $fodata['fo_attach'] = $fo_attach;
        			            $fodata['fo_date'] = $foitem['fo_date'];
        			            $fodata['fo_status'] = 0;
        			            
        			            if($fo->update($fodata)){
        						    redirect(base_url('solicitacoes'));
        			            }
        			        }
        			    }
    		        }
			    }
			}
        }
    }
    
    public function recusar($fo_id) {
        if ($this->isLogged()){
		    $this->load->model('FOModel');
			$this->load->model('UserModel');
			$this->load->model('BalanceModel');
			$this->load->model('FTRModel');
			$this->load->model('WalletModel');
			$fo = new FOModel();
			$user = new UserModel();
			$balance = new BalanceModel();
			$ftr = new FTRModel();
			$wallet = new WalletModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$foitem = $fo->search($fo_id);
			
			if($foitem['fo_status'] == 1){
			    if($foitem['fo_type'] == 1){
			        $fodata['fo_id'] = $foitem['fo_id'];
        			$fodata['fo_user'] = $foitem['fo_user'];
        			$fodata['fo_super'] = $foitem['fo_super'];
        			$fodata['fo_value'] = $foitem['fo_value'];
        			$fodata['fo_type'] = $foitem['fo_type'];
        			$fodata['fo_attach'] = $foitem['fo_attach'];
        			$fodata['fo_date'] = $foitem['fo_date'];
        			$fodata['fo_status'] = 2;
        			
        			if($fo->update($fodata)){
        			    $balanceitem = $balance->searchsuper($this->session->userdata('superid'));
        			    
        			    if($balanceitem){
        			        $balancedata['balanceid'] = $balanceitem['balanceid'];
        			        $balancedata['balancesuper'] = $balanceitem['balancesuper'];
        			        $balancedata['balancepend'] = $balanceitem['balancepend']-$foitem['fo_value'];
        			        $balancedata['balanceconf'] = $balanceitem['balanceconf'];
        			        $balancedata['balancetotal'] = $balanceitem['balancetotal']-$foitem['fo_value'];
        			        $balancedata['balancestatus'] = $balanceitem['balancestatus'];
        			        
        			        if($balance->update($balancedata)){
        			            redirect(base_url('solicitacoes'));
        			        }
        			    }
        			}
			    } else {
			        $fodata['fo_id'] = $foitem['fo_id'];
        			$fodata['fo_user'] = $foitem['fo_user'];
        			$fodata['fo_super'] = $foitem['fo_super'];
        			$fodata['fo_value'] = $foitem['fo_value'];
        			$fodata['fo_type'] = $foitem['fo_type'];
        			$fodata['fo_attach'] = $foitem['fo_attach'];
        			$fodata['fo_date'] = $foitem['fo_date'];
        			$fodata['fo_status'] = 2;
        			
        			if($fo->update($fodata)){
        			    $balanceitem = $balance->searchsuper($this->session->userdata('superid'));
        			    
        			    if($balanceitem){
        			        $balancedata['balanceid'] = $balanceitem['balanceid'];
        			        $balancedata['balancesuper'] = $balanceitem['balancesuper'];
        			        $balancedata['balancepend'] = $balanceitem['balancepend']+$foitem['fo_value'];
        			        $balancedata['balanceconf'] = $balanceitem['balanceconf'];
        			        $balancedata['balancetotal'] = $balanceitem['balancetotal']+$foitem['fo_value'];
        			        $balancedata['balancestatus'] = $balanceitem['balancestatus'];
        			        
        			        if($balance->update($balancedata)){
        			            $walletitem = $wallet->search($foitem['fo_user']);
			
                    			$walletdata['wallet_id'] = $walletitem['wallet_id'];
                    		    $walletdata['wallet_user'] = $walletitem['wallet_user'];
                    		    $walletdata['wallet_balance'] = $walletitem['wallet_balance']+$foitem['fo_value'];
                    		    $walletdata['wallet_free'] = $walletitem['wallet_free']+$foitem['fo_value'];
                    		    $walletdata['wallet_gift'] = $walletitem['wallet_gift'];
                		    
                		        if($wallet->update($walletdata)){
        			                redirect(base_url('solicitacoes'));
                		        }
        			        }
        			    }
        			}
			    }
			}
        } else {
            redirect(base_url('login'));
        }
    }
    
    public function redirecionar($fo_id) {
        if ($this->isLogged()){
			$this->load->model('FOModel');
			$this->load->model('UserModel');
			$this->load->model('BalanceModel');
			$this->load->model('FTRModel');
			$this->load->model('WalletModel');
			$this->load->model('SuperModel');
			$fo = new FOModel();
			$user = new UserModel();
			$balance = new BalanceModel();
			$ftr = new FTRModel();
			$wallet = new WalletModel();
			$super = new SuperModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$foitem = $fo->search($fo_id);
			$superitens = $super->listing();
			
			if($foitem['fo_status'] == 1){
			    if($foitem['fo_type'] == 1){
			         $freeredir = $fo->freeredir($this->session->userdata('superid'), $fo_id);
			         
			         if($freeredir){
        			    $content = array("foitem" => $foitem, "superitens" => $superitens);
            			
                        $this->load->view('template/super/headermenu', $info);
                        $this->load->view('super/redirectfin', $content);
    			    } else {
        			    redirect(base_url('solicitacoes'));
        			}
			    } else {
    			    redirect(base_url('solicitacoes'));
    			}
			} else {
			    redirect(base_url('solicitacoes'));
			}
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function confredir() {
        if ($this->isLogged()){
		    $this->load->model('FOModel');
			$this->load->model('UserModel');
			$this->load->model('BalanceModel');
			$this->load->model('FTRModel');
			$this->load->model('WalletModel');
			$fo = new FOModel();
			$user = new UserModel();
			$balance = new BalanceModel();
			$ftr = new FTRModel();
			$wallet = new WalletModel();
			
			$fo_id = $this->input->post('fo_id');
			$newsuper = $this->input->post('fo_super');
			
			$foitem = $fo->search($fo_id);
			
			if($foitem['fo_status'] == 1){
			    if($foitem['fo_type'] == 1){
			        
			        $lastsuper = $foitem['fo_super'];
			        
			        $fodata['fo_id'] = $foitem['fo_id'];
        			$fodata['fo_user'] = $foitem['fo_user'];
        			$fodata['fo_super'] = $newsuper;
        			$fodata['fo_value'] = $foitem['fo_value'];
        			$fodata['fo_type'] = $foitem['fo_type'];
        			$fodata['fo_attach'] = $foitem['fo_attach'];
        			$fodata['fo_date'] = $foitem['fo_date'];
        			$fodata['fo_status'] = $foitem['fo_status'];
        			
        			if($fo->update($fodata)){
        			    
        			    $lastbalance = $balance->searchsuper($lastsuper);
					    
					    if($lastbalance){
        			        $ltbalancedata['balanceid'] = $lastbalance['balanceid'];
        			        $ltbalancedata['balancesuper'] = $lastbalance['balancesuper'];
        			        $ltbalancedata['balancepend'] = $lastbalance['balancepend']-$foitem['fo_value'];
        			        $ltbalancedata['balanceconf'] = $lastbalance['balanceconf'];
        			        $ltbalancedata['balancetotal'] = $lastbalance['balancetotal']-$foitem['fo_value'];
        			        $ltbalancedata['balancestatus'] = $lastbalance['balancestatus'];
        			        
        			        if($balance->update($ltbalancedata)){
        			            
        			            $newbalance = $balance->searchsuper($newsuper);
        			            
        			            if($newbalance){
                			        $nwbalancedata['balanceid'] = $newbalance['balanceid'];
                			        $nwbalancedata['balancesuper'] = $newbalance['balancesuper'];
                			        $nwbalancedata['balancepend'] = $newbalance['balancepend']+$foitem['fo_value'];
                			        $nwbalancedata['balanceconf'] = $newbalance['balanceconf'];
                			        $nwbalancedata['balancetotal'] = $newbalance['balancetotal']+$foitem['fo_value'];
                			        $nwbalancedata['balancestatus'] = $newbalance['balancestatus'];
                			        
                			        if($balance->update($nwbalancedata)){
            							redirect(base_url('solicitacoes'));
                			        }
                			    }
        			        }
        			    }
        			}
			    }
			    /*
		            
	            $balanceitem = $balance->searchsuper($this->session->userdata('superid'));
	    
			    if($balanceitem){
			        $balancedata['balanceid'] = $balanceitem['balanceid'];
			        $balancedata['balancesuper'] = $balanceitem['balancesuper'];
			        $balancedata['balancepend'] = $balanceitem['balancepend']-$orderitem['orderprice'];
			        $balancedata['balanceconf'] = $balanceitem['balanceconf']+$orderitem['orderprice'];
			        $balancedata['balancetotal'] = $balanceitem['balancetotal'];
			        $balancedata['balancestatus'] = $balanceitem['balancestatus'];
			        
			        if($balance->update($balancedata)){
    			        $ordermail = $orders->searchmail($orderid);
						if($this->sendmail($oclisting, $ordermail)){
							redirect(base_url('solicitacoes'));
						}
			        }
			    }
			    */
			} else {
				redirect(base_url('solicitacoes'));
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
	
    public function setUsernotify($ocitem) {
		$this->load->model('UsernotifyModel');
		$un = new UsernotifyModel();
		
		$undata['un_id'] = null;
		$undata['un_user'] = $ocitem->orderuser;
		$undata['un_date'] = date('Y-m-d H:i:s');
		$undata['un_description'] = "Pagamento confirmado! Seu saldo já foi atualizado";
		$undata['un_link'] = "carteira";
		$undata['un_status'] = 1;
		
		if($un->save($undata)){
			return true;
		}
    }
    
    public function sendmail($ordermail) {
		require("assets/phpmailer/src/PHPMailer.php");
		require("assets/phpmailer/src/SMTP.php");
		
		$this->load->library('email');
		$this->load->model('UsernotifyModel');
		$un = new UsernotifyModel();
		
		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true; 
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = "vps-4868041.acretinos.com.br";
		$mail->Port = 465;
		$mail->IsHTML(true);
		$mail->Username = "no-reply@acretinos.com.br";
		$mail->Password = "#asv930815";
		$mail->SetFrom("no-reply@acretinos.com.br");
		$mail->Subject = "Deposito concuído";
		$mail->Body = 
		    '<!DOCTYPE html>
            <html lang="en">
            <head>
            	<meta charset="utf-8">
            	<style type="text/css">
            
            	::selection { background-color: #E13300; color: white; }
            	::-moz-selection { background-color: #E13300; color: white; }
            
            	body {
            		text-align:center;
            		margin-top:50px;
            		background-color: #fff;
            		margin: 5px;
            		font: 13px/20px normal Helvetica, Arial, sans-serif;
            		color: #4F5155;
            	}
            
            	a {
            		color: #003399;
            		background-color: transparent;
            		font-weight: normal;
            	}
            
            	h1 {
            		color: #444;
            		background-color: transparent;
            		border-bottom: 1px solid #D0D0D0;
            		font-size: 25px;
            		font-weight: normal;
            		margin: 0 0 14px 0;
            		padding: 14px 15px 10px 15px;
            	}
            
            	code {
            		font-family: Consolas, Monaco, Courier New, Courier, monospace;
            		font-size: 12px;
            		background-color: #f9f9f9;
            		border: 1px solid #D0D0D0;
            		color: #002166;
            		display: block;
            		margin: 14px 0 14px 0;
            		padding: 12px 10px 12px 10px;
            	}
            
            	#body {
            		text-align:center;
            		margin-top:50px;
            		margin: 0 15px 0 15px;
            	}
            
            	p.footer {
            		text-align: right;
            		font-size: 11px;
            		border-top: 1px solid #D0D0D0;
            		line-height: 32px;
            		padding: 0 10px 0 10px;
            		margin: 20px 0 0 0;
            	}
            
            	#container {
            		margin: 10px;
            		border: 1px solid #D0D0D0;
            		box-shadow: 0 0 8px #D0D0D0;
            	}
            	</style>
                </head>
                	<body>
                		<img src="https://www.acretinos.com.br/assets/img/logomail.png" height="150px">
                		<div id="container">
                			<h1>Oi, Cartoleiro.</h1>
                
                			<div id="body">
                				<h3>O seu deposito foi recebido pela administracao da Liga Acretinos e você já está pronto para fazer sua inscrição.</h3>
                
                				<p>Verifique seu <strong>saldo em carteira</strong> no Portal do Cartoleiro! Caso tenha algo errado com o valor, entre em contato imediatamente com um administrador.</p>
                				<code><a href="https://portal.acretinos.com.br">https://portal.acretinos.com.br</a></code>
                
                				<p>Agradecemos a confiança,</p>
                
                				<p>Equipe Acretinos.</p>
                			</div>
                
                			<p class="footer">Este e-mail é automático. Por favor, <strong>não responda.</strong></p>
                		</div>
                
                	</body>
                </html>';
                
		$mail->AddAddress($ordermail['useremail']);
		
		if(!$mail->Send()) {
			//echo "Mailer Error: " . $mail->ErrorInfo;
			return true;
		} else {
			return true;
		}
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
			"pageid" => 1,
			"notifications" => $notifications,
			"countnotify" => count($countnotify),
			"requests" => $requests,
			"countrequests" => count($countrequests)
		);
    }
}