<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('logged_in'))
		{
			$this->load->model('user');
			$this->bendra['title'] = ucfirst("registracija"); // Capitalize the first letter
		}
		else
		{
			//If session, redirect to login page
			redirect('login');
		}	
	}

	public function index()
	{
		$this->load->model('user');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login_name', 'Prisijungimo vardas', 'trim|required|min_length[5]|max_length[20]|xss_clean|callback_username_check');
		$this->form_validation->set_rules('password', 'Slaptažodis', 'trim|required|xss_clean|min_length[5]|max_length[20]');
		$this->form_validation->set_rules('password2', 'Slaptažodžio patvirtinimas', 'trim|required|xss_clean|matches[password]');
		$this->form_validation->set_rules('mail', 'El. paštas', 'trim|required|valid_email|xss_clean|callback_mail_check');
		if($this->form_validation->run('') == FALSE)
		{		
			$this->load->view('register_page');
		}
		else
		{
			$this->user->insert_user();
			$this->load->view('register_success');
		}
	}
	
	
	function username_check($unique_username)
	 {
		$result = $this->user->register_username($unique_username);
	 	
	   if(!$result)
	   {
		  return TRUE;
	   }
	   else
	   {		 
		$this->form_validation->set_message('username_check', 'Toks vartotojo vardas jau yra');
		 return false;
	   }
	}	
	
		function mail_check($mail)
	 {
		$result = $this->user->register_username($mail);
	 	
	   if(!$result)
	   {
		 return TRUE;
	   }
	   else
	   {	
		$this->form_validation->set_message('mail_check', 'Toks vartotojo vardas jau yra');
		 return false;
	   }
	}	
}
?>