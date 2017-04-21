<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') && $this->uri->segment(2)!="out")
		{
			redirect('');
		}	
	}

	public function index()
	{
		$this->load->model('user');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('login', 'Prisijungimo vardas', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pass', 'Slaptažodis', 'trim|required|xss_clean|callback_check_database');
		if($this->form_validation->run('') == FALSE)
		{
			$this->load->view('login_page');
		}
		else
		{
			redirect('');
		}
	}
	
	
	public function out(){
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy(); //unset_userdata('logged_in');
		redirect('');
	}
	
	function check_database($password)
	 {
	   $username = $this->input->post('login');
	   $result = $this->user->login($username, $password);
	   if($result)
	   {
		 $sess_array = array();
		 foreach($result as $row)
		 {
		   $sess_array = array(
			 'id' => $row->id,
			 'username' => $row->login /*,
			 'adm' => $row->privilege_id*/
		   );
		   $this->session->set_userdata('logged_in', $sess_array);
		 }
		 return TRUE;
	   }
	   else
	   {
		 $this->form_validation->set_message('check_database', 'Netinkami prisijungimo duomenys');
		 return false;
	   }
	}	
}
?>