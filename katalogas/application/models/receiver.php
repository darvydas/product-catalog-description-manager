<?php
class Receiver extends CI_Model {

	var $pgs_id = 0;
	var $name = "";
	var $label = "";
	var $tev_id = "";
	var $sort = "";
	var $cat_id = "";
	var $describe = "";

	public function __construct()
	{
		//$this->load->database('parduotuve', TRUE);
	}
	public function update_categories()
	{
		$grupes = $this->get_categories();
		$mas = array();
		foreach($grupes as $grupe)
		{
			if ($this->duplicate_category($grupe, $grupe->pgs_id) > 0) //if category has duplicate
			{
				if ($this->duplicate_category($grupe, 0) == 0){ //if no fully matched results, update
				
					$this->update_category($grupe);
					//print_r( $grupe);
					$mas['upd'][] = $grupe;
				}else {
				//no update
				//print "tokia grupe jau yra ".$grupe->pgs_id.", ";
				}
			}else
			{ //no duplicates, insert
				$this->insert_category($grupe);
				$mas['new'][] = $grupe;
			}
		}
		//print_r($mas);
		return $mas;
	}	
	public function get_categories()
	{
		$db2 = $this->load->database('parduotuve', TRUE);
		$db2->from('grupes_main');
		$db2->select('name, pgs_id, tev_id');
		
		$query = $db2->get();
		
		$rez = $query->result();
		// print_r($rez);
		return $rez;
	}	
	public function duplicate_category($grupe, $pgs_id)
	{
		$this->load->database();
		$this->db->from('categories_menu');
		$this->db->select('label, pgs_id, tev_id');
		if ($pgs_id == 0) {
			$this->db->where('label', $grupe->name);
			$this->db->where('tev_id', $grupe->tev_id);
		}
		$this->db->where('pgs_id', $grupe->pgs_id);
		$this->db->limit(1);
		
		$query = $this->db->get();

		return $query->num_rows();
	}
	public function update_category($grupe)
	{
		$this->load->database();
		$this->db->set('label', $grupe->name);
		$this->db->set('tev_id', $grupe->tev_id);
		$this->db->where('pgs_id', $grupe->pgs_id);

		return $this->db->update('categories_menu');
	}
	public function insert_category($grupe)
	{
		$this->load->database();
		$ins = array (
						'label' 		=> $grupe->name,
						'pgs_id' 		=> $grupe->pgs_id,
						'tev_id'		=> $grupe->tev_id
					);
		return $this->db->insert('categories_menu', $ins);
	}
	public function update_products()
	{
		$prekes = $this->get_products();
		$mas = array();
		foreach($prekes as $preke)
		{
			if ($this->duplicate_product($preke, $preke->pre_id) > 0) //if product has duplicate
			{
				if ($this->duplicate_product($preke, 0) == 0) //if no fully matched results, update
				{ 				
					$this->update_product($preke);
					//print_r( $preke);
					$mas['upd'][] = $preke;
				}else {
				//no update
				//print "tokia preke jau yra ".$preke->pre_id.", ";
				}
			}else
			{ //no duplicates, insert
				$this->insert_product($preke);
				$mas['new'][] = $preke;
			}
		}
		//print_r($mas);
		return $mas;
	}
	public function get_products()
	{
		$db2 = $this->load->database('parduotuve', TRUE);
		$db2->select('name, pre_id, pgs_id, short_description');
		$query = $db2->get('prekes_main');
		
		$rez = $query->result();
		//print_r($rez);
		return $rez;
	}
	public function duplicate_product($preke, $pre_id)
	{
		$this->load->database();
		$this->db->from('product');
		$this->db->select('name, pre_id, cat_id, describe');
		if ($pre_id == 0) {
			$this->db->where('name', $preke->name);
			$this->db->where('cat_id', $preke->pgs_id);
			$this->db->where('describe', $preke->short_description);			
		}
		$this->db->where('pre_id', $preke->pre_id);
		$this->db->limit(1);
		
		$query = $this->db->get();

		return $query->num_rows();
	}
	public function update_product($preke)
	{
		$this->load->database();
		$this->db->set('name', $preke->name);
		$this->db->set('cat_id', $preke->pgs_id);
		$this->db->set('describe', $preke->short_description);
		$this->db->where('pre_id', $preke->pre_id);

		return $this->db->update('product');
	}
	public function insert_product($preke)
	{
		$this->load->database();
		$ins = array (
						'pre_id'		=> $preke->pre_id,
						'cat_id'		=> $preke->pgs_id,
						'name' 			=> $preke->name,
						'describe'		=> $preke->short_description
					);
		return $this->db->insert('product', $ins);
	}
}
?>