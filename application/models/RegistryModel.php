<?php
class RegistryModel extends CI_Model{
    
    protected $registryid;
    protected $registryteam;
    protected $registryspin;
    protected $registrysuper;
    protected $registrypaid;
            
    function __construct() {
        parent::__construct();
        $this->setRegistryid(null);
        $this->setRegistryteam(null);
        $this->setRegistryspin(null);
        $this->setRegistrysuper(null);
        $this->setRegistrypaid(null);
    }
    
    public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('registry', $data)) {
                return true;
            }
        }
    }
	
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("registryid", $data['registryid']);
            if ($this->db->update('registry', $data)) {
                return true;
            }
        }
    }
    public function delete($registryid) {
        if ($registryid != null) {
            $this->db->where("registryid", $registryid);
            if ($this->db->delete("registry")) {
                return true;
            }
        }
    }
    
    public function getreg($registryteam, $registryspin) {
        $this->db->where("registryteam", $registryteam);
        $this->db->where("registryspin", $registryspin);
        return $this->db->get("registry")->row_array();
    }
    
    public function getreguser($userid, $registryspin) {
        $this->db->join('team', 'team.teamid=registryteam', 'inner');
        $this->db->where("team.teamuser", $userid);
        $this->db->where("registryspin", $registryspin);
        return $this->db->get("registry")->result();
    }
    
    public function listreg($registryteam) {
        $this->db->where("registryteam", $registryteam);
        return $this->db->get("registry")->result();
    }
    
    public function listrestrict($registryteam) {
        $this->db->where("registryteam", $registryteam);
        $this->db->where("spin.status", 1);
        $this->db->join('spin', 'spin.spinid=registryspin', 'inner');
        return $this->db->get("registry")->result();
    }
    
    public function listing($registryspin) {
        $this->db->where("registryspin", $registryspin);
        $this->db->join('team', 'team.teamid=registryteam', 'inner');
        //$this->db->join('super', 'super.superid=registrysuper', 'inner');
        $this->db->order_by("registryid", "asc");
        return $this->db->get("registry", 20, 0)->result();
    }
    
    public function listspin($registryspin) {
        $this->db->where("registryspin", $registryspin);
        $this->db->where("registrypaid", 1);
        $this->db->join('team', 'team.teamid=registryteam', 'inner');
        //$this->db->join('user', 'user.userid=team.teamuser', 'inner');
        //$this->db->join('super', 'super.superid=registrysuper', 'inner');
        $this->db->order_by("registryid", "asc");
        return $this->db->get("registry")->result();
    }
    
    public function mypaged($registryspin, $paged) {
        $this->db->where("registryspin", $registryspin);
        $this->db->join('team', 'team.teamid=registryteam', 'inner');
        $this->db->join('super', 'super.superid=registrysuper', 'inner');
        $this->db->order_by("registryid", "asc");
        return $this->db->get("registry", 20, ($paged*20))->result();
    }
    
    public function listingadm($registryspin, $registrysuper) {
        $this->db->where("registryspin", $registryspin);
        $this->db->where("registrysuper", $registrysuper);
        $this->db->join('team', 'team.teamid=registryteam', 'inner');
        $this->db->join('super', 'super.superid=registrysuper', 'inner');
        $this->db->order_by("registryid", "asc");
        return $this->db->get("registry")->result();
    }
    
    public function codelist($registryspin) {
        $this->db->where("registryspin", $registryspin);
        $this->db->join('team', 'team.teamid=registryteam', 'inner');
        $this->db->join('super', 'super.superid=registrysuper', 'inner');
        $this->db->order_by("registryid", "asc");
        return $this->db->get("registry")->result();
    }
    
    public function balance($registryspin){
        $this->db->where("registryspin", $registryspin);
        $this->db->join('team', 'team.teamid=registryteam', 'inner');
        $this->db->join('super', 'super.superid=registrysuper', 'inner');
        return $this->db->get("registry")->result();
    }
    
    public function spin($label, $registryspin) {
        $this->db->where("registryspin", $registryspin);
        $this->db->like("team.teamname", $label);
        $this->db->where("registryspin", $registryspin);
        $this->db->or_like("team.teamcoach", $label);
        $this->db->where("registryspin", $registryspin);
        $this->db->join('team', 'team.teamid=registryteam', 'inner');
        return $this->db->get("registry", 20, 0)->result();
    }
    
    public function getCount($registryspin){
        $this->db->where("registryspin", $registryspin);
        return $this->db->get("registry")->result();
    }
    
    function getRegistryid() {
        return $this->registryid;
    }

    function getRegistryteam() {
        return $this->registryteam;
    }

    function getRegistryspin() {
        return $this->registryspin;
    }

    function getRegistrysuper() {
        return $this->registrysuper;
    }

    function getRegistrypaid() {
        return $this->registrypaid;
    }

    function setRegistryid($registryid) {
        $this->registryid = $registryid;
    }

    function setRegistryteam($registryteam) {
        $this->registryteam = $registryteam;
    }

    function setRegistryspin($registryspin) {
        $this->registryspin = $registryspin;
    }

    function setRegistrysuper($registrysuper) {
        $this->registrysuper = $registrysuper;
    }

    function setRegistrypaid($registrypaid) {
        $this->registrypaid = $registrypaid;
    }

}