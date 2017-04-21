<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adds extends CI_Controller {

	var $bendra = array();
	
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in'))
		{
			$this->load->model('add');
			$this->bendra['title'] = ucfirst("reklamos sistema"); // Capitalize the first letter
			$session_data = $this->session->userdata('logged_in');
			$this->bendra['username'] = $session_data['username'];
			$this->bendra['adm'] = $session_data['adm'];
		}
		else
		{
			//If no session, redirect to login page
			redirect('login');
		}	
	}
	
	public function index()
	{		
		$usr['adds'] = $this->user->get_users();
		$this->load->view('templates/header', $this->bendra);
		$this->load->view('templates/top', $this->bendra);
		$this->load->view('pages/adds_list', $usr);
		$this->load->view('templates/footer', $this->bendra);	
	}
	
	public function create()
	{
			/*	<textarea name="content" id="content" ><p>Example data</p></textarea>
	<?php echo display_ckeditor(); ?>*/
	
	
		$this->load->helper('form');
		$this->load->helper('ckeditor');

		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('login_name', 'Vartotojo vardas', 'trim|required|min_length[5]|max_length[20]');
		$this->form_validation->set_rules('password', 'Slaptažodis', 'trim|required|min_length[5]|max_length[20]|matches[password2]');
		$this->form_validation->set_rules('password2', 'Pakartokite slaptažodį', 'trim|required');
		
		if ($this->form_validation->run() === FALSE)
		{
			$usr['usr'] = new Add();
			$this->load->view('templates/header', $this->bendra);
			$this->load->view('templates/top', $this->bendra);		
			$this->load->view('pages/users_create', $usr);
			$this->load->view('templates/footer', $this->bendra);	
		}
		else
		{
			$this->add->insert_user();
			redirect('adds');
		}
	}
	
	public function edit()
	{
		$this->load->helper('form');
		$this->load->helper('ckeditor');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('login_name', 'Vartotojo vardas', 'trim|required|min_length[5]|max_length[20]');
		$this->form_validation->set_rules('password', 'Slaptažodis');
		$this->form_validation->set_rules('password2', 'Pakartokite slaptažodį', 'trim');
		
		if ($this->form_validation->run() === FALSE)
		{
			$usr['usr'] = $this->add->get_user($this->uri->segment(3));
			if($usr['usr'] != null){
				$this->load->view('templates/header', $this->bendra);	
				$this->load->view('templates/top', $this->bendra);
				$this->load->view('pages/users_create', $usr);
				$this->load->view('templates/footer', $this->bendra);
			}else{
				redirect('adds');
			}
		}
		else
		{
			$this->add->update_user();
			redirect('adds');
		}
	}
	
	public function delete()
	{
		$id = $this->uri->segment(3);
		$this->add->delete_user($id);
		redirect('users');
	}	
	
}
