<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('record');
		$this->load->model('meniu');
	}	
	public function submit()
	{
		$mas = array();
		//foreach($_POST as $k=>$v){
			//$mas[$k]=$v;
			//if($v=="NEE"){
				//$mas['status']='error';
			//}
		//}

		
		$usr = 	$this->record->get_user_by_key();
		if($usr[0]->id > 0){
			//dar reiketu tikrinti prekes ID ar yra nurodytas
			if((strlen($this->input->post('record_name', TRUE)) > 0) && (strlen($this->input->post('record_name', TRUE)) < 256)){			
				if(strlen($this->input->post('content', TRUE)) > 100 ){
					$this->record->new_record($usr[0]->id);
				}else {$mas['taisykles'][] = 'Įrašo turinys turi būti ilgesnis';}
			}else {$mas['taisykles'][] = 'Netinkamas įrašo pavadinimo ilgis';}
		}else {$mas['taisykles'][] = 'Netinkamas vartotojas';}
		
		if(!isset($mas['taisykles'])){
			$mas['status']='OK';			
		}
		
		echo json_encode($mas);
		
	}
	public function create()
	{
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('record_name', 'Įrašo pavadinimas', 'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('link', 'Įrašo puslapis', 'trim|xss_clean');
		$this->form_validation->set_rules('content', 'Įrašo turinys', 'xss_clean|min_length[100]|required');
		$this->form_validation->set_rules('product', 'Įrašo prekė', 'required');
		
		if ($this->form_validation->run('') === FALSE)
		{
			echo json_encode("error");
		}
		else
		{
			echo json_encode("OK");
		}
	}
	public function view_category_list()
	{		
		$sarasas = $this->meniu->getTree2();	
		if($sarasas>0){
		echo json_encode($sarasas);
		}
	}			
	public function view_select_products()
	{		
		$sarasas = $this->record->get_products_by_category($this->uri->segment(3));
		if($sarasas>0){
		echo json_encode($sarasas);
		}
	}	
}
?>