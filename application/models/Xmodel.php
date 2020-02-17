<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Xmodel extends CI_Model
{
	public $table;
	public function __construct()
	{
		parent::__construct();
		$this->table =substr(get_Class($this),0,strpos(get_Class($this),"_model")); //get table name by cutting '_model' : topic_model => table=topic
		$this->table= strtolower($this->table);
		$this->load->database();
	}
	
	public function getLastId($tablename=""){
		if($tablename=="")
		{
			$tablename = $this->table;
		}
			$query="SELECT AUTO_INCREMENT as id FROM information_schema.tables";
			$query.=" WHERE table_name =  '$tablename'";
		 	$query= $this->db->query($query);
		 	return $query->row()->id;
	}
	
	public function exquery($query,$param=null){
		$query = $this->db->query($query,$param);
		return $query->result_array();
		
	} 
        public function exinsert($query,$param=null){
		$query = $this->db->query($query,$param);
                return $query;
	}
        public function exUpdate($query,$param=null){
		$query = $this->db->query($query,$param);
                return $query;
	}
	
	public function save($data,$tablename="")
	{
		if($tablename=="")
		{
			$tablename = $this->table;
		}
		$op = 'update';
		$keyExists = FALSE;
		$fields = $this->db->field_data($tablename);
		foreach ($fields as $field)
		{
			if($field->primary_key==1)
			{
				$keyExists = TRUE;
				if(isset($data[$field->name]))
				{
					$this->db->where($field->name, $data[$field->name]);
				}
				else
				{
					$op = 'insert';
				}
			}
		}
	
		if($keyExists && $op=='update')
		{
			$this->db->set($data);
			$this->db->update($tablename);
			if($this->db->affected_rows()==1)
			{
				return $this->db->affected_rows();
			}
		}
	
		$this->db->insert($tablename,$data);
	
		return $this->db->affected_rows();
	
	}
	
	function search($conditions=NULL,$tablename="",$limit=500,$offset=0)
	{
		if($tablename=="")
		{
			$tablename = $this->table;
		}
		if($tablename=="TestDetails"){
			$this->db->order_by("TimeSubmitted", "desc");
				
		}
//		if($tablename=="photo" || $tablename=="video" || $tablename=="press_kit" ){
//			$this->db->order_by("id", "desc");
//		}
		if($conditions != NULL)
			$this->db->where($conditions);
	
		$query = $this->db->get($tablename,$limit,$offset);
		return $query->result_array();
	}
	
	function insert($data,$tablename="")
	{
		if($tablename=="")
			$tablename = $this->table;
		$this->db->insert($tablename,$data);
		return $this->db->affected_rows();
	}
	
	function update($data,$conditions,$tablename="")
	{
		if($tablename=="")
			$tablename = $this->table;
		$this->db->where($conditions);
		$this->db->update($tablename,$data);
		return $this->db->affected_rows();
	}
	

	function delete($conditions,$tablename="")
	{
		if($tablename=="")
			$tablename = $this->table;
		$this->db->where($conditions);
		$this->db->delete($tablename);
		return $this->db->affected_rows();
	}
	function stripAttributes($s, $allowedattr = array()) {
		if (preg_match_all("/<[^>]\\s([^>])\\/*>/msiU", $s, $res, PREG_SET_ORDER)) {
			foreach ($res as $r) {
				$tag = $r[0];
				$attrs = array();
				preg_match_all("/\\s.['\"]).\\1/msiU", " " . $r[1], $split, PREG_SET_ORDER);
				foreach ($split as $spl) {
					$attrs[] = $spl[0];
				}
				$newattrs = array();
				foreach ($attrs as $a) {
					$tmp = explode("=", $a);
					if (trim($a) != "" && (!isset($tmp[1]) || (trim($tmp[0]) != "" && !in_array(strtolower(trim($tmp[0])), $allowedattr)))) {
	
					} else {
						$newattrs[] = $a;
					}
				}
				$attrs = implode(" ", $newattrs);
				$rpl = str_replace($r[1], $attrs, $tag);
				$s = str_replace($tag, $rpl, $s);
			}
		}
		$s = str_replace(array('<b>', '</b>', '<strong >', '<strong>', '</strong>'), array('', '', '', '', ''), $s);
		return $s;
	}
	
}