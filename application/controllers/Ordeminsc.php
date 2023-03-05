<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordeminsc extends CI_Controller {
	public function inscricao($orderid) {
        if ($this->isLogged()){
			$this->load->model('OrderModel');
			$this->load->model('OrdersuperModel');
			$this->load->model('OrdercontentsModel');
			$orders = new OrderModel();
			$ordersuper = new OrdersuperModel();
			$ordercontents = new OrdercontentsModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$listing = $ordercontents->listorder($orderid);
			$orderitem = $orders->search($orderid);
			$ositem = $ordersuper->search($orderid);
			
			if($ositem['os_super'] == $this->session->userdata('superid')){
			
                $content = array("oc_itens" => $listing, "orderitem" => $orderitem);
    			
                $this->load->view('template/super/headermenu', $info);
                $this->load->view('super/subscriberequest', $content);
			    
			} else {
			    redirect(base_url());
			}
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function confirmar($orderid) {
        if ($this->isLogged()){
			$this->load->model('OrderModel');
			$this->load->model('OrdersuperModel');
			$this->load->model('OrdercontentsModel');
			$this->load->model('UserModel');
			$this->load->model('TeamModel');
			$this->load->model('PaidModel');
			$this->load->model('SpinModel');
			$this->load->model('RegistryModel');
			$this->load->model('BalanceModel');
			$this->load->model('FTRModel');
			$orders = new OrderModel();
			$ordersuper = new OrdersuperModel();
			$ordercontents = new OrdercontentsModel();
			$user = new UserModel();
			$team = new TeamModel();
			$paid = new PaidModel();
			$spin = new SpinModel();
			$registry = new RegistryModel();
			$ftr = new FTRModel();
			$balance = new BalanceModel();
			
			$orderitem = $orders->search($orderid);
			
			if($orderitem['orderstatus'] == 1){
			    
			    $oclisting = $ordercontents->listorder($orderid);
			    
			    if($oclisting){
			        foreach($oclisting as $ocitem){
			            if($registry->getreg($ocitem->oc_team, $ocitem->oc_product)){
							
						} else {
							$regdata['registryid'] = null;
    						$regdata['registryteam'] = $ocitem->oc_team;
    						$regdata['registryspin'] = $ocitem->oc_product;
    						$regdata['registrysuper'] = $ocitem->os_super;
    						$regdata['registrypaid'] = 1;
    						
    						if($registry->save($regdata)){
    						    
    							$spinaux = $spin->search($ocitem->oc_product);
    							$paidaux = $paid->searchproduct($ocitem->oc_product);
    							
    							$spindata['spinid'] = $spinaux['spinid'];
    							$spindata['numteams'] = $spinaux['numteams']+1;
    							$spindata['status'] = $spinaux['status'];
    							
    							$paiddata['paidid'] = $paidaux['paidid'];
    							$paiddata['paidproduct'] = $paidaux['paidproduct'];
    							$paiddata['paidteams'] = $paidaux['paidteams']+1;
    							$paiddata['paidstatus'] = $paidaux['paidstatus'];
    							
    							$spin->update($spindata);
    							$paid->update($paiddata);
    							$this->setUsernotify($ocitem);
    						}
						}
			        }
			        $orderdata = $orders->search($orderid);
					$orderdata['orderstatus'] = 0;
					if($orders->update($orderdata)){
					    // Gerar FTR e Atualizar a tabela balance
					    
					    date_default_timezone_set('America/Sao_Paulo');
        		        
        		        $ftrdata['ftr_id'] = null;
        		        $ftrdata['ftr_type'] = 3; // 1-deposito # 2-saque # 3-inscrição # 4-premiação
        		        $ftrdata['ftr_mode'] = 0; // 0-cash # 1-bonus
        		        $ftrdata['ftr_date'] = date('Y-m-d H:i:s');
        		        $ftrdata['ftr_user'] = $orderdata['orderuser'];
        		        $ftrdata['ftr_super'] = $this->session->userdata('superid');
        		        $ftrdata['ftr_value'] = $orderdata['orderprice'];
        		        $ftrdata['ftr_attachment'] = $orderdata['orderattachment'];
        		        $ftrdata['ftr_validator'] = $this->validgen($ftrdata);
        		        
        		        if($ftr->save($ftrdata)){
        		            
        		            $balanceitem = $balance->searchsuper($this->session->userdata('superid'));
    			    
            			    if($balanceitem){
            			        $balancedata['balanceid'] = $balanceitem['balanceid'];
            			        $balancedata['balancesuper'] = $balanceitem['balancesuper'];
            			        $balancedata['balancepend'] = $balanceitem['balancepend']-$orderdata['orderprice'];
            			        $balancedata['balanceconf'] = $balanceitem['balanceconf']+$orderdata['orderprice'];
            			        $balancedata['balancetotal'] = $balanceitem['balancetotal'];
            			        $balancedata['balancestatus'] = $balanceitem['balancestatus'];
            			        
            			        if($balance->update($balancedata)){
                			        $ordermail = $orders->searchmail($orderid);
                			        redirect(base_url('solicitacoes'));
                			        /*
            						if($this->sendmail($oclisting, $ordermail)){
            							redirect(base_url('solicitacoes'));
            						}
            						*/
            			        }
            			    }
        		            
        		        }
					}
			    }
			} else {
				redirect(base_url('solicitacoes'));
			}
        } else {
            redirect(base_url('login'));
        }
    }
    
    public function recusar($orderid) {
        if ($this->isLogged()){
			$this->load->model('OrderModel');
			$this->load->model('OrdersuperModel');
			$this->load->model('OrdercontentsModel');
			$this->load->model('UserModel');
			$this->load->model('TeamModel');
			$this->load->model('PaidModel');
			$this->load->model('SpinModel');
			$this->load->model('RegistryModel');
			$this->load->model('BalanceModel');
			$orders = new OrderModel();
			$ordersuper = new OrdersuperModel();
			$ordercontents = new OrdercontentsModel();
			$user = new UserModel();
			$team = new TeamModel();
			$paid = new PaidModel();
			$spin = new SpinModel();
			$registry = new RegistryModel();
			$balance = new BalanceModel();
			
			$orderitem = $orders->search($orderid);
			
			if($orderitem['orderstatus'] == 1){
			    
			    $oclisting = $ordercontents->listorder($orderid);
			    
			    if($oclisting){
			        foreach($oclisting as $ocitem){
			            $ocdata['oc_id'] = $ocitem->oc_id;
    					$ocdata['oc_order'] = $ocitem->oc_order;
    					$ocdata['oc_product'] = $ocitem->oc_product;
    					$ocdata['oc_category'] = $ocitem->oc_category;
    					$ocdata['oc_team'] = $ocitem->oc_team;
    					$ocdata['oc_price'] = $ocitem->oc_price;
    					$ocdata['oc_status'] = 0;
    					
    					if($ordercontents->update($ocdata)){}
			        }
			        $orderdata = $orders->search($orderid);
					$orderdata['orderstatus'] = 2;
					if($orders->update($orderdata)){
    		            $balanceitem = $balance->searchsuper($this->session->userdata('superid'));
			    
        			    if($balanceitem){
        			        $balancedata['balanceid'] = $balanceitem['balanceid'];
        			        $balancedata['balancesuper'] = $balanceitem['balancesuper'];
        			        $balancedata['balancepend'] = $balanceitem['balancepend']-$orderdata['orderprice'];
        			        $balancedata['balanceconf'] = $balanceitem['balanceconf'];
        			        $balancedata['balancetotal'] = $balanceitem['balancetotal']-$orderdata['orderprice'];
        			        $balancedata['balancestatus'] = $balanceitem['balancestatus'];
        			        
        			        if($balance->update($balancedata)){
    							redirect(base_url('solicitacoes'));
        			        }
        			    }
					}
			    }
			} else {
				redirect(base_url('solicitacoes'));
			}
        } else {
            redirect(base_url('login'));
        }
    }
    
    public function redirecionar($orderid) {
        if ($this->isLogged()){
			$this->load->model('SuperModel');
			$this->load->model('OrderModel');
			$this->load->model('OrdersuperModel');
			$this->load->model('OrdercontentsModel');
			$super = new SuperModel();
			$orders = new OrderModel();
			$ordersuper = new OrdersuperModel();
			$ordercontents = new OrdercontentsModel();
			
			$getinfo = $this->getInfo();
			$info = array("info" => $getinfo);
			
			$listing = $ordercontents->listorder($orderid);
			$orderitem = $orders->search($orderid);
			$superitens = $super->listing();
			
			if($orderitem['orderstatus'] == 1){
			    
			    $freeredir = $ordersuper->freeredir($this->session->userdata('superid'), $orderid);
			    
			    if($freeredir){
    			    $content = array("oc_itens" => $listing, "orderitem" => $freeredir, "superitens" => $superitens);
        			
                    $this->load->view('template/super/headermenu', $info);
                    $this->load->view('super/redirectrequest', $content);
			    } else {
    			    $content = array("oc_itens" => $listing, "orderitem" => $orderitem);
    			
                    $this->load->view('template/super/headermenu', $info);
                    $this->load->view('super/subscriberequest', $content);
    			}
			} else {
			    $content = array("oc_itens" => $listing, "orderitem" => $orderitem);
			
                $this->load->view('template/super/headermenu', $info);
                $this->load->view('super/subscriberequest', $content);
			}
        }else{
            redirect(base_url('login'));
        }
    }
    
    public function confredir() {
        if ($this->isLogged()){
			$this->load->model('OrderModel');
			$this->load->model('OrdersuperModel');
			$this->load->model('OrdercontentsModel');
			$this->load->model('UserModel');
			$this->load->model('TeamModel');
			$this->load->model('PaidModel');
			$this->load->model('SpinModel');
			$this->load->model('RegistryModel');
			$this->load->model('BalanceModel');
			$orders = new OrderModel();
			$ordersuper = new OrdersuperModel();
			$ordercontents = new OrdercontentsModel();
			$user = new UserModel();
			$team = new TeamModel();
			$paid = new PaidModel();
			$spin = new SpinModel();
			$registry = new RegistryModel();
			$balance = new BalanceModel();
			
			$orderid = $this->input->post('orderid');
			$newsuper = $this->input->post('superid');
			
			$orderitem = $orders->search($orderid);
			
			if($orderitem['orderstatus'] == 1){
			    
			    $oclisting = $ordercontents->listorder($orderid);
			    
			    if($oclisting){
			        
			        $osdata = $ordersuper->search($orderid);
			        $lastsuper = $osdata['os_super'];
					$osdata['os_super'] = $newsuper;
					
					if($ordersuper->update($osdata)){
					    
					    $lastbalance = $balance->searchsuper($lastsuper);
					    
					    if($lastbalance){
        			        $ltbalancedata['balanceid'] = $lastbalance['balanceid'];
        			        $ltbalancedata['balancesuper'] = $lastbalance['balancesuper'];
        			        $ltbalancedata['balancepend'] = $lastbalance['balancepend']-$orderitem['orderprice'];
        			        $ltbalancedata['balanceconf'] = $lastbalance['balanceconf'];
        			        $ltbalancedata['balancetotal'] = $lastbalance['balancetotal']-$orderitem['orderprice'];
        			        $ltbalancedata['balancestatus'] = $lastbalance['balancestatus'];
        			        
        			        if($balance->update($ltbalancedata)){
        			            
        			            $newbalance = $balance->searchsuper($newsuper);
        			            
        			            if($newbalance){
                			        $nwbalancedata['balanceid'] = $newbalance['balanceid'];
                			        $nwbalancedata['balancesuper'] = $newbalance['balancesuper'];
                			        $nwbalancedata['balancepend'] = $newbalance['balancepend']+$orderitem['orderprice'];
                			        $nwbalancedata['balanceconf'] = $newbalance['balanceconf'];
                			        $nwbalancedata['balancetotal'] = $newbalance['balancetotal']+$orderitem['orderprice'];
                			        $nwbalancedata['balancestatus'] = $newbalance['balancestatus'];
                			        
                			        if($balance->update($nwbalancedata)){
            							redirect(base_url('solicitacoes'));
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
					}
			    }
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
		$undata['un_description'] = "Pagamento confirmado! Seu time ".$ocitem->teamname." foi inscrito no ".$ocitem->productname;
		$undata['un_link'] = "liga/detalhe/".$ocitem->productid;
		$undata['un_status'] = 1;
		
		if($un->save($undata)){
			return true;
		}
    }
    
    public function sendmail($oclisting, $ordermail) {
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
		$mail->Subject = "Pagamento confirmado";
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
                				<h3>O pagamento para sua solicitação foi aprovado e seu(s) time(s) esta(ão) adicionado(s) na lista.</h3>
                
                				<p>Pesquise seu time na <strong>lista de participantes da rodada</strong>! Caso não o encontre, entre em contato imediatamente com um administrador.</p>
                				<code><a href="https://acretinos.com.br/bolao">https://acretinos.com.br/bolao</a></code>
                
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