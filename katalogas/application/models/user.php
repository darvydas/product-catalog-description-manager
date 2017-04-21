<?php
class User extends CI_Model {

	var $id = 0;
	var $login = "";
	var $pass = "";
	var $mail = "";
	var $active = false;
	var $privilege_id = 0;

	public function __construct()
	{
		$this->load->database();
	}

	public function get_user($id)
	{
		$this->db->where("id", $id);
		$query = $this->db->get('user');
		$rez = $query->result();
		if(is_array($rez)){
			return $rez[0];
		}
		
		return $rez;
	}
	public function get_records($usr, $limit, $start)
	{
		if ($limit > 0) { //puslapiavimui
			$this->db->limit($limit, $start);
		}
		$this->db->select('t4.name AS prod_name');
		$this->db->where('t1.product_id = t4.pre_id');		
		$this->db->select('t4.cat_id');		
		$this->db->from('record AS t1, status AS t3, product AS t4');
		$this->db->select('t1.*, t3.name AS stat_name, t3.delete AS stat_delete, t3.edit AS stat_edit');
		$this->db->select('h1.id as h_id, h1.date, h1.status_id');
		
		/*$this->db->select('t2.login AS author');
		$this->db->from('user AS t2');
		$this->db->where('t1.user_id = t2.id');*/
		
		$this->db->select('MAX(100.0*t5.number_of_maches/t5.hash_in_first_record) as plagijatas, t5.second_record_id as plag_record');        
        $this->db->where('h1.status_id = t3.id');
		$this->db->where('h1.record_id = t1.id');
		$this->db->where('t1.user_id', $usr);
		
		$this->db->join('record_similarities t5', 't1.id = t5.first_record_id', 'left');
		
		$this->db->join('record_history h1', 'h1.record_id = t1.id');
		$this->db->join('record_history h2', 'h2.record_id = t1.id and (h1.date < h2.date OR h1.date = h2.date AND h1.id <h2.id)', 'left');
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
	public function get_users($limit, $start, $sort, $kryptis, $filter)
	{
		$this->db->select('u.*, SUM(s.points) AS trust');
		$this->db->from('user as u');
		$this->db->join('record_history as r', 'r.user_id = u.id', 'left');
		$this->db->join('status as s', 's.id = r.status_id', 'left');
		
		if ($limit > 0) {$this->db->limit($limit, $start);}
		$this->db->order_by($sort, $kryptis);
		$filt_uskl = "";
		if ($filter != ""){					
			$filt_uskl = "(u.login LIKE '%".$filter."%' OR u.mail LIKE '%".$filter."%')";
			$this->db->where($filt_uskl);	
		}
		$this->db->group_by("u.id"); 
		
		/*SELECT u.id, sum(s.points) as kiek FROM user as u 
		LEFT JOIN record_history as r on u.id = r.user_id 
		LEFT JOIN status as s on r.status_id = s.id 
		Group by u.id*/
		
		$query = $this->db->get();		
		return $query->result();
	}
	public function users_count()
	{
		$this->db->select('login');
		$this->db->from('user');
		return $this->db->count_all_results();
	}	
	public function insert_user()
	{		
		$this->login 	= $this->input->post('login_name', TRUE);
		$this->pass 	= MD5("USR_".trim($this->input->post('password', TRUE)));
		$this->mail		= $this->input->post('mail', TRUE);
		$this->active 	= $this->input->post('active', TRUE);	
		$this->privilege_id 	= $this->input->post('privilege_id', TRUE);	
		
		return $this->db->insert('user', $this);
	}

    function update_user()
    {
		$this->db->set('login', $this->input->post('login_name', TRUE));
		$pas = trim($this->input->post('password', TRUE));
		if(strlen($pas)>0){
			$this->db->set('pass', MD5("USR_".$this->input->post('password', TRUE)));
		}
		$this->db->set('mail', $this->input->post('mail', TRUE));
		$this->db->set('active', $this->input->post('active', TRUE));
		$this->db->set('privilege_id', $this->input->post('privilege_id', TRUE));
		$this->db->where('id', $this->input->post('id', TRUE));

        $this->db->update('user');
    }
	
	function delete_user($id)
	{
		$this->db->set('active', 0);
		$this->db->where('id', $id);

        $this->db->update('user');
	}
	
	 function login($username, $password)
	 {
	   $this -> db -> select('id, login, pass, active');
	   $this -> db -> from('user');
	   $this -> db -> where('login = ' . "'" . $username . "'");
	   $this -> db -> where('pass = ' . "'" . MD5("USR_".trim($password)) . "'");
	   $this -> db -> where('active = 1');
	   $this -> db -> limit(1);

	   $query = $this -> db -> get();

	   if($query -> num_rows() == 1)
	   {
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }
	 }
	 
	 function register_username($unique_username)
	 {
	   $this -> db -> select('id, login, pass, mail, active');
	   $this -> db -> from('user');
	   $this -> db -> where('login = ' . "'" . $unique_username . "'");
	   $this -> db -> limit(1);

	   $query = $this -> db -> get();

	   if($query -> num_rows() == 1)
	   {
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }
	 }
	 
	function register_email($unique_email)
	{
		$this -> db -> select('id, login, pass, mail, active');
		$this -> db -> from('user');
		$this -> db -> where('mail = ' . "'" . $unique_email . "'");
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	public function user_records_count($user_id)
	{
		$this->db->where('user_id', $user_id);
		$this->db->from('record');
		return $this->db->count_all_results();
	}
	public function get_adm($user_id)
	{
		$this->db->select('privilege_id as adm');
		$this->db->where('id', $user_id);
		$this->db->limit(1);
		$this->db->from('user');

		$query = $this->db->get();
		$rez = $query->result();
		if(is_array($rez)){
			return $rez[0]->adm;
		}
	}
}
?>