<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_user extends CI_Model {
    
    function is_registered($username){
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('username',$username);
        $query = $this->db->get();
        return $query->result();
    }

    function user_detail($id){
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->result();
    }

    function  user_registration($data){
        $this->db->insert('tbl_user',$data);
        return $this->db->affected_rows();
    }

}