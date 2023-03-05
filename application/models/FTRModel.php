<?php
class FTRModel extends CI_Model{
    
    protected $ftr_id;
    protected $ftr_type;
    protected $ftr_mode;
    protected $ftr_date;
    protected $ftr_user;
    protected $ftr_super; 
    protected $ftr_value;
    protected $ftr_attachment; 
    protected $ftr_validator;
    
    function __construct() {
        parent::__construct();
		
            $this->setFtr_id(null);
            $this->setFtr_type(null);
            $this->setFtr_mode(null);
            $this->setFtr_date(null);
            $this->setFtr_user(null);
            $this->setFtr_super(null);
            $this->setFtr_value(null);
            $this->setFtr_attachment(null);
            $this->setFtr_validator(null);
    }
	
	public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('ftreceipt', $data)) {
                return true;
            }
        }
    }
	
    public function search($ftr_id) {
        if ($ftr_id != null) {
            $this->db->where("ftr_id", $ftr_id);
			$this->db->join('user', 'userid=ftr_user', 'inner');
			$this->db->join('super', 'superid=ftr_super', 'inner');
			return $this->db->get("ftreceipt")->row_array();
        }
    }
	
	public function lastinsert() {
        return $this->search($this->db->insert_id("ftreceipt"));
    }
    
    public function listingbyuser($userid) {
        $this->db->where("ftr_user", $userid);
        $this->db->order_by("ftr_id", "desc");
        return $this->db->get("ftreceipt")->result();
    }
    
    public function listingbysuper($superid) {
        $this->db->where("ftr_super", $superid);
		$this->db->join('user', 'userid=ftr_user', 'inner');
        $this->db->order_by("ftr_id", "desc");
        return $this->db->get("ftreceipt")->result();
    }
    
    function getFtr_id() {
        return $this->ftr_id;
    }
    
    function getFtr_type() {
        return $this->ftr_type;
    }
    
    function getFtr_mode() {
        return $this->ftr_mode;
    }
    
    function getFtr_date() {
        return $this->ftr_date;
    }
    
    function getFtr_user() {
        return $this->ftr_user;
    }
    
    function getFtr_super() {
        return $this->ftr_super;
    }
    
    function getFtr_value() {
        return $this->ftr_value;
    }
    
    function getFtr_attachment() {
        return $this->ftr_attachment;
    }
    
    function getFtr_validator() {
        return $this->ftr_validator;
    }

    function setFtr_id($ftr_id) {
        $this->ftr_id = $ftr_id;
    }
    
    function setFtr_type($ftr_type) {
        $this->ftr_type = $ftr_type;
    }
    
    function setFtr_mode($ftr_mode) {
        $this->ftr_mode = $ftr_mode;
    }
    
    function setFtr_date($ftr_date) {
        $this->ftr_date = $ftr_date;
    }
    
    function setFtr_user($ftr_user) {
        $this->ftr_user = $ftr_user;
    }
    
    function setFtr_super($ftr_super) {
        $this->ftr_super = $ftr_super;
    }
    
    function setFtr_value($ftr_value) {
        $this->ftr_value = $ftr_value;
    }
    
    function setFtr_attachment($ftr_attachment) {
        $this->ftr_attachment = $ftr_attachment;
    }
    
    function setFtr_validator($ftr_validator) {
        $this->ftr_validator = $ftr_validator;
    }
}