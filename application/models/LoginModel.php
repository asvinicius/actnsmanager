<?php
class LoginModel extends CI_Model{
    
    public function search($supernick, $superpassword){
        $this->db->where("supernick", $supernick);
        $this->db->where("superpassword", $superpassword);
        
        return $this->db->get("super")->row_array();
    }
}