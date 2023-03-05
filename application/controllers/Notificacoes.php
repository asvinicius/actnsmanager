<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notificacoes extends CI_Controller {

    public function index() {
        if ($this->isLogged()){
			redirect(base_url());
        } else {
            $this->load->view('public/login');
        }
    }
    
	public function id($sn_id) {
        if ($this->isLogged()){
			$this->load->model('SupernotifyModel');
            $sn = new SupernotifyModel();
			
			$sndata = $sn->search($sn_id);
			$sndata['sn_status'] = 0;
			
			if($sn->update($sndata)){
				redirect(base_url(''.$sndata['sn_link']));
			}
		}else{
            redirect(base_url('login'));
        }
    }
}