<?php
class WalletModel extends CI_Model{
    
    protected $wallet_id;
    protected $wallet_user;
    protected $wallet_balance;
    protected $wallet_free;
    protected $wallet_gift;
    
    function __construct() {
        parent::__construct();
            
        $this->setWallet_id(null);
        $this->setWallet_user(null);
        $this->setWallet_balance(null);
        $this->setWallet_free(null);
        $this->setWallet_gift(null);
    }
	
	public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('wallet', $data)) {
                return true;
            }
        }
    }
	
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("wallet_id", $data['wallet_id']);
            if ($this->db->update('wallet', $data)) {
                return true;
            }
        }
    }
	
    public function delete($wallet_id) {
        if ($wallet_id != null) {
            $this->db->where("wallet_id", $wallet_id);
            if ($this->db->delete("wallet")) {
                return true;
            }
        }
    }
	
    public function search($wallet_user) {
        if ($wallet_user != null) {
            $this->db->where("wallet_user", $wallet_user);
			$this->db->join('user', 'userid=wallet_user', 'inner');
			return $this->db->get("wallet")->row_array();
        }
    }
    
    public function listing(){
        //$this->db->select('*');
        $this->db->where("wallet_free >", 0);
        $this->db->order_by("wallet_free", "desc");
		$this->db->join('user', 'userid=wallet_user', 'inner');
        return $this->db->get("wallet")->result();
    }
    
    public function listall(){
        $this->db->select('*');
        return $this->db->get("wallet")->result();
    }

    function getWallet_id() {
        return $this->wallet_id;
    }

    function getWallet_user() {
        return $this->wallet_user;
    }

    function getWallet_balance() {
        return $this->wallet_balance;
    }

    function getWallet_free() {
        return $this->wallet_free;
    }

    function getWallet_gift() {
        return $this->wallet_gift;
    }

    function setWallet_id($wallet_id) {
        $this->wallet_id = $wallet_id;
    }

    function setWallet_user($wallet_user) {
        $this->wallet_user = $wallet_user;
    }

    function setWallet_balance($wallet_balance) {
        $this->wallet_balance = $wallet_balance;
    }

    function setWallet_free($wallet_free) {
        $this->wallet_free = $wallet_free;
    }

    function setWallet_gift($wallet_gift) {
        $this->wallet_gift = $wallet_gift;
    }


}