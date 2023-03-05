<?php
class SuperModel extends CI_Model{
    
    protected $superid;
    protected $supernick;
    protected $supername;
    protected $superpassword;
    protected $superstatus;
    
    function __construct() {
        parent::__construct();
        $this->setSuperid(null);
        $this->setSupernick(null);
        $this->setSupername(null);
        $this->setSuperpassword(null);
        $this->setSuperstatus(null);
    }
	
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("superid", $data['superid']);
            if ($this->db->update('super', $data)) {
                return true;
            }
        }
    }
    
    public function listing(){
        $this->db->select('*');
        $this->db->order_by("superid", "acsc");
        return $this->db->get("super")->result();
    }
    
    public function search($superid){
        $this->db->where("superid", $superid);
        return $this->db->get("super")->row_array();
    }
    
    function getSuperid() {
        return $this->superid;
    }

    function getSupernick() {
        return $this->supernick;
    }

    function getSupername() {
        return $this->supername;
    }

    function getSuperpassword() {
        return $this->superpassword;
    }

    function getSuperstatus() {
        return $this->superstatus;
    }

    function setSuperid($superid) {
        $this->superid = $superid;
    }

    function setSupernick($supernick) {
        $this->supernick = $supernick;
    }

    function setSupername($supername) {
        $this->supername = $supername;
    }

    function setSuperpassword($superpassword) {
        $this->superpassword = $superpassword;
    }

    function setSuperstatus($superstatus) {
        $this->superstatus = $superstatus;
    }


}