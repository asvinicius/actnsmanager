<?php
class MetricsModel extends CI_Model{
    
    protected $cm_id;
    protected $cm_year;
    protected $cm_spin;
    protected $cm_teams;
    protected $cm_status;
    
    function __construct() {
        parent::__construct();
        $this->setCm_id(null);
        $this->setCm_year(null);
        $this->setCm_spin(null);
        $this->setCm_teams(null);
        $this->setCm_status(null);
    }
    
    public function completed($year) {
        $this->db->where("cm_year", $year);
        $this->db->where("cm_status", 0);
        $this->db->order_by("cm_spin", "asc");
        return $this->db->get("contmetrics")->result();
    }
    
    function getCm_id() {
        return $this->cm_id;
    }
    
    function getCm_year() {
        return $this->cm_year;
    }
    
    function getCm_spin() {
        return $this->cm_spin;
    }
    
    function getCm_teams() {
        return $this->cm_teams;
    }
    
    function getCm_status() {
        return $this->cm_status;
    }

    function setCm_id($cm_id) {
        $this->cm_id = $cm_id;
    }

    function setCm_year($cm_year) {
        $this->cm_year = $cm_year;
    }

    function setCm_spin($cm_spin) {
        $this->cm_spin = $cm_spin;
    }

    function setCm_teams($cm_teams) {
        $this->cm_teams = $cm_teams;
    }

    function setCm_status($cm_status) {
        $this->cm_status = $cm_status;
    }
    
}