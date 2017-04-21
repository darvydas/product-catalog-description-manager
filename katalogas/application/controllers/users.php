<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	var $bendra = array();
	
	public function __construct()
	{
		parent::__construct();
		$vartotojas = $this->session->userdata('logged_in');
		if($vartotojas)
		{
			$this->load->model('user');	
			$this->bendra['title'] = ucfirst("reklamos sistema"); // Capitalize the first letter
			$this->bendra['username'] = $vartotojas['username'];
			$this->bendra['usrid'] = $vartotojas['id'];
			//$this->bendra['adm'] = $vartotojas['adm'];
			$this->bendra['adm'] = $this->user->get_adm($this->bendra['usrid']);
			//print_r ($this->bendra['adm']);
			$this->bendra['controler'] = "users";
			
			//$this->load->model('meniu');		
			//$this->bendra['meniu2'] = $this->meniu->getTree2();		
			$this->bendra['segment2'] = $this->uri->segment(2);
		}
		else
		{
			//If no session, redirect to login page
			redirect('login');
		}
	}
	
	public function index()
	{		
		if($this->bendra['adm'] > 1) 
		{
			//--------------------------------- sort - name search ---------------------------------
			$rikiuoti_pagal_lauka = ($this->uri->segment(4)) ? $this->uri->segment(4) : "prekes_id";
			
			if($rikiuoti_pagal_lauka!="user_id" && $rikiuoti_pagal_lauka!="name" && $rikiuoti_pagal_lauka!="point" && $rikiuoti_pagal_lauka!="activ"){
				$rikiuoti_pagal_lauka = "u.id";
			}
			if($rikiuoti_pagal_lauka=="user_id") {$rikiuoti_pagal_lauka = "u.id";}//lyginimui reikia == o ne =
			if($rikiuoti_pagal_lauka=="name") {$rikiuoti_pagal_lauka = "u.login";}//
			if($rikiuoti_pagal_lauka=="point") {$rikiuoti_pagal_lauka = "trust";}//
			if($rikiuoti_pagal_lauka=="activ") {$rikiuoti_pagal_lauka = "active";}//
			
			$rikiuoti_kryptimi = ($this->uri->segment(5)) ? $this->uri->segment(5) : "asc";
			if($rikiuoti_kryptimi != "desc"){ //apsauga nuo rikiavimo krypties
				$rikiuoti_kryptimi = "asc";
			}
			$filtras = "";
			if(($this->uri->segment(6))){
				$filtras = $this->uri->segment(6);
				//cia dar reiketu apsaugu, kad ko nereikia neprivestu filtrui			
				if(preg_match('/\s/', $filtras) OR preg_match('/[\'"]/', $filtras) OR preg_match('/[\/\\\\]/', $filtras) OR preg_match('/(and|or|null|not)/i', $filtras)
						OR preg_match('/(union|select|from|where)/i', $filtras) OR preg_match('/(group|order|having|limit)/i', $filtras) OR preg_match('/(into|file|case)/i', $filtras)
						OR preg_match('/(--|#|\/\*)/', $filtras) OR preg_match('/(=|&|\|)/', $filtras)) {
				// no whitespaces, quotes, slashes, sqli boolean keywords, sqli select keywords, sqli select keywords, sqli operators, sqli comments, boolean operators
					$filtras = "";
					print '<script>alert("Netinkama paieška: '.$filtras.'")</script>';
				}
			}
	//--------------------------------- sort - name search end ---------------------------------
	//-------------------------- pagination --------------------------------------
			$this->load->library("pagination");
			$config = array();
			$config['base_url'] = base_url() . 'index.php/users/index/';
			$config['suffix'] = '/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6);
			$config['total_rows'] = $this->user->users_count();
			$config["per_page"] = 20;
			$config['uri_segment'] = 3;
			$config['next_tag_open'] = '<span class="sekantis"> ';
			$config['next_tag_close'] = '</span>';
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$this->bendra['links'] = $this->pagination->create_links();
	//-------------------------- pagination end --------------------------------------		
			
			$this->bendra['users'] = $this->user->get_users($config["per_page"], $page, $rikiuoti_pagal_lauka, $rikiuoti_kryptimi, $filtras);
			$this->load->view('templates/header', $this->bendra);
			$this->load->view('templates/top', $this->bendra);
			$this->load->view('pages/users_list', $this->bendra);
			$this->load->view('templates/footer', $this->bendra);	
		}else {
			//If not admin
			redirect('category');
		}

	}	
	public function user_view($usr_id)
	{		
		if($this->bendra['adm'] > 1 OR $this->bendra['usrid'] == $usr_id) {		
			$this->load->library("pagination");		
			$this->load->model("record");		
			/*$config = array();
			$config["base_url"] = base_url() . 'index.php/users/user_view/'.$usr_id;
			$config["total_rows"] = $this->user->user_records_count($usr_id);
			$config["per_page"] = 20;
			$config["uri_segment"] = 4;
			//$config['next_tag_open'] = '<span class="sekantis"> ';
			//$config['next_tag_close'] = '</span>';
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$this->bendra['links'] = $this->pagination->create_links();*/
			
			$this->bendra['usr'] = $this->user->get_user($usr_id);
			$this->bendra['usr_rec'] = $this->user->get_records($usr_id, 0, 0 /*, $config["per_page"], $page*/);
			$this->bendra['points'] = $this->record->get_points($usr_id);

			$this->load->view('templates/header', $this->bendra);
			$this->load->view('templates/top', $this->bendra);
			$this->load->view('pages/user_view', $this->bendra);
			$this->load->view('templates/footer', $this->bendra);	
		}else{ //if not admin, nor own information - redirect 
			redirect('category');			
		}
	}
	
	public function create()
	{
		$this->load->helper('form');
		//$this->load->helper('ckeditor');

		$this->load->library('form_validation');
		$this->bendra['heading'] = 'Naujas vartotojas';
		$this->bendra['title'] = 'Vartotojo kūrimas';
		
		$this->form_validation->set_rules('login_name', 'Vartotojo vardas', 'trim|required|min_length[5]|max_length[20]|unique[user.login]');
		$this->form_validation->set_rules('password', 'Slaptažodis', 'trim|required|min_length[5]|max_length[20]');
		$this->form_validation->set_rules('password2', 'Pakartokite slaptažodį', 'trim|required|matches[password]');
		$this->form_validation->set_rules('mail', 'El. paštas', 'trim|required|valid_email|unique[user.mail]');
		if($this->bendra['adm'] > 1) {
			$this->form_validation->set_rules('privilege_id', 'Tipas', 'required|is_natural'); }
		
		if ($this->form_validation->run('') === FALSE)
		{
			$this->bendra['usr'] = new User();
			$this->load->view('templates/header', $this->bendra);
			$this->load->view('templates/top', $this->bendra);		
			$this->load->view('pages/users_create', $this->bendra);
			$this->load->view('templates/footer', $this->bendra);	
		}
		else
		{
			$this->user->insert_user();
			redirect('users');
		}
	}
	
	public function edit()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->bendra['heading'] = 'Vartotojo redagavimas';
		$this->bendra['title'] = 'Vartotojo redagavimas';
		
		$this->form_validation->set_rules('login_name', 'Vartotojo vardas', 'trim|required|min_length[5]|max_length[20]|unique[user.login]');
		$this->form_validation->set_rules('password', 'Slaptažodis', 'trim|min_length[5]|max_length[20]');
		$this->form_validation->set_rules('password2', 'Pakartokite slaptažodį', 'trim|matches[password]');
		$this->form_validation->set_rules('mail', 'El. paštas', 'trim|required|valid_email|unique[user.mail]');
		
		if ($this->form_validation->run('') === FALSE)
		{
			$this->bendra['usr'] = $this->user->get_user($this->uri->segment(3));
			if($this->bendra['usr'] != null){
				$this->load->view('templates/header', $this->bendra);	
				$this->load->view('templates/top', $this->bendra);
				$this->load->view('pages/users_create', $this->bendra);
				$this->load->view('templates/footer', $this->bendra);
			}else{
				redirect('users');
			}
		}
		else
		{
			$this->user->update_user();
			redirect('users');
		}
	}
	
	public function delete()
	{
		$id = $this->uri->segment(3);
		$this->user->delete_user($id);
		redirect('users');
	}	
	
}
