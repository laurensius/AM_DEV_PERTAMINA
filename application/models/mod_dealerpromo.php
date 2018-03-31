<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_dealerpromo extends CI_Model {

    
    function dealer_promo_list(){
        $this->db->select('*');
        $this->db->from('tbl_promo');
        $this->db->join("tbl_dealer", "tbl_promo.id_dealer = tbl_dealer.id", 'inner');
        $this->db->order_by('tbl_promo.id','desc');
        $query = $this->db->get();
        return $query->result();
    }

    function dealer_promo_detail($id_promo){
        $this->db->select('*');
        $this->db->from('tbl_promo');
        $this->db->join("tbl_dealer", "tbl_promo.id_dealer = tbl_dealer.id", 'inner');
        $this->db->where("tbl_promo.id",$id_promo);
        $query = $this->db->get();
        return $query->result();
    }

    function dealer_promo_current($id_dealer){
        $this->db->select('*');
        $this->db->from('tbl_promo');
        $this->db->join("tbl_dealer", "tbl_promo.id_dealer = tbl_dealer.id", 'inner');
        $this->db->where("tbl_promo.id_dealer",$id_dealer);
        $query = $this->db->get();
        return $query->result();;
    }
    

}