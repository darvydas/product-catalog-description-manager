<?php
class Record extends CI_Model {

	var $id = 0;
	var $name = "";
	var $link = "";
	var $content = "";
	var $categories_id = 0;
	var $status_id = 0;
	var $user_id = 0;
	
	var $cat_name = "";
	var $author = "";
	var $stat_name = "";
	
	var $product_id = 0;
	
	
	public function __construct()
	{
		$this->load->database('default');
	}
	
	public function get_products_by_category($category, $limit, $start, $sort, $kryptis, $filter)
	{
		$this->db->select('t1.*, t2.pgs_id as cat_id, t2.label as cat_name');
        $this->db->from('product AS t1, categories_menu AS t2');
		$this->db->where('t1.cat_id = t2.pgs_id');		
		if ($limit > 0) {$this->db->limit($limit, $start);}
        //$this->db->where('t1.state = 1');
		if($category>0){
			$this->db->where('t1.cat_id', $category);}
        //$this->db->where('t1.user_id = t2.id'); 
		
		$this->db->order_by($sort, $kryptis);
		//$this->db->group_by('t1.pre_id');
		$filt_uskl = "";
		if ($filter != ""){
		
			$filt_uskl = "(t1.pre_id LIKE '%".$filter."%' OR t1.name LIKE '%".$filter."%' OR t2.label LIKE '%".$filter."%' OR t1.describe LIKE '%".$filter."%' )";
			$this->db->where($filt_uskl);	
			
			/*$this->db->like('t1.pre_id', $filter);
			$this->db->or_like('t1.name', $filter);
			$this->db->or_like('t2.label', $filter);
			$this->db->or_like('t1.describe', $filter);*/
		}
		$query = $this->db->get();
		
		//print_r($this->db->last_query());
		
		if($query -> num_rows() > 0)
		   {
			 return $query->result();
		   }
		   else
		   {
			$query->free_result();
		   }
	}	
	public function products_count($category)
	{
		if ($category > 0) {
			$this->db->where('cat_id', $category);
		}
		$this->db->from('product');
		return $this->db->count_all_results();
	}	
	public function records_count($product)
	{
		if ($product > 0) {
			$this->db->where('product_id', $product);
		}
		$this->db->from('record');
		return $this->db->count_all_results();
	}
	public function get_records_by_product($product, $usr, $limit, $start, $sort, $kryptis, $filter)
	{
		if ($limit > 0) { //puslapiavimui
			$this->db->limit($limit, $start);
		} 
		if ($product > 0) {//jei id>0, konkretaus produkto irasai
			$this->db->where("t1.product_id", $product);
			$this->db->where("t4.pre_id", $product);
			$this->db->select('t4.cat_id');
		} else {//jei rodo visus irasus prideda produkto kuriame yra irasas pavadinima
			$this->db->select('t4.name AS prod_name');
			$this->db->where('t1.product_id = t4.pre_id');			
		}		
		$this->db->from('product AS t4');
		$this->db->from('record AS t1, user AS t2, status AS t3');
		$this->db->select('t1.*, t2.login AS author, t2.id AS author_id, t3.name AS stat_name, t3.delete AS stat_delete, t3.edit AS stat_edit');
		$this->db->select('h1.id as h_id, h1.date, h1.status_id');
		
		$this->db->select('MAX(100.0*t5.number_of_maches/t5.hash_in_first_record) as plagijatas, t5.second_record_id as plag_record');   
        $this->db->where('t1.user_id = t2.id');
        $this->db->where('h1.status_id = t3.id');
		$this->db->where('h1.record_id = t1.id');
		if ($usr > 0) {
			$this->db->where('t1.user_id', $usr);
		}
		$this->db->order_by($sort, $kryptis);
		
		if ($filter != ""){		
				$filt_uskl = "(t1.id LIKE '%".$filter."%' OR t1.name LIKE '%".$filter."%' OR t3.name LIKE '%".$filter."%' OR t2.login LIKE '%".$filter."%' OR h1.date LIKE '%".$filter."%')";
				$this->db->where($filt_uskl);

			// $this->db->like('t1.id', $filter);
			// $this->db->or_like('t1.name', $filter);
			// $this->db->or_like('t3.name', $filter);
			// $this->db->or_like('author', $filter);
			// $this->db->or_like('date', $filter);
			// /*$this->db->or_like('stat_edit', $filter);
			// $this->db->or_like('stat_delete', $filter);
			// $this->db->or_like('', $filter);*/
			// $this->db->or_like('plagijatas', $filter);
		}
		
		$this->db->join('record_similarities t5', 't1.id = t5.first_record_id', 'left');
		
		$this->db->join('record_history h1', 'h1.record_id = t1.id');
		$this->db->join('record_history h2', 'h2.record_id = t1.id and (h1.date < h2.date OR h1.date = h2.date AND h1.id < h2.id)', 'left');
		$this->db->where('h2.id IS NULL'); 

		$this->db->group_by('h1.record_id'); 
		
		
		$query = $this->db->get();
		if($query -> num_rows() > 0)
		   {
			 return $query->result();
		   }
		   else
		   {
			$query->free_result();
		   }
	}
	
