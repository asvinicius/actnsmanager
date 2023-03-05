<?php
class TrafegoModel extends CI_Model{
    
    protected $trafego_id;
    protected $trafego_user;
    protected $trafego_date;
    protected $trafego_status;
    
    function __construct() {
        parent::__construct();
            
        $this->setTrafego_id(null);
        $this->setTrafego_user(null);
        $this->setTrafego_date(null);
        $this->setTrafego_status(null);
    }
	
	public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('trafego', $data)) {
                return true;
            }
        }
    }
	
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("trafego_id", $data['trafego_id']);
            if ($this->db->update('trafego', $data)) {
                return true;
            }
        }
    }
	
    public function delete($trafego_id) {
        if ($trafego_id != null) {
            $this->db->where("trafego_id", $trafego_id);
            if ($this->db->delete("trafego")) {
                return true;
            }
        }
    }

    function getTrafego_id() {
        return $this->trafego_id;
    }

    function getTrafego_user() {
        return $this->trafego_user;
    }

    function getTrafego_date() {
        return $this->trafego_date;
    }

    function getTrafego_status() {
        return $this->trafego_status;
    }

    function setTrafego_id($trafego_id) {
        $this->trafego_id = $trafego_id;
    }

    function setTrafego_user($trafego_user) {
        $this->trafego_user = $trafego_user;
    }

    function setTrafego_date($trafego_date) {
        $this->trafego_date = $trafego_date;
    }

    function setTrafego_status($trafego_status) {
        $this->trafego_status = $trafego_status;
    }
}