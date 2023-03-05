<?php
class TeamModel extends CI_Model{
    
    protected $teamid;
    protected $teamuser;
    protected $teamname;
    protected $teamcoach;
    protected $teamslug;
    protected $teamshield;
    protected $teamstatus;
    
    function __construct() {
        parent::__construct();
        $this->setTeamid(null);
        $this->setTeamuser(null);
        $this->setTeamname(null);
        $this->setTeamcoach(null);
        $this->setTeamslug(null);
        $this->setTeamshield(null);
        $this->setTeamstatus(null);
    }
    
    public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('team', $data)) {
                return true;
            }
        }
    }
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("teamid", $data['teamid']);
            if ($this->db->update('team', $data)) {
                return true;
            }
        }
    }
	
    public function delete($teamid) {
        if ($teamid != null) {
            $this->db->where("teamid", $teamid);
            if ($this->db->delete("team")) {
                return true;
            }
        }
    }
    
    public function listing() {
        $this->db->select('*');
        $this->db->order_by("teamname", "asc");
        return $this->db->get("team", 20)->result();
    }
    
    public function listview() {
        $this->db->select('*');
        $this->db->join('user', 'user.userid=teamuser', 'left');
        $this->db->order_by("teamname", "asc");
        return $this->db->get("team", 10, 0)->result();
    }
    
    public function listinguser($teamuser) {
        $this->db->where("teamuser", $teamuser);
        $this->db->where("teamstatus", 1);
        $this->db->order_by("teamname", "asc");
        return $this->db->get("team")->result();
    }
    
    public function search($teamid) {
        $this->db->where("teamid", $teamid);
        return $this->db->get("team")->row_array();
    }
    
    public function specific($label) {
        $this->db->like("teamname", $label);
        $this->db->or_like("teamcoach", $label);
        $this->db->join('user', 'user.userid=teamuser', 'left');
        return $this->db->get("team")->result();
    }

    function getTeamid() {
        return $this->teamid;
    }

    function getTeamuser() {
        return $this->teamuser;
    }

    function getTeamname() {
        return $this->teamname;
    }

    function getTeamcoach() {
        return $this->teamcoach;
    }

    function getTeamslug() {
        return $this->teamslug;
    }

    function getTeamshield() {
        return $this->teamshield;
    }

    function getTeamstatus() {
        return $this->teamstatus;
    }

    function setTeamid($teamid) {
        $this->teamid = $teamid;
    }

    function setTeamuser($teamuser) {
        $this->teamuser = $teamuser;
    }

    function setTeamname($teamname) {
        $this->teamname = $teamname;
    }

    function setTeamcoach($teamcoach) {
        $this->teamcoach = $teamcoach;
    }

    function setTeamslug($teamslug) {
        $this->teamslug = $teamslug;
    }

    function setTeamshield($teamshield) {
        $this->teamshield = $teamshield;
    }

    function setTeamstatus($teamstatus) {
        $this->teamstatus = $teamstatus;
    }


}