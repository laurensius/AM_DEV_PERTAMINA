<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_dealerproduct extends CI_Model {
    
    function dealer_product_list(){
        $this->db->select('*');
        $this->db->from('tbl_dealer_product_list');
        $this->db->join ("tbl_pertamina_product", "tbl_dealer_product_list.id_product = tbl_pertamina_product.id", 'inner');
        $this->db->order_by('tbl_dealer_product_list.id','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function dealer_product_detail($id_dealer){
        $this->db->select('*');
        $this->db->from('tbl_dealer_product_list');
        $this->db->join("tbl_pertamina_product", "tbl_dealer_product_list.id_product = tbl_pertamina_product.id", 'inner');
        $this->db->where("tbl_dealer_product_list.id_dealer",$id_dealer);
        $this->db->order_by('tbl_dealer_product_list.id','asc');
        $query = $this->db->get();
        return $query->result();
    }

}