	public function category_name($category){
		$this->db->select('label');
		$this->db->where('pgs_id', $category);
		$this->db->from('categories_menu');		
		$this -> db -> limit(1);
		
		$query = $this->db->get();

		$rez = $query->result();
		if(is_array($rez)){
			foreach ($rez[0] as $r){
				return $r;
			}			
		}
		return $rez;
	}		
	public function parent_category_name_and_id($product){
		$this->db->select('c.label, c.pgs_id');
		$this->db->from('categories_menu AS c');
		$this->db->from('product AS p');
		
		$this->db->where('p.pre_id', $product);
		$this->db->where('p.cat_id = c.pgs_id');
		$this->db->limit(1);
		
		$query = $this->db->get();

		$rez = $query->result();
		if(is_array($rez)){
			return $rez[0];		
		}
		return $rez;
	}	
	public function product_name($product){
		$this->db->select('name');
		$this->db->where('pre_id', $product);
		$this->db->from('product');		
		$this -> db -> limit(1);
		
		$query = $this->db->get();

		$rez = $query->result();
		if(is_array($rez)){
			foreach ($rez[0] as $r){
				return $r;
			}			
		}
		return $rez;
	}
	public function get_record($id)
	{
		$this->db->select('t1.*, t2.login AS author, t3.name AS stat_name, t4.name AS prod_name, t4.cat_id AS cat_id');
		$this->db->select('h1.id AS h_id, h1.date, h1.status_id, t5.pgs_id AS categories_id, t5.label AS categories_name');
		$this->db->from('record AS t1, user AS t2, status AS t3, product AS t4, categories_menu AS t5');
		$this->db->where("t1.id", $id);
		$this->db->where('h1.status_id = t3.id');
		$this->db->where('h1.record_id = t1.id');		
        $this->db->where('t1.user_id = t2.id');
		$this->db->where('t1.product_id = t4.pre_id');
		$this->db->where('t4.cat_id = t5.pgs_id');
		
		$this->db->join('record_history h1', 'h1.record_id = t1.id');
		$this->db->join('record_history h2', 'h2.record_id = t1.id and (h1.date < h2.date OR h1.date = h2.date AND h1.id <h2.id)', 'left');
		$this->db->where('h2.id IS NULL'); 
		
		$query = $this->db->get();
		$rez = $query->result();
		if(is_array($rez)){
			//print_r ($rez);
			return $rez[0];
		}
		return $rez;
	}
	public function get_record_id($name, $link, $content, $product_id, $user_id) 
	{
		$this->db->select('id');
		$this->db->where("name", $this->input->post('record_name', TRUE));
		$this->db->where("link", $this->input->post('link', TRUE));
		$this->db->where("content", $this->input->post('content', TRUE));
		$this->db->where("product_id", $this->input->post('product', TRUE));
		$this->db->where("user_id", $user_id);
		$this->db->limit(1);
		
		$query = $this->db->get('record');
		$rez = $query->result();
		if(is_array($rez)){
			foreach ($rez[0] as $r){
				return $r;
			}
		}		
		return $rez;
	}
	public function new_record($user_id)
	{	
		$irasas_record = array (
			'name' 			=> $this->input->post('record_name', TRUE),
			'link' 			=> $this->input->post('link', TRUE),
			'content'		=> $this->input->post('content', TRUE),
			'product_id'	=> $this->input->post('product', TRUE),
			'user_id' 		=> $user_id
		);	
		$this->db->insert('record', $irasas_record);
		
		$query = $this->get_record_id($irasas_record['name'], $irasas_record['link'], $irasas_record['content'], $irasas_record['product_id'], $irasas_record['user_id']);
		
		if($query > 0)
		{
			$this->insert_history($query, 1, 'naujas įrašas', $user_id);
			return $query;
		}
		else
		{
			return 'get_record_id nepavyko';
		}
	}
	
