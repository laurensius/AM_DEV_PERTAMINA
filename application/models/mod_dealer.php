<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_dealer extends CI_Model {
    
    function dealer_list(){
        $this->db->select('*');
        $this->db->from('tbl_dealer');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function dealer_detail($id){
        $this->db->select('*');
        $this->db->from('tbl_dealer');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result();
    }

}