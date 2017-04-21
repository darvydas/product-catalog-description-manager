<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$vartotojas = $this->session->userdata('logged_in');
		if($vartotojas)
		{
			$this->load->model('record');
			$this->load->model('user');
			
			//print_r($this->record->bandymas());
			
			$this->bendra['usr'] = $vartotojas['username'];
			$this->bendra['usrid'] = $vartotojas['id'];
			$this->bendra['adm'] = $this->user->get_adm($this->bendra['usrid']);
			$this->bendra['title'] = ucfirst("kategorija"); // Capitalize the first letter
			//meniu modelio uzkrovimas ir meniu sudarymas dviem skirtingais budais
			$this->load->model('meniu');
			//$this->bendra['meniu1'] = $this->meniu->getTree1(0);			
			//$this->bendra['meniu2'] = $this->meniu->getTree2();	
			$this->bendra['meniu2'] = $this->meniu->getTree3();		

			//print_r($this->bendra['meniu2']);	
			//print_r($this->bendra['meniu3']);	
			$this->bendra['points'] = $this->record->get_points($this->bendra['usrid']);
			
			$this->load->library("pagination");
			$this->bendra['controler'] = "category";
		}
		else
		{
			//If no session, redirect to login page
			redirect('login');
		}
	}
	
	public function index()
	{		
	
		$rikiuoti_pagal_lauka = ($this->uri->segment(4)) ? $this->uri->segment(4) : "prekes_id";
		
		if($rikiuoti_pagal_lauka!="prekes_id" && $rikiuoti_pagal_lauka!="pav" && $rikiuoti_pagal_lauka!="kategorija" && $rikiuoti_pagal_lauka!="aprasymas"){ //cia apsaugai, akd ko nereikia neprivestu
			$rikiuoti_pagal_lauka = "t1.pre_id";
		}
		if($rikiuoti_pagal_lauka=="prekes_id") {$rikiuoti_pagal_lauka = "t1.pre_id";}//lyginimui reikia == o ne =
		if($rikiuoti_pagal_lauka=="pav") {$rikiuoti_pagal_lauka = "t1.name";}//
		if($rikiuoti_pagal_lauka=="kategorija") {$rikiuoti_pagal_lauka = "t2.label";}//
		if($rikiuoti_pagal_lauka=="aprasymas") {$rikiuoti_pagal_lauka = "t1.describe";}//
		
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
				print '<script>alert("Netinkamas '.$filtras.' filtras")</script>';
			}
		}
		
		/*echo "Irasus pateiksim rikiuotus pagal ".$rikiuoti_pagal_lauka." ".$rikiuoti_kryptimi." kryptimi<br/>";
		if($filtras!=""){
			echo "Visi irasai dar tures buti filtruoti pagal ivesta teksta '".str_replace("%20", " ", $filtras)."'<br/>";
		}*/

	
		$config = array();
        $config['base_url'] = base_url() . 'index.php/category/index/';
		$config['suffix'] = '/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$this->uri->segment(6); //to reikia, kad puslapiuojant prisidetu gale parametrai
        $config['total_rows'] = $this->record->products_count(0);
        $config["per_page"] = 20;
        $config['uri_segment'] = 3;
		$config['next_tag_open'] = '<span class="sekantis"> ';
		$config['next_tag_close'] = '</span>';
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $this->bendra['links'] = $this->pagination->create_links();
		
		$this->bendra['products'] = $this->record->get_products_by_category(0, $config["per_page"], $page, $rikiuoti_pagal_lauka, $rikiuoti_kryptimi, $filtras);	
		
		$this->bendra['heading'] = "Visi";		
		$this->load->view('templates/header', $this->bendra);
		$this->load->view('templates/top', $this->bendra);
		$this->load->view('pages/product_list', $this->bendra);
		$this->load->view('templates/footer', $this->bendra);	
	}
	public function view()
	{			
		$rikiuoti_pagal_lauka = ($this->uri->segment(5)) ? $this->uri->segment(5) : "prekes_id";
		
		if($rikiuoti_pagal_lauka!="prekes_id" && $rikiuoti_pagal_lauka!="pav" && $rikiuoti_pagal_lauka!="kategorija" && $rikiuoti_pagal_lauka!="aprasymas"){ //cia apsaugai, akd ko nereikia neprivestu
			$rikiuoti_pagal_lauka = "pre_id";
		}
		if($rikiuoti_pagal_lauka=="prekes_id") {$rikiuoti_pagal_lauka = "pre_id";}
		if($rikiuoti_pagal_lauka=="pav") {$rikiuoti_pagal_lauka = "name";}//
		if($rikiuoti_pagal_lauka=="kategorija") {$rikiuoti_pagal_lauka = "label";}//
		if($rikiuoti_pagal_lauka=="aprasymas") {$rikiuoti_pagal_lauka = "describe";}//
		
		$rikiuoti_kryptimi = ($this->uri->segment(6)) ? $this->uri->segment(6) : "asc";
		if($rikiuoti_kryptimi != "desc"){ //apsauga nuo rikiavimo krypties
			$rikiuoti_kryptimi = "asc";
		}
		$filtras = "";
		if(($this->uri->segment(7))){
			$filtras = $this->uri->segment(7);
			//cia dar reiketu apsaugu, kad ko nereikia neprivestu filtrui
			if(preg_match('/\s/', $filtras) OR preg_match('/[\'"]/', $filtras) OR preg_match('/[\/\\\\]/', $filtras) OR preg_match('/(and|or|null|not)/i', $filtras)
					OR preg_match('/(union|select|from|where)/i', $filtras) OR preg_match('/(group|order|having|limit)/i', $filtras) OR preg_match('/(into|file|case)/i', $filtras)
					OR preg_match('/(--|#|\/\*)/', $filtras) OR preg_match('/(=|&|\|)/', $filtras)) {
			// no whitespaces, quotes, slashes, sqli boolean keywords, sqli select keywords, sqli select keywords, sqli operators, sqli comments, boolean operators
				$filtras = "";
				print '<script>alert("Netinkamas '.$filtras.' filtras")</script>';
			}
		}
		$config = array();
		$config["base_url"] = base_url() . 'index.php/category/view/' . $this->uri->segment(3);
		$config['suffix'] = '/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7);
		$config["total_rows"] = $this->record->products_count($this->uri->segment(3));
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$config['next_tag_open'] = '<span class="sekantis"> ';
		$config['next_tag_close'] = '</span>';
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$this->bendra['links'] = $this->pagination->create_links();
			
		$this->bendra['products'] = $this->record->get_products_by_category($this->uri->segment(3), $config["per_page"], $page, $rikiuoti_pagal_lauka, $rikiuoti_kryptimi, $filtras);
		if (!$this->bendra['products']) { redirect('category'); }
		$this->bendra['heading'] = $this->record->category_name($this->uri->segment(3));		
		//$this->bendra['categ_name'] = $this->record->category_name($this->uri->segment(3));
		$this->bendra['categ_id'] = $this->uri->segment(3);		
		
		$this->load->view('templates/header', $this->bendra);
		$this->load->view('templates/top', $this->bendra);
		$this->load->view('pages/product_list', $this->bendra);
		$this->load->view('templates/footer', $this->bendra);
	}	
	public function view_records()
	{		
	//------------------------------- irasu rikiavimas ------------------------
		$rikiuoti_pagal_lauka = ($this->uri->segment(5)) ? $this->uri->segment(5) : "iraso_id";		
		if($rikiuoti_pagal_lauka!="iraso_id" && $rikiuoti_pagal_lauka!="pav" && $rikiuoti_pagal_lauka!="stat" && $rikiuoti_pagal_lauka!="savin" 
				&& $rikiuoti_pagal_lauka!="dat" && $rikiuoti_pagal_lauka!="red" && $rikiuoti_pagal_lauka!="sal" && $rikiuoti_pagal_lauka!="pasiul" && $rikiuoti_pagal_lauka!="sutap"){
			$rikiuoti_pagal_lauka = "pre_id";
		}
		if($rikiuoti_pagal_lauka=="iraso_id") {$rikiuoti_pagal_lauka = "t1.id";}
		if($rikiuoti_pagal_lauka=="pav") {$rikiuoti_pagal_lauka = "t1.name";}
		if($rikiuoti_pagal_lauka=="stat") {$rikiuoti_pagal_lauka = "t3.name";}
		if($rikiuoti_pagal_lauka=="savin") {$rikiuoti_pagal_lauka = "t2.login";}
		if($rikiuoti_pagal_lauka=="dat") {$rikiuoti_pagal_lauka = "date";}
		/*if($rikiuoti_pagal_lauka=="red") {$rikiuoti_pagal_lauka = "stat_edit";}
		if($rikiuoti_pagal_lauka=="sal") {$rikiuoti_pagal_lauka = "stat_delete";}
		if($rikiuoti_pagal_lauka=="pasiul") {$rikiuoti_pagal_lauka = "";}*/
		if($rikiuoti_pagal_lauka=="sutap") {$rikiuoti_pagal_lauka = "plagijatas";}
		
		$rikiuoti_kryptimi = ($this->uri->segment(6)) ? $this->uri->segment(6) : "asc";
		if($rikiuoti_kryptimi != "desc"){ //apsauga nuo rikiavimo krypties
			$rikiuoti_kryptimi = "asc";
		}
		$filtras = "";
		if(($this->uri->segment(7))){
			$filtras = $this->uri->segment(7);
			//cia dar reiketu apsaugu, kad ko nereikia neprivestu filtrui
			if(preg_match('/\s/', $filtras) OR preg_match('/[\'"]/', $filtras) OR preg_match('/[\/\\\\]/', $filtras) OR preg_match('/(and|or|null|not)/i', $filtras)
					OR preg_match('/(union|select|from|where)/i', $filtras) OR preg_match('/(group|order|having|limit)/i', $filtras) OR preg_match('/(into|file|case)/i', $filtras)
					OR preg_match('/(--|#|\/\*)/', $filtras) OR preg_match('/(=|&|\|)/', $filtras)) {
			// no whitespaces, quotes, slashes, sqli boolean keywords, sqli select keywords, sqli select keywords, sqli operators, sqli comments, boolean operators
				$filtras = "";
				print '<script>alert("Netinkamas '.$filtras.' filtras")</script>';
			}
		}
	//------------------------- puslapiavimas --------------------------------------------
		$config = array();
		$config["base_url"] = base_url() . 'index.php/category/view_records/' . $this->uri->segment(3) . '/';
		$config['suffix'] = '/'.$this->uri->segment(5).'/'.$this->uri->segment(6).'/'.$this->uri->segment(7);
		$config["total_rows"] = $this->record->records_count($this->uri->segment(3));
		$config["per_page"] = 20;
		$config["uri_segment"] = 4;
		$config['next_tag_open'] = '<span class="sekantis">';
		$config['next_tag_close'] = '</span>';
		$this->pagination->initialize($config);

		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$this->bendra['links'] = $this->pagination->create_links();
	//-----------------------------------------------------------------------------------
		//if ($this->bendra['adm'] > 1) {
			$this->bendra['records'] = $this->record->get_records_by_product($this->uri->segment(3), 0, $config["per_page"], $page, $rikiuoti_pagal_lauka, $rikiuoti_kryptimi, $filtras);
		//}else {
		//	$this->bendra['records'] = $this->record->get_records_by_product($this->uri->segment(3), $this->bendra['usrid'], $config["per_page"], $page, $rikiuoti_pagal_lauka, $rikiuoti_kryptimi, $filtras);
		//}	
		// puslapio pavadinimui ir keliui
		$this->bendra['heading'] = $this->record->product_name($this->uri->segment(3));
		$this->bendra['categ'] = $this->record->parent_category_name_and_id($this->uri->segment(3));	
		//$this->bendra['produc_name'] = $this->record->product_name($this->uri->segment(3));	
		$this->bendra['produc_id'] = $this->uri->segment(3);
		
		$this->load->view('templates/header', $this->bendra);
		$this->load->view('templates/top', $this->bendra);
		$this->load->view('pages/records_list', $this->bendra);
		$this->load->view('templates/footer', $this->bendra);	
	}
	public function record_view($kat, $prod, $iras)
	{				
		$this->bendra['record'] = $this->record->get_record($this->uri->segment(5));	
		// puslapio pavadinimui ir keliui
		$this->bendra['heading'] = $this->bendra['record']->name;
		$this->bendra['categ'] = $this->record->parent_category_name_and_id($this->uri->segment(4));	
		$this->bendra['produc_name'] = $this->record->product_name($this->uri->segment(4));	
		$this->bendra['produc_id'] = $this->uri->segment(4);
		
		$this->load->view('templates/header', $this->bendra);
		$this->load->view('templates/top', $this->bendra);
		$this->load->view('pages/record_view', $this->bendra);
		$this->load->view('templates/footer', $this->bendra);	
	}
	public function delete()
	{
		$vartotojas = $this->session->userdata('logged_in');
		$this->record->delete_record($this->uri->segment(3), $vartotojas['id']);
		//redirect('category');
		// gryzta atgal i paskutini buvusi puslapi
		$ref = $this->input->server('HTTP_REFERER', TRUE);
		redirect($ref, 'location');
	}
	public function submit()
	{
		$vartotojas = $this->session->userdata('logged_in');
		$this->record->submit_record($this->uri->segment(3), $vartotojas['id']);
		//redirect('category');
		// gryzta atgal i paskutini buvusi puslapi
		$ref = $this->input->server('HTTP_REFERER', TRUE);
		redirect($ref, 'location');
	}
	public function create($kat=0, $prod=0)
	{
		$this->load->helper('form');
		$this->load->helper('ckeditor');

		$this->load->library('form_validation');
		$this->bendra['heading'] = 'Naujas įrašas';
		$this->bendra['title'] = 'Įrašo kūrimas';
		
		$this->form_validation->set_rules('record_name', 'Įrašo pavadinimas', 'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('link', 'Įrašo puslapis', 'trim|xss_clean');
		$this->form_validation->set_rules('content', 'Įrašo turinys', 'xss_clean|max_length[15000]|min_length[100]|required');
		$this->form_validation->set_rules('product', 'Įrašo prekė', 'required');
		
		$kat = $this->uri->segment(3);
		$prod = $this->uri->segment(4);

		if ($this->form_validation->run('') === FALSE)
		{
			$this->bendra['rec'] = new Record();
				$this->bendra['rec_kat'] = $kat;
				$this->bendra['rec_prod'] = $prod;	
			$this->load->view('templates/header', $this->bendra);
			$this->load->view('templates/top', $this->bendra);		
			$this->load->view('pages/record_create', $this->bendra);
			$this->load->view('templates/footer', $this->bendra);	
		}
		else
		{
			$vartotojas = $this->session->userdata('logged_in');
			$ir_id = $this->record->new_record($vartotojas['id']);
			//irasom iraso hash i DB
			$this->record->save_hashes($ir_id, $this->input->post('content', TRUE));
			$redirect = 'category/view_records/'.$prod.'';
			redirect('category');
		}
	}
/*	public function edit()
	{
		$this->load->helper('form');
		$this->load->helper('ckeditor');
		$this->load->library('form_validation');
		
		$this->bendra['heading'] = 'Įrašo redagavimas';
		$this->bendra['title'] = 'Įrašo redagavimas';
		
		$this->form_validation->set_rules('record_name', 'Įrašo pavadinimas', 'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('link', 'Įrašo puslapis', 'trim|xss_clean');
		$this->form_validation->set_rules('content', 'Įrašo turinys', 'xss_clean|min_length[100]|required');		
		$this->form_validation->set_rules('product', 'Įrašo prekė', 'required');		
		
		if ($this->form_validation->run('') === FALSE)
		{
			$this->bendra['rec'] = $this->record->get_record($this->uri->segment(5));
			if($this->bendra['rec'] != null){
				$this->load->view('templates/header', $this->bendra);	
				$this->load->view('templates/top', $this->bendra);
				$this->load->view('pages/record_create', $this->bendra);
				$this->load->view('templates/footer', $this->bendra);
			}else{
				// gryzta atgal i paskutini buvusi puslapi
				$ref = $this->input->server('HTTP_REFERER', TRUE);
				redirect($ref, 'location');
			} 
		}
		else
		{
			$irasas = $this->record->get_record($this->uri->segment(5));
			$vartotojas = $this->session->userdata('logged_in');
			//print_r($irasas);
			if($irasas->status_id == 3){ //jei accepted tai kuriam nauja
				$ir_id = $this->record->new_record($vartotojas['id']);
				//issaugom  hash irasus siam irasui
				$this->record->save_hashes($ir_id, $this->input->post('content', TRUE));
			}
			else{
				$this->record->edit_record($this->uri->segment(5), $vartotojas['id']);
				
				//pasalinam buvusius hash irasus tam irasui
				$this->record->delete_record_hash($this->uri->segment(5));
				//issaugom naujus hash irasus siam irasui
				$this->record->save_hashes($this->uri->segment(5), $this->input->post('content', TRUE));
			}
			redirect('category');
		}
	}
*/
//biski perdariau, kad nepasiklysti kas yra kas - paduodu per parametrus
	public function edit($kat=0, $prod=0, $iras=0)
	{
		$this->load->helper('form');
		$this->load->helper('ckeditor');
		$this->load->library('form_validation');
		
		$this->bendra['heading'] = 'Įrašo redagavimas';
		$this->bendra['title'] = 'Įrašo redagavimas';
		
		$this->form_validation->set_rules('record_name', 'Įrašo pavadinimas', 'trim|required|max_length[255]|xss_clean');
		$this->form_validation->set_rules('link', 'Įrašo puslapis', 'trim|xss_clean');
		$this->form_validation->set_rules('content', 'Įrašo turinys', 'xss_clean|max_length[15000]|min_length[100]|required');		
		$this->form_validation->set_rules('product', 'Įrašo prekė', 'required');		
		
		if ($this->form_validation->run('') === FALSE)
		{
			$this->bendra['rec'] = $this->record->get_record($iras);
			if($this->bendra['rec'] != null){
				$kategorija = $this->bendra['rec']->cat_id;
				if($kat != $kategorija){
					$kat = $kategorija;
				}
				$this->bendra['rec_kat'] = $kat;
				$produktas = $this->bendra['rec']->product_id;
				if($prod != $produktas){
					$prod = $produktas;
				}
				$this->bendra['rec_prod'] = $prod;
				$this->load->view('templates/header', $this->bendra);	
				$this->load->view('templates/top', $this->bendra);
				$this->load->view('pages/record_create', $this->bendra);
				$this->load->view('templates/footer', $this->bendra);
			}else{
				// gryzta atgal i paskutini buvusi puslapi
				$ref = $this->input->server('HTTP_REFERER', TRUE);
				redirect($ref, 'location');
			} 
		}
		else
		{
			$irasas = $this->record->get_record($iras);
			$vartotojas = $this->session->userdata('logged_in');
			//print_r($irasas);
			if($irasas->status_id == 3){ //jei accepted tai kuriam nauja
				$ir_id = $this->record->new_record($vartotojas['id']);
				//issaugom  hash irasus siam irasui
				$this->record->save_hashes($ir_id, $this->input->post('content', TRUE));
			}
			else{
				$this->record->edit_record($iras, $vartotojas['id']);
				
				//pasalinam buvusius hash irasus tam irasui
				$this->record->delete_record_hash($iras);
				//issaugom naujus hash irasus siam irasui
				$this->record->save_hashes($iras, $this->input->post('content', TRUE));
			}
			redirect('category');
		}
	}	
	public function view_select_products()
	{		
		$sarasas = $this->record->get_products_by_category($this->uri->segment(3), 0, 0, 'name', 'asc', '');
		//print_r ($sarasas);
		if($sarasas>0){
		echo json_encode($sarasas);
		}
	}	
}
?>