	/*public function get_user_by_key()
	{
		$this->db->select('id');
		$this->db->where("key", $this->input->post('key', TRUE));
		$us = $this->db->get('user');
		return $us->result();	
	}*/
	public function new_record_submit()
	{	
		$irasas_record = array (
			'name' 			=> $this->input->post('record_name', TRUE),
			'link' 			=> $this->input->post('link', TRUE),
			'content'		=> $this->input->post('content', TRUE),
			'product_id'	=> $this->input->post('product', TRUE),
			'user_id' 		=> $usr[0]->id
		);	
		
		//print_r($irasas_record);
		$this->db->insert('record', $irasas_record);
		
		$query = $this->get_record_id($irasas_record['name'], $irasas_record['link'], $irasas_record['content'], $irasas_record['product_id'], $irasas_record['user_id']);
		
		if($query > 0)
		{
			return $this->insert_history($query, 1, 'naujas įrašas', $usr[0]->id);
		}
		else
		{
			return 'get_record_id nepavyko';
		}
	}
    function edit_record($id, $user_id)
    {
		$this->insert_history($id, 1, 'redaguotas įrašas', $user_id);		
		
		$this->db->set('name', $this->input->post('record_name', TRUE));		
		$this->db->set('link', $this->input->post('link', TRUE));		
		$this->db->set('content', $this->input->post('content', TRUE));
		$this->db->set('product_id', $this->input->post('product', TRUE));
		$this->db->where('id', $id);

        $query = $this->db->update('record');

    }
	function get_record_content_and_product_id($record_id) // 
	{
		$this->db->select('content');
		$this->db->select('product_id');
		$this->db->where('id', $record_id);
		$this->db->from('record');
		$rez = $this->db->get();
		$duom = $rez->result();
		print $duom;
		if(is_array($duom)){
			return $duom[0];
		}		
		return $duom;
	}
	function accept_record($id, $user_id) // record id
	{
		$rec = $this->get_record_content_and_product_id($id);
		print_r($rec);
		$this->update_description_in_eshop_product($rec->product_id,$rec->content);
		$this->insert_history($id, 3, 'patvirtintas įrašas', $user_id);
	}
	public function update_description_in_eshop_product($pre_id, $description) 
	{
		$db2 = $this->load->database('parduotuve', TRUE);
		$db2->set('description', $description);
		$db2->set('edit_date', date('Y-m-d H:i:s'));  
		$db2->where('pre_id', $pre_id);
		
		return $db2->update('prekes_main');
	}
	
	function decline_record($id, $user_id)
	{
		$this->insert_history($id, 4, 'atšauktas įrašas', $user_id);
	}
	function delete_record($id, $user_id)
	{
		$this->insert_history($id, 5, 'ištrintas įrašas', $user_id);
	}
	function submit_record($id, $user_id)
	{
		$this->insert_history($id, 2, 'pasiūlytas įrašas', $user_id);
	}
	public function insert_history($record_id, $status, $comment, $user_id) 
	{
		$history = array (
			'record_id' 	=> $record_id,
			'status_id' 	=> $status,
			'comment'		=> $comment,
			'user_id' 		=> $user_id  //istorija keitusio vartotojo id
		);	
		return $this->db->insert('record_history', $history);
	}
	function delete_record_hash($record_id)
	{
		$this->db->delete('record_hash', array('record_id' => $record_id)); 
	}
	function save_hashes($record_id, $text){
		//print_r($text);
		$tekstas = strip_tags($text);
		$tekstas = str_replace(array("&nbsp;", "\t", "\n"), " ", $tekstas);
		//print_r($tekstas);
		$sakiniai = preg_split("/[.!?;]+/", $tekstas);
		//print_r($sakiniai);
		$uzklausa = "";
		foreach($sakiniai as $nr=>$sakinys){
			$kodas = MD5(strtolower(trim($sakinys)));
			$hash = array (
				'record_id' 	=> $record_id,
				'hash' 	=> $kodas,
				'order'		=> $nr
			);	
			$this->db->insert('record_hash', $hash);
			$uzklausa .= " or hash='".$kodas."'";
		}
		if(strlen($uzklausa)>0){
			$uzklausa = "(".substr($uzklausa, 3).")  AND record_id != ".$record_id;
			//SELECT record_id, COUNT(hash) as kiek_sakiniu FROM record_hash WHERE (hash='fb701655353d59be0e66f95a38f68de0' or hash='43c8781499467aa57aea7ef6487ffc2b') GROUP BY record_id
			$this->db->select('record_id');
			$this->db->select('COUNT(record_id) as kiek_sakiniu');
			$this->db->from('record_hash');
			$this->db->where($uzklausa); 
			$this->db->group_by("record_id");
			$duom = $this->db->get();
			$rez = $duom->result();
			if(is_array($rez)){
			
				$this->db->delete('record_similarities', array('first_record_id' => $record_id)); 
				foreach ($rez as $r){
				//print_r($r);
					$similar = array (
						'first_record_id' 	=> $record_id,
						'second_record_id' 	=> $r->record_id,
						'number_of_maches'		=> $r->kiek_sakiniu,
						'hash_in_first_record' => count($sakiniai)
					);	
					$this->db->insert('record_similarities', $similar);				
				}
				//dar reiketu atnaujinti ir i kita puse, bet siek tiek sudetinga, nes negalima lengvai gauti kiek jo sakiniu sutampa su kitais
			}
		}
	}
	function get_points($user_id)
	{
		$this->db->select('SUM(s.points) AS trust');
		$this->db->from('record_history as r');
		$this->db->where('r.user_id', $user_id);
		$this->db->join('status as s', 's.id = r.status_id', 'left');
		
		$duom = $this->db->get();
		$rez = $duom->result();
		if(is_array($rez)){
			return $rez[0];
		}
		return $rez;
	}
}
?>