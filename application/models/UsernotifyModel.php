<?php
class UsernotifyModel extends CI_Model{
	protected $un_id;
    protected $un_user;
    protected $un_date;
    protected $un_description;
    protected $un_link;
    protected $un_status;
    
    function __construct() {
        parent::__construct();
        $this->setUn_id(null);
        $this->setUn_user(null);
        $this->setUn_date(null);
        $this->setUn_description(null);
        $this->setUn_link(null);
        $this->setUn_status(null);
    }
	
	public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('usernotify', $data)) {
                return true;
            }
        }
    }
	
    public function listuser($userid) {
		$this->db->where("un_user", $userid);
		$this->db->where("un_status", 1);
        $this->db->order_by("un_date", "asc");
        return $this->db->get("usernotify", 3, 0)->result();
    }
	
    public function countlistuser($userid) {
		$this->db->where("un_user", $userid);
		$this->db->where("un_status", 1);
        $this->db->order_by("un_date", "asc");
        return $this->db->get("usernotify")->result();
    }
	
	function getUn_id() {
        return $this->un_id;
    }
	
	function getUn_user() {
        return $this->un_user;
    }
	
	function getUn_date() {
        return $this->un_date;
    }
	
	function getUn_description() {
        return $this->un_description;
    }
	
	function getUn_link() {
        return $this->un_link;
    }
	
	function getUn_status() {
        return $this->un_status;
    }
	
	function setUn_id($un_id) {
		$this->un_id = $un_id;
    }
	
	function setUn_user($un_user) {
		$this->un_user = $un_user;
    }
	
	function setUn_date($un_date) {
		$this->un_date = $un_date;
    }
	
	function setUn_description($un_description) {
		$this->un_description = $un_description;
    }
	
	function setUn_link($un_link) {
		$this->un_link = $un_link;
    }
	
	function setUn_status($un_status) {
		$this->un_status = $un_status;
    }
}