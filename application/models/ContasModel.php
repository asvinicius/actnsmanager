<?php
class ContasModel extends CI_Model{
    
    protected $contasid;
    protected $contasbanco;
    protected $contassuper;
    
    function __construct() {
        parent::__construct();
            
        $this->setContasid(null);
        $this->setContasbanco(null);
        $this->setContassuper(null);
    }
	
	public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('contas', $data)) {
                return true;
            }
        }
    }
	
    public function search($contasid) {
        if ($contasid != null) {
            $this->db->where("contasid", $contasid);
			$this->db->join('super', 'contassuper=superid', 'inner');
			return $this->db->get("contas")->row_array();
        }
    }
    
    function getContasid() {
        return $this->contasid;
    }

    function getContasbanco() {
        return $this->contasbanco;
    }

    function getContassuper() {
        return $this->contassuper;
    }

    function setContasid($contasid) {
        $this->contasid = $contasid;
    }

    function setContasbanco($contasbanco) {
        $this->contasbanco = $contasbanco;
    }

    function setContassuper($contassuper) {
        $this->contassuper = $contassuper;
    }

}