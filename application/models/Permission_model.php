<?php

class AdminModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('image_lib');
    }

    function getUserPermission($filter){
    	$this->db->where($filter);
    	return $this->db->get('')
    }
}

?>