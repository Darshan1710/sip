<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class Package_model extends CI_Model{

	public function construct(){
		parent::__construct();
	}
	public function getDetails($table_name,$filter = NULL,$limit = NULL,$offset = NULL,$order_by = NULL){
		if($filter){
			$this->db->where($filter);
		}
		if($limit || $offset){
			$this->db->limit($limit,$offset);
		}
		if($order_by){
			$this->db->order_by($order_by);
		}
		return $this->db->get($table_name)->row_array();
	}

	public function getList($table_name,$filter = NULL,$limit = NULL,$offset = NULL,$order_by = NULL){
		if($filter){
			$this->db->where($filter);
		}
		if($limit || $offset){
			$this->db->limit($limit,$offset);
		}
		if($order_by){
			$this->db->order_by($order_by);
		}
		return $this->db->get($table_name)->result_array();
	}
	public function getInList($table_name,$column,$filter = NULL){
        $this->db->where_in($column,$filter);
        return $this->db->get($table_name)->result_array();
    }

	public function insert($table_name,$data){
		return $this->db->insert($table_name,$data);
	}

	public function update($table_name,$filter,$data){
		$this->db->where($filter);
		return $this->db->update($table_name,$data);
	}

	public function getCustomEnquiry(){
		$this->db->select('pt.*,ce.*,ce.id as enquiry_id');
		$this->db->join('package_type pt','pt.id = ce.package_type');
		return $this->db->get('custom_enquiry ce')->result_array();
	}
	public function getCustomEnquiryDetails($filter){
		$this->db->select('ce.*,pt.*,pt.id as package_type_id');
		if($filter){
			$this->db->where($filter);
		}
		$this->db->join('package_type pt','pt.id = ce.package_type');
		return $this->db->get('custom_enquiry ce')->row_array();
	}

	public function getPackageEnquiry(){
		$this->db->select('e.*,p.*,e.id as enquiry_id');
		$this->db->join('package p','e.package_id = p.id');
		$this->db->join('package_type pt','pt.id = p.package_type');
		return $this->db->get('enquiry e')->result_array();
	}
	public function getPackageEnquiryDetails($filter){
		$this->db->select('e.*,p.*,e.id as enquiry_id,p.id as package_id');
		if($filter){
			$this->db->where($filter);
		}
		$this->db->join('package p','e.package_id = p.id');
		$this->db->join('package_type pt','pt.id = p.package_type');
		return $this->db->get('enquiry e')->row_array();
	}
	public function getReviewList($filter){
        $this->db->select('co.id as comment_id,co.*,c.*,cl.*,co.created_at as created_at');
        $this->db->where($filter);
        $this->db->join('customer c','c.id = co.customer_id');
        $this->db->join('comment_likes cl','cl.rating_id = co.id','left outer');
        return $this->db->get('comment co')->result_array();
    }
    public function getReplyList($filter){
    	$this->db->select('first_name,last_name,cr.*,cr.id as reply_id,crl.flag as flag');
        $this->db->where($filter);
        $this->db->join('customer c','c.id = cr.customer_id');
        $this->db->join('comment_reply_likes crl','crl.reply_id = cr.id','left outer');
        return $this->db->get('comment_reply cr')->result_array();
    }

	
}


?>