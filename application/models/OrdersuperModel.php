<?php
class OrdersuperModel extends CI_Model{
    
    protected $os_id;
    protected $os_order;
    protected $os_super;
    
    function __construct() {
        parent::__construct();
		
            $this->setOs_id(null);
            $this->setOs_order(null);
            $this->setOs_super(null);
    }
	
	public function save($data = null) {
        if ($data != null) {
            if ($this->db->insert('ordersuper', $data)) {
                return true;
            }
        }
    }
	
    public function delete($os_id) {
        if ($os_id != null) {
            $this->db->where("os_id", $os_id);
            if ($this->db->delete("ordersuper")) {
                return true;
            }
        }
    }
	
    public function update($data = null) {
        if ($data != null) {
            $this->db->where("os_id", $data['os_id']);
            if ($this->db->update('ordersuper', $data)) {
                return true;
            }
        }
    }
	
    public function search($orderid) {
		$this->db->where("os_order", $orderid);
        return $this->db->get("ordersuper")->row_array();
    }
	
    public function listsuper($superid) {
		$this->db->where("os_super", $superid);
		$this->db->where("order.orderstatus", 1);
		$this->db->join('order', 'orderid=os_order', 'inner');
		$this->db->join('user', 'order.orderuser=userid', 'inner');
        $this->db->order_by("order.orderstatus", "desc");
        $this->db->order_by("order.orderid", "asc");
        return $this->db->get("ordersuper", 10, 0)->result();
    }
	
    public function listall($superid) {
		$this->db->where("os_super", $superid);
		$this->db->join('order', 'orderid=os_order', 'inner');
		$this->db->join('user', 'order.orderuser=userid', 'inner');
        $this->db->order_by("order.orderstatus", "desc");
        $this->db->order_by("order.orderid", "asc");
        return $this->db->get("ordersuper", 10, 0)->result();
    }
	
    public function countlistsuper($superid) {
		$this->db->where("os_super", $superid);
		$this->db->where("order.orderstatus", 1);
		$this->db->join('order', 'orderid=os_order', 'inner');
		$this->db->join('user', 'order.orderuser=userid', 'inner');
        $this->db->order_by("os_id", "asc");
        return $this->db->get("ordersuper")->result();
    }
	
    public function getCount($superid) {
		$this->db->where("os_super", $superid);
		$this->db->join('order', 'orderid=os_order', 'inner');
		$this->db->join('user', 'order.orderuser=userid', 'inner');
        $this->db->order_by("os_id", "asc");
        return $this->db->get("ordersuper")->result();
    }
	
    public function getCount2($superid) {
		$this->db->where("os_super", $superid);
		$this->db->where("order.orderstatus", 1);
		$this->db->join('order', 'orderid=os_order', 'inner');
		$this->db->join('user', 'order.orderuser=userid', 'inner');
        $this->db->order_by("os_id", "asc");
        return $this->db->get("ordersuper")->result();
    }
    
    public function mypaged($superid, $paged) {
		$this->db->where("os_super", $superid);
		$this->db->where("order.orderstatus", 1);
		$this->db->join('order', 'orderid=os_order', 'inner');
		$this->db->join('user', 'order.orderuser=userid', 'inner');
        $this->db->order_by("order.orderstatus", "desc");
        $this->db->order_by("order.orderid", "asc");
        return $this->db->get("ordersuper", 10, ($paged*10))->result();
    }
	
    public function listallpaged($superid, $paged) {
		$this->db->where("os_super", $superid);
		$this->db->join('order', 'orderid=os_order', 'inner');
		$this->db->join('user', 'order.orderuser=userid', 'inner');
        $this->db->order_by("order.orderstatus", "desc");
        $this->db->order_by("order.orderid", "asc");
        return $this->db->get("ordersuper", 10, ($paged*10))->result();
    }
	
    public function freeredir($superid, $orderid) {
		$this->db->where("os_super", $superid);
		$this->db->where("os_order", $orderid);
		$this->db->join('order', 'orderid=os_order', 'inner');
		$this->db->join('user', 'order.orderuser=userid', 'inner');
        return $this->db->get("ordersuper")->row_array();
    }
    
    function getOs_id() {
        return $this->os_id;
    }

    function getOs_order() {
        return $this->os_order;
    }

    function getOs_super() {
        return $this->os_super;
    }

    function setOs_id($os_id) {
        $this->os_id = $os_id;
    }

    function setOs_order($os_order) {
        $this->os_order = $os_order;
    }

    function setOs_super($os_super) {
        $this->os_super = $os_super;
    }

}