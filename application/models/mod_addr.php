<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_addr extends CI_Model {
    
    function province_list(){
        $this->db->select('*');
        $this->db->from('tbl_provinsi');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        return $query->result();
    }

    function province_detail($id){
        $this->db->select('*');
        $this->db->from('tbl_provinsi_detail');
        $this->db->where('id_provinsi',$id);
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        return $query->result();
    }

    


}