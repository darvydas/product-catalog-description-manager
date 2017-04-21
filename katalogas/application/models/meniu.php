<?php
class Meniu extends CI_Model {
	var $id;
	var $label;
	var $link;
	var $tev_id;
	var $order;
	var $childs;
	
	public function __construct()
	{
		$this->load->database();
	}

	//pirmas budas, kada is DB daug uzklausu daro
	public function getTree1($id)
	{
		$mas = array();
		$this->db->where("tev_id", $id);
		$query = $this->db->get('categories_menu');
		$irasai = $query->result();
		foreach($irasai as $irasas){
			$mas[$irasas->id] = $irasas;
			$vaikai = $this->getTree1($irasas->id);
			if(!empty($vaikai)){
				$mas[$irasas->id]->childs = $vaikai;
			}		
		}
		return $mas;
	}
	
	//antras budas, kada is DB paima vienu metu ir tada su php delioja medi
	public function getTree2()
	{
		$this->db->order_by("tev_id, sort");
		$query = $this->db->get('categories_menu');
		$irasai = $query->result();
		$menu = array(
		   'items' => array(),
		   'parents' => array()
		);
		foreach ($irasai as $ob)
		{
		   $menu['items'][$ob->pgs_id] = $ob;
		   $menu['parents'][$ob->tev_id][] = $ob->pgs_id;
		}		
		$graz = $this->form_tree2(0, $menu);	
		return $graz;
	}

	public function form_tree2($id, $meniu){	
		if(!empty($meniu['parents'][$id])){
			$mas = array();
			$tev_id = $meniu['parents'][$id];
			foreach($tev_id as $it){
				$mas[$it] = $meniu['items'][$it];
				$vaikai = $this->form_tree2($it, $meniu);
				$mas[$it]->childs = $vaikai;
			}
			return $mas;
		}
	}
	
	//antras budas, kada is DB paima vienu metu ir tada su php delioja medi, bet tik tas kategorijas, kuriose yra bent vienas irasas
	public function getTree3()
	{
		$this->db->select("count(*) as kiek_p, c.*, p.cat_id as kateg");
		$this->db->order_by("tev_id, sort");	
		$this->db->from('categories_menu as c');
		$this->db->join('product as p', 'c.pgs_id = p.cat_id', 'left');
		$this->db->group_by("c.id");
		$query = $this->db->get();
		$irasai = $query->result();
		$menu = array(
		   'items' => array(),
		   'parents' => array()
		);
		foreach ($irasai as $ob)
		{
		   $menu['items'][$ob->pgs_id] = $ob;
		   $menu['parents'][$ob->tev_id][] = $ob->pgs_id;
		}	
	
		$graz = $this->form_tree3(0, $menu);	
		return $graz;
	}	

	public function form_tree3($id, $meniu){
//print_r($meniu);		
		if(!empty($meniu['parents'][$id])){
			$mas = array();
			$tev_id = $meniu['parents'][$id];
			foreach($tev_id as $it){
				$mas[$it] = $meniu['items'][$it];
				$vaikai = $this->form_tree3($it, $meniu);
				$mas[$it]->childs = $vaikai;
			}
			return $mas;
		}
	}
	
}
?>

