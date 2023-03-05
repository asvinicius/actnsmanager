<?php
class ProductModel extends CI_Model{
    
    protected $productid;
    protected $productname;
    protected $productprice;
    protected $productcategory;
    protected $productstatus;
    
    function __construct() {
        parent::__construct();
		
            $this->setProductid(null);
            $this->setProductname(null);
            $this->setProductprice(null);
            $this->setProductcategory(null);
            $this->setProductstatus(null);
    }
    
    public function listing(){
        $this->db->select('*');
		$this->db->join('paid', 'paidproduct=productid', 'inner');
        $this->db->order_by("productname", "asc");
        return $this->db->get("product")->result();
    }
    
    public function listactive(){
        $this->db->where("productstatus", 1);
		$this->db->join('paid', 'paidproduct=productid', 'inner');
        $this->db->order_by("productname", "asc");
        return $this->db->get("product")->result();
    }
    
    public function listhigh(){
        $this->db->where("productstatus", 1);
		$this->db->join('paid', 'paidproduct=productid', 'inner');
		$this->db->join('productcategory', 'pcat_id=productcategory', 'inner');
        $this->db->order_by("productname", "asc");
        return $this->db->get("product", 3)->result();
    }
    
    public function listcategory($pcat_id){
        if ($pcat_id != null) {
			$this->db->where("productcategory", $pcat_id);
			$this->db->where("productstatus", 1);
			$this->db->join('paid', 'paidproduct=productid', 'inner');
			$this->db->order_by("productname", "asc");
			return $this->db->get("product", 12, 0)->result();
		}
    }
    
    public function pagedlc($pcat_id, $paged) {
        if ($pcat_id != null) {
			$this->db->where("productcategory", $pcat_id);
			$this->db->where("productstatus", 1);
			$this->db->join('paid', 'paidproduct=productid', 'inner');
			$this->db->order_by("productname", "asc");
			return $this->db->get("product", 12, ($paged*12))->result();
		}
    }
    
    public function getCountlc($pcat_id){
        if ($pcat_id != null) {
			$this->db->where("productcategory", $pcat_id);
			$this->db->where("productstatus", 1);
			$this->db->join('paid', 'paidproduct=productid', 'inner');
			$this->db->order_by("productname", "asc");
			return $this->db->get("product")->result();
		}
    }
	
    public function search($productid) {
        if ($productid != null) {
            $this->db->where("productid", $productid);
			$this->db->where("productstatus", 1);
			$this->db->join('paid', 'paidproduct=productid', 'inner');
			$this->db->join('productcategory', 'pcat_id=productcategory', 'inner');
			return $this->db->get("product")->row_array();
        }
    }
	
    public function getproduct($productid) {
        if ($productid != null) {
            $this->db->where("productid", $productid);
			return $this->db->get("product")->row_array();
        }
    }
    
    function getProductid() {
        return $this->productid;
    }

    function getProductname() {
        return $this->productname;
    }

    function getProductprice() {
        return $this->productprice;
    }

    function getProductcategory() {
        return $this->productcategory;
    }

    function getProductstatus() {
        return $this->productstatus;
    }

    function setProductid($productid) {
        $this->productid = $productid;
    }

    function setProductname($productname) {
        $this->productname = $productname;
    }

    function setProductprice($productprice) {
        $this->productprice = $productprice;
    }

    function setProductcategory($productcategory) {
        $this->productcategory = $productcategory;
    }

    function setProductstatus($productstatus) {
        $this->productstatus = $productstatus;
    }


}