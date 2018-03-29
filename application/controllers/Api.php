<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('mod_addr');
		$this->load->model('mod_user');
		$this->load->model('mod_product');
		$this->load->model('mod_dealer');
		$this->load->model('mod_dealerproduct');
		
		header('Content-type:json');
	}

	public function index(){
		$this->load->view('debuger');
	}

	//----------------------------------------------------------AUTENTIFIKASI---------------------------------------------------------
	public function login(){
		if($this->input->post('username') == null && $this->input->post('password') == null){
			$data = file_get_contents('php://input');
			$json = json_decode($data);
			$username = $json->username;
			$password = $json->password;
		}else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
		}
		if($username != null && $password != null ){
			$check = $this->mod_user->is_registered($username);
			if(sizeof($check) > 0){
				if($check[0]->user_status == "1"){
					if($check[0]->password == md5($password)){
						$severity = "success";
						$message = "Login berhasil";
						$data_count = sizeof($check);
						$data = $check;
					}else{
						$severity = "warning";
						$message = "Username dan Password tidak sesuai";
						$data_count = sizeof($check);
						$data = array();
					}
				}else
				if($check[0]->user_status == "2"){
					$severity = "warning";
					$message = "Silakan lakukan verifikasi akun";
					$data_count = sizeof($check);
					$data = array();
				}else
				if($check[0]->user_status == "3"){
					$severity = "danger";
					$message = "Akun diblokir";
					$data_count = sizeof($check);
					$data = array();
				}
			}else{
				$severity = "danger";
				$message = "Username tidak terdaftar";
				$data_count = "0";
				$data = $check;
			}
		}else{
			// $data = file_get_contents('php://input');
			// $json = json_decode($data);
			$severity = "warning";
			$message = "Tidak ada data dikirim ke server";
			$data_count = "0";
			$data = array();
		}
		$response = array(
			"severity" => $severity,
			"message" => $message,
			"data_count" => $data_count,
			"data" => $data
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	//----------------------------------------------------------USER---------------------------------------------------------
	public function user_detail(){
		$request = $this->mod_user->user_detail($this->uri->segment(3));
		$response = array(
			"message" => "Success",
			"code" => "200",
			"data_count" => sizeof($request),
			"data" => $request
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	//--------------------------------------------------------ADDRESS--------------------------------------------------------
	public function province_list(){
		$request = $this->mod_addr->province_list();
		$response = array(
			"message" => "Success",
			"code" => "200",
			"data_count" => sizeof($request),
			"data" => $request
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function province_detail(){
		$request = $this->mod_addr->province_detail($this->uri->segment(3));
		$response = array(
			"message" => "Success",
			"code" => "200",
			"data_count" => sizeof($request),
			"data" => $request
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	//--------------------------------------------------------PRODUCT--------------------------------------------------------
	public function product_list(){
		$request = $this->mod_product->product_list();
		$response = array(
			"message" => "Success",
			"code" => "200",
			"data_count" => sizeof($request),
			"data" => $request
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function product_detail(){
		$request = $this->mod_product->product_detail($this->uri->segment(3));
		$response = array(
			"message" => "Success",
			"code" => "200",
			"data_count" => sizeof($request),
			"data" => $request
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}
	
	public function product_add(){
	    if($this->input->post('product_name') == null &&
	        $this->input->post('product_description') == null){
	        
	        $data = file_get_contents('php://input');
            $json = json_decode($data);
            $data_insert = array(
                "product_name" => $json->product_name,
                "product_description" => $json->product_description,
                "publish_datetime" => date("Y-m-d H:i:s"),
                "is_discontinue" => "0",
                "discontinue_datetime" => "0000-00-00 00:00:00"
            );
	    }else{
	        $data_insert = array(
	            "product_name" => $this->input->post('product_name'),
	            "product_description" => $this->input->post('product_description'),
	            "publish_datetime" => date("Y-m-d H:i:s"),
	            "is_discontinue" => "0",
	            "discontinue_datetime" => "0000-00-00 00:00:00"
	        );
	    }
	    
	    $request = $this->mod_product->product_add($data_insert);
	    if ($request > 0){
	        $message = "Success";
	        $code = "200";
	    } else {
	        $message = "Failed";
	        $code = "400";
	    }
	    $response = array(
	        "message" => $message,
	        "code" => $code,
	        "data" => $request
	    );
	    echo json_encode($response,JSON_PRETTY_PRINT);
	}

	//--------------------------------------------------------DEALER--------------------------------------------------------
	public function dealer_list(){
		$request = $this->mod_dealer->dealer_list();
		$response = array(
			"message" => "Success",
			"code" => "200",
			"data_count" => sizeof($request),
			"data" => $request
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function dealer_detail(){
		$request_dealer = $this->mod_dealer->dealer_detail($this->uri->segment(3));
		$request_product = $this->mod_dealerproduct->dealer_product_detail($this->uri->segment(3));
		$response = array(
			"message" => "Success",
			"code" => "200",
			"data_count" => sizeof($request_dealer),
			// "data" => $request_dealer,
			// "product_list" => $request_product
			"data" => array(
				"dealer" => $request_dealer,
				"product" =>$request_product,
				"services" => array())
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	//--------------------------------------------------------DEALER PRODUCT--------------------------------------------------------
	public function dealer_product_list(){
		$request = $this->mod_dealerproduct->dealer_product_list();
		$response = array(
			"message" => "Success",
			"code" => "200",
			"data_count" => sizeof($request),
			"data" => $request
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function dealer_product_detail(){
		$request = $this->mod_dealerproduct->dealer_product_detail($this->uri->segment(3));
		$response = array(
			"message" => "Success",
			"code" => "200",
			"data_count" => sizeof($request),
			"data" => $request
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function dealer_add_product(){
	    if($this->input->post('id_dealer') == null &&
	        $this->input->post('id_product') == null &&
	        $this->input->post('price') == null){
	        
	        $data = file_get_contents('php://input');
	        $json = json_decode($data);
	        $data_insert = array(
	            "id_dealer" => $json->id_dealer,
	            "id_product" => $json->id_product,
	            "price" => $json->price,
	            "is_available" => "1",
	            "publish_datetime" => date("Y-m-d H:i:s")
	        );
	    }else{
	        $data_insert = array(
	            "id_dealer" => $this->input->post('id_dealer'),
	            "id_product" => $this->input->post('id_product'),
	            "price" => $this->input->post('price'),
	            "is_available" => "1",
	            "publish_datetime" => date("Y-m-d H:i:s")
	        );
	    }
	    
	    $request = $this->mod_dealerproduct->dealer_add_product($data_insert);
	    if ($request > 0){
	       $message = "Success";
	       $code = "200";
	    } else {
	       $message = "Failed";
	       $code = "400";
	    }
	    $response = array(
	        "message" => $message,
	        "code" => $code,
	        "data" => $request
	    );
	    echo json_encode($response,JSON_PRETTY_PRINT);
	}

}
