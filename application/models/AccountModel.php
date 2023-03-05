<?php
class AccountModel extends CI_Model{
    
    protected $acc_id;
    protected $acc_super;
    protected $acc_banco;
    protected $acc_key;
    protected $acc_ag;
    protected $acc_cc;
    protected $acc_comp;
    protected $acc_status;
    
    function __construct() {
        parent::__construct();
            
        $this->setAcc_id(null);
        $this->setAcc_super(null);
        $this->setAcc_banco(null);
        $this->setAcc_key(null);
        $this->setAcc_ag(null);
        $this->setAcc_cc(null);
        $this->setAcc_comp(null);
        $this->setAcc_status(null);
    }
	
	public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('account', $data)) {
                return true;
            }
        }
    }
    
    public function listing() {
        $this->db->select('*');
		$this->db->join('super', 'acc_super=superid', 'inner');
		$this->db->join('bank', 'acc_banco=bankid', 'inner');
        $this->db->order_by("acc_id", "asc");
        return $this->db->get("account")->result();
    }
	
    public function search($acc_id) {
        if ($acc_id != null) {
            $this->db->where("acc_id", $acc_id);
			$this->db->join('super', 'acc_super=superid', 'inner');
		    $this->db->join('bank', 'acc_banco=bankid', 'inner');
			return $this->db->get("account")->row_array();
        }
    }
    
    function getAcc_id() {
        return $this->acc_id;
    }
    
    function getAcc_super() {
        return $this->acc_super;
    }
    
    function getAcc_banco() {
        return $this->acc_banco;
    }
    
    function getAcc_key() {
        return $this->acc_key;
    }
    
    function getAcc_ag() {
        return $this->acc_ag;
    }
    
    function getAcc_cc() {
        return $this->acc_cc;
    }
    
    function getAcc_comp() {
        return $this->acc_comp;
    }
    
    function getAcc_status() {
        return $this->acc_status;
    }

    function setAcc_id($acc_id) {
        $this->acc_id = $acc_id;
    }

    function setAcc_super($acc_super) {
        $this->acc_super = $acc_super;
    }

    function setAcc_banco($acc_banco) {
        $this->acc_banco = $acc_banco;
    }

    function setAcc_key($acc_key) {
        $this->acc_key = $acc_key;
    }

    function setAcc_ag($acc_ag) {
        $this->acc_ag = $acc_ag;
    }

    function setAcc_cc($acc_cc) {
        $this->acc_cc = $acc_cc;
    }

    function setAcc_comp($acc_comp) {
        $this->acc_comp = $acc_comp;
    }

    function setAcc_status($acc_status) {
        $this->acc_status = $acc_status;
    }

}