<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_product extends CI_Model {
    
    function product_list(){
        $this->db->select('*');
        $this->db->from('tbl_pertamina_product');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function product_detail($id){
        $this->db->select('*');
        $this->db->from('tbl_pertamina_product');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result();
    }
    
    function  product_add($data){
        $this->db->insert('tbl_pertamina_product',$data);
        return $this->db->affected_rows();
    }

}