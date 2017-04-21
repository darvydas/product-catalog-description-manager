<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Receivers extends CI_Controller {

	var $bendra = array();
	
	public function __construct()
	{
		parent::__construct();
		$session_data = $this->session->userdata('logged_in');
		if($session_data)
		{
			$this->load->model('user');
			$this->bendra['usrid'] = $session_data['id'];
			$this->bendra['adm'] = $this->user->get_adm($this->bendra['usrid']);
			if($this->bendra['adm'] > 1) {
				
				$this->load->model('receiver');
				$this->bendra['title'] = ucfirst("Įrašų valdymas"); // Capitalize the first letter
				
				$this->bendra['username'] = $session_data['username'];				
				
				$this->bendra['controler'] = "receivers";
			}else{
				redirect('category');
			}
		}
		else
		{
			redirect('login');
		}	
	}
	
	public function index()
	{
		 $this->load->view('templates/header', $this->bendra);
		 $this->load->view('templates/top', $this->bendra);
		 $this->load->view('pages/update_buttons');
		 $this->load->view('templates/footer', $this->bendra);	
	}	
	
	public function update_categories()
	{				
		$grazino = $this->receiver->update_categories();
		if(!isset($grazino['new'])){
			$grazino['new'] = array();
		}
		if(!isset($grazino['upd'])){
			$grazino['upd'] = array();
		}
		
		$this->bendra['naujos_grupes'] = $grazino['new'];
		$this->bendra['atnaujintos_grupes'] = $grazino['upd'];
		$this->bendra['update_who'] = "grupes";
		//print_r ($grazino);
		//print_r ($grazino['upd']->pgs_id);
		//foreach ($grazino['upd'] as $gr) {print ($gr->pgs_id+"_");}
		//redirect('');
		$this->load->view('templates/header', $this->bendra);
		$this->load->view('templates/top', $this->bendra);
		$this->load->view('pages/updated_list', $this->bendra);
		$this->load->view('templates/footer', $this->bendra);	
	}
	
	public function update_products()
	{			
		$grazino_prekes = $this->receiver->update_products();
		if(!isset($grazino_prekes['new'])){
			$grazino_prekes['new'] = array();
		}
		if(!isset($grazino_prekes['upd'])){
			$grazino_prekes['upd'] = array();
		}
		$this->bendra['naujos_prekes'] = $grazino_prekes['new'];
		$this->bendra['atnaujintos_prekes'] = $grazino_prekes['upd'];
		$this->bendra['update_who'] = "prekes";
		
		$this->load->view('templates/header', $this->bendra);
		$this->load->view('templates/top', $this->bendra);
		$this->load->view('pages/updated_list', $this->bendra);
		$this->load->view('templates/footer', $this->bendra);	
	}		
}
