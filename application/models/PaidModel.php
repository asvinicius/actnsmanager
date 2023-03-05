<?php
class PaidModel extends CI_Model{
    
    protected $paidid;
    protected $paidproduct;
    protected $paidteams;
    protected $paidstatus;
    
    function __construct() {
        parent::__construct();
        $this->setPaidid(null);
        $this->setPaidproduct(null);
        $this->setPaidteams(null);
        $this->setPaidstatus(null);
    }
    
    public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('paid', $data)) {
                return true;
            }
        }
    }
	
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("paidid", $data['paidid']);
            if ($this->db->update('paid', $data)) {
                return true;
            }
        }
    }
    
    public function listing() {
        $this->db->select('*');
        $this->db->order_by("paidid", "asc");
        return $this->db->get("paid")->result();
    }
    
    public function completed() {
        $this->db->where("paidstatus", 0);
        $this->db->order_by("paidid", "asc");
        return $this->db->get("paid")->result();
    }
    
    public function search($paidid) {
        $this->db->where("paidid", $paidid);
        return $this->db->get("paid")->row_array();
    }
    
    public function searchproduct($paidproduct) {
        $this->db->where("paidproduct", $paidproduct);
        return $this->db->get("paid")->row_array();
    }
    
    function getPaidid() {
        return $this->paidid;
    }
    
    function getPaidproduct() {
        return $this->paidproduct;
    }
    
    function getPaidteams() {
        return $this->paidteams;
    }
    
    function getPaidstatus() {
        return $this->paidstatus;
    }

    function setPaidid($paidid) {
        $this->paidid = $paidid;
    }

    function setPaidproduct($paidproduct) {
        $this->paidproduct = $paidproduct;
    }

    function setPaidteams($paidteams) {
        $this->paidteams = $paidteams;
    }

    function setPaidstatus($paidstatus) {
        $this->paidstatus = $paidstatus;
    }

}