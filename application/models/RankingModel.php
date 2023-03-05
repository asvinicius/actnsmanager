<?php
class RankingModel extends CI_Model{
    
    protected $spinid;
    protected $numteams;
    protected $status;
    
    function __construct() {
        parent::__construct();
        $this->setSpinid(null);
        $this->setNumteams(null);
        $this->setStatus(null);
    }
    
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("spinid", $data['spinid']);
            if ($this->db->update('spin', $data)) {
                return true;
            }
        }
    }
    
    public function listing() {
        $this->db->select('*');
        $this->db->order_by("spinid", "asc");
        return $this->db->get("spin")->result();
    }
    
    public function search($spinid) {
        $this->db->where("spinid", $spinid);
        return $this->db->get("spin")->row_array();
    }
    
    function getSpinid() {
        return $this->spinid;
    }

    function getNumteams() {
        return $this->numteams;
    }

    function getStatus() {
        return $this->status;
    }

    function setSpinid($spinid) {
        $this->spinid = $spinid;
    }

    function setNumteams($numteams) {
        $this->numteams = $numteams;
    }

    function setStatus($status) {
        $this->status = $status;
    }

}