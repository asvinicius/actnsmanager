<?php
class CartModel extends CI_Model{
    
    protected $cartid;
    protected $cartuser;
    protected $cartproduct;
    protected $cartteam;
    protected $cartcreationdate;
    
    function __construct() {
        parent::__construct();
            
        $this->setCartid(null);
        $this->setCartuser(null);
        $this->setCartproduct(null);
        $this->setCartteam(null);
        $this->setCartcreationdate(null);
    }
	
	public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('cart', $data)) {
                return true;
            }
        }
    }
	
    public function delete($cartid) {
        if ($cartid != null) {
            $this->db->where("cartid", $cartid);
            if ($this->db->delete("cart")) {
                return true;
            }
        }
    }
	
    public function listuser($userid) {
		$this->db->where("cartuser", $userid);
		$this->db->join('user', 'userid=cartuser', 'inner');
		$this->db->join('product', 'productid=cartproduct', 'inner');
		$this->db->join('team', 'teamid=cartteam', 'inner');
        $this->db->order_by("cartid", "asc");
        return $this->db->get("cart")->result();
    }
	
    public function listremove($cartteam) {
		$this->db->where("cartteam", $cartteam);
        $this->db->order_by("cartid", "asc");
        return $this->db->get("cart")->result();
    }
	
    public function getrestrict($cartproduct, $cartteam) {
		$this->db->where("cartproduct", $cartproduct);
		$this->db->where("cartteam", $cartteam);
        return $this->db->get("cart")->row_array();
    }
	
    public function listrestrict($userid, $productid) {
		$this->db->where("cartuser", $userid);
		$this->db->where("cartproduct", $productid);
		$this->db->join('user', 'userid=cartuser', 'inner');
		$this->db->join('product', 'productid=cartproduct', 'inner');
		$this->db->join('team', 'teamid=cartteam', 'inner');
        $this->db->order_by("cartid", "asc");
        return $this->db->get("cart")->result();
    }
    
    function getCartid() {
        return $this->cartid;
    }

    function getCartuser() {
        return $this->cartuser;
    }

    function getCartproduct() {
        return $this->cartproduct;
    }

    function getCartteam() {
        return $this->cartteam;
    }

    function getCartcreationdate() {
        return $this->cartcreationdate;
    }

    function setCartid($cartid) {
        $this->cartid = $cartid;
    }

    function setCartuser($cartuser) {
        $this->cartuser = $cartuser;
    }

    function setCartproduct($cartproduct) {
        $this->cartproduct = $cartproduct;
    }

    function setCartteam($cartteam) {
        $this->cartteam = $cartteam;
    }

    function setCartcreationdate($cartcreationdate) {
        $this->cartcreationdate = $cartcreationdate;
    }


}