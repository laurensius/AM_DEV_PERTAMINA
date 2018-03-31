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
    
    function send_email($receiver, $username){
        $from = "your_email_address@gmail.com";
        $subject = 'Verify Email Address';
        $message = 'Dear User, <br><br> Please click on the bellow activation link to verify your email address <br><br>
        <a href=\'http://localhost:8081/AM_DEV_PERTAMINA/index.php/api/confirm_email/'.md5($receiver).'/'.$username.'\'>http://localhost:8081/AM_DEV_PERTAMINA/index.php/api/confirm_email/'. md5($receiver).'/'.$username .'</a>
        <br><br>Thanks';
        
        
        //config email settings
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = $from;
        $config['smtp_pass'] = 'your_email_password';  //sender's password
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = 'TRUE';
        $config['newline'] = "\r\n";
        
        $this->load->library('email', $config);
        $this->email->initialize($config);
        //send email
        $this->email->from($from);
        $this->email->to($receiver);
        $this->email->subject($subject);
        $this->email->message($message);
        
        if($this->email->send()){
            //for testing
            echo "sent to: ".$receiver."<br>";
            echo "from: ".$from. "<br>";
            echo "protocol: ". $config['protocol']."<br>";
            echo "message: ".$message;
            return true;
        } else{
            echo "email send failed";
            return false;
        }
    }
    
    //activate account
    function confirm_email($key, $username){
        $data = array('status' => 1);
        $condition = array('md5(email)' => key, 'username' => $username);
        $this->db->where($condition);
        return $this->db->update('tbl_user', $data);    //update status as 1 to make active user
    }

}