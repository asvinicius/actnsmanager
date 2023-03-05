<?php
class FOModel extends CI_Model{
    
    protected $fo_id;
    protected $fo_user;
    protected $fo_super;
    protected $fo_value;
    protected $fo_type;
    protected $fo_attach;
    protected $fo_date;
    protected $fo_status;
    
    function __construct() {
        parent::__construct();
		
            $this->setFo_id(null);
            $this->setFo_user(null);
            $this->setFo_super(null);
            $this->setFo_value(null);
            $this->setFo_type(null);
            $this->setFo_attach(null);
            $this->setFo_date(null);
            $this->setFo_status(null);
    }
	
	public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('financialorder', $data)) {
                return true;
            }
        }
    }
	
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("fo_id", $data['fo_id']);
            if ($this->db->update('financialorder', $data)) {
                return true;
            }
        }
    }
	
    public function delete($fo_id) {
        if ($fo_id != null) {
            $this->db->where("fo_id", $fo_id);
            if ($this->db->delete("financialorder")) {
                return true;
            }
        }
    }
	
    public function search($fo_id) {
        if ($fo_id != null) {
            $this->db->where("fo_id", $fo_id);
			$this->db->join('user', 'userid=fo_user', 'inner');
			$this->db->join('super', 'superid=fo_super', 'inner');
			return $this->db->get("financialorder")->row_array();
        }
    }
	
    public function searchonly($fo_id) {
        if ($fo_id != null) {
            $this->db->where("fo_id", $fo_id);
			return $this->db->get("financialorder")->row_array();
        }
    }
	
	public function lastinsert() {
        return $this->search($this->db->insert_id("financialorder"));
    }
    
    public function listingbyuser($userid) {
        $this->db->where("fo_user", $userid);
        $this->db->order_by("fo_id", "desc");
        return $this->db->get("financialorder", 5, 0)->result();
    }
    
    public function listsuper($superid) {
		$this->db->where("fo_super", $superid);
		$this->db->where("fo_status", 1);
		$this->db->join('super', 'fo_super=superid', 'inner');
		$this->db->join('user', 'fo_user=userid', 'inner');
        $this->db->order_by("fo_status", "desc");
        $this->db->order_by("fo_id", "asc");
        return $this->db->get("financialorder", 10, 0)->result();
    }
	
    public function getCount($superid) {
		$this->db->where("fo_super", $superid);
		$this->db->where("fo_status", 1);
        $this->db->order_by("fo_id", "asc");
        return $this->db->get("financialorder")->result();
    }
	
    public function freeredir($fo_super, $fo_id) {
		$this->db->where("fo_super", $fo_super);
		$this->db->where("fo_id", $fo_id);
        return $this->db->get("financialorder")->row_array();
    }
    
    function getFo_id() {
        return $this->fo_id;
    }
    
    function getFo_user() {
        return $this->fo_user;
    }
    
    function getFo_super() {
        return $this->fo_super;
    }
    
    function getFo_value() {
        return $this->fo_value;
    }
    
    function getFo_type() {
        return $this->fo_type;
    }
    
    function getFo_attach() {
        return $this->fo_attach;
    }
    
    function getFo_date() {
        return $this->fo_date;
    }
    
    function getFo_status() {
        return $this->fo_status;
    }

    function setFo_id($fo_id) {
        $this->fo_id = $fo_id;
    }

    function setFo_user($fo_user) {
        $this->fo_user = $fo_user;
    }

    function setFo_super($fo_super) {
        $this->fo_super = $fo_super;
    }

    function setFo_value($fo_value) {
        $this->fo_value = $fo_value;
    }

    function setFo_type($fo_type) {
        $this->fo_type = $fo_type;
    }

    function setFo_attach($fo_attach) {
        $this->fo_attach = $fo_attach;
    }

    function setFo_date($fo_date) {
        $this->fo_date = $fo_date;
    }

    function setFo_status($fo_status) {
        $this->fo_status = $fo_status;
    }

}