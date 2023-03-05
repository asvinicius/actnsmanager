<?php
class ContestrkModel extends CI_Model{
    
    protected $ctrkid;
    protected $year;
    protected $round;
    protected $ctrkcoach;
    protected $ctrkteam;
    protected $ctrkaward;
            
    function __construct() {
        parent::__construct();
        $this->setCtrkid(null);
        $this->setYear(null);
        $this->setRound(null);
        $this->setCtrkcoach(null);
        $this->setCtrkteam(null);
        $this->setCtrkaward(null);
    }
    
    public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('contestrk', $data)) {
                return true;
            }
        }
    }
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("ctrkid", $data['ctrkid']);
            if ($this->db->update('contestrk', $data)) {
                return true;
            }
        }
    }
    
    public function listing($year, $round) {
        $this->db->where("year", $year);
        $this->db->where("round", $round);
        $this->db->order_by("ctrkaward", "desc");
        $this->db->order_by("ctrkteam", "asc");
        return $this->db->get("contestrk")->result();
    }
    
    public function listall($year) {
        $this->db->where("year", $year);
        return $this->db->get("contestrk")->result();
    }
    
    public function sleep() {
        sleep(1);
        $this->db->reconnect();
    }
    
    function getCtrkid() {
        return $this->ctrkid;
    }

    function getYear() {
        return $this->year;
    }

    function getRound() {
        return $this->round;
    }

    function getCtrkcoach() {
        return $this->ctrkcoach;
    }

    function getCtrkteam() {
        return $this->ctrkteam;
    }

    function getCtrkaward() {
        return $this->ctrkaward;
    }

    function setCtrkid($ctrkid) {
        $this->ctrkid = $ctrkid;
    }

    function setYear($year) {
        $this->year = $year;
    }

    function setRound($round) {
        $this->round = $round;
    }

    function setCtrkcoach($ctrkcoach) {
        $this->ctrkcoach = $ctrkcoach;
    }

    function setCtrkteam($ctrkteam) {
        $this->ctrkteam = $ctrkteam;
    }

    function setCtrkaward($ctrkaward) {
        $this->ctrkaward = $ctrkaward;
    }


}