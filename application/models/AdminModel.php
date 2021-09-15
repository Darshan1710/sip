<?php

class AdminModel extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('image_lib');
    }



    public function getDetails($table_name = NULL,$filter = NULL,$limit = NULL,$offset = NULL,$order_by = NULL){

        if($filter){
            $this->db->where($filter);
        }
        if($limit || $offset){
            $this->db->limit($limit,$offset);
        }
        if($order_by){
            $this->db->order_by($order_by,'desc');
        }

        return $this->db->get($table_name)->row_array();
    }

    public function getList($table_name = NULL,$filter = NULL,$join = NULL,$select = NULL,$limit = NULL,$offset = NULL,$order_by = NULL){

        if($select){
            $this->db->select($select,false);
        }
        if($filter){
            $this->db->where($filter);
        }
        // if($limit || $offset){
        //     $this->db->limit($limit,$offset);
        // }
        // $this->db->limit(50);
        if($order_by){
            $this->db->order_by($order_by);
        }
        if($join){
            $joins = explode(',',$join);

            $this->db->join($joins[0],$joins[1]);
        }
        return $this->db->get($table_name)->result_array();
    }

    public function getMulitple($table_name,$ids,$filter = NULL){

        if($filter){
            $this->db->where($filter);
        }
        if($ids){   
           $this->db->where_in('id',$ids); 
        }
        if($data){
            return $this->db->get($table_name)->result_array();
        }else{
            return false;
        }
    }
    public function insert($table_name,$data){
        // $data['created_at'] = date('Y-m-d h:i:s');
        $this->db->insert($table_name,$data);
        return $this->db->insert_id();
    }
    public function insertBatch($table_name,$data){
        return $this->db->insert_batch($table_name,$data);
    }
    public function updateBatch($table_name,$data,$column_name){
        return $this->db->update_batch($table_name,$data,$column_name);
    }
    public function delete($table_name,$filter){
        $this->db->where($filter);
        return $this->db->delete($table_name);
    }

    public function update($table_name,$filter = NULL,$data = NULL){

        if($filter){
            $this->db->where($filter);
        }
        if($data){
            return $this->db->update($table_name,$data);
        }else{
            return false;
        }
    }
    public function updateMulitple($table_name,$ids,$data = NULL){

        if($ids){
           $this->db->where_in('id',$ids); 
        }
        if($data){
            return $this->db->update($table_name,$data);
        }else{
            return false;
        }
    }
    public function getProductList(){
        $this->db->select('p.id as product_id,p.*,c.*,p.status as product_status,p.created_at as created');
        $this->db->join('categories c','c.id = p.category_id');
        $this->db->order_by('p.created_at','desc');
        return $this->db->get('products p')->result_array();
    }

    public function getOrderDetails($filter){
        if($filter){
         $this->db->where($filter);   
        }
        $this->db->select('p.id as product_id,p.*,od.*');
        $this->db->join('products p','p.id = od.product_id');
        $this->db->join('order_masters o','o.id = od.order_id');
        return $this->db->get('order_details od')->result_array();
    }
    public function getEnquiryDetails($filter){
        if($filter){
         $this->db->where($filter);   
        }
        return $this->db->get('enquiries ed')->result_array();
    }
    public function getOrderList(){
        $this->db->select('o.id as order_id,o.*,c.*');
        $this->db->where('om.status','1');
        $this->db->join('customers c','c.unique_id = o.customer_unique_id');
        $this->db->order_by('o.id','desc');
        return $this->db->get('order_masters o')->result_array();
    }
    public function getOrderMasterData($filter){
        $this->db->where($filter);
        $this->db->where('o.status','1');
        $this->db->select('c.*,o.*,o.id as order_id,CONCAT(street_address,",",city,",",pincode) as address');
        $this->db->join('customers c','c.unique_id = o.customer_unique_id','left');
        $this->db->join('customer_addresses ca','c.unique_id = ca.customer_unique_id','left');
        return $this->db->get('order_masters o')->row_array();
    }
    public function getEnquiryMasterData($filter){
        $this->db->where($filter);
        return $this->db->get('enquiry_master em')->row_array();
    }
    public function getCustomerNumber($mobile){
        $this->db->select('mobile');
        $this->db->like('mobile',$mobile);
        $this->db->order_by('name','ASC');
        return $this->db->get('customers')->result_array();
    }
    public function getProductData($filter){
        $this->db->where($filter);
        return $this->db->get('products p')->row_array();
    }


    //order
    public function getOrderDetailsRows($postData){
        $this->_get_order_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllOrderDetails(){
        $this->db->from('order_masters');
        return $this->db->count_all_results();
    }
    public function countFilteredOrderDetails($postData){
        $this->_get_order_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_order_details_datatables_query($postData){
        
        $this->db->select('o.id as order_id,o.created_at as order_created_at,o.*,c.*');
        $this->db->join('customers c','c.unique_id = o.customer_unique_id','left');
        $this->db->order_by('o.id','desc');
        $this->db->where('o.status','1');
        $this->db->from('order_masters o');
        // Set orderable column fields
        $this->column_order = array(null,'c.name','c.mobile','c.email','o.id','order_status','o.created_at');

        // Set searchable column fields
        $this->column_search = array('c.name','c.mobile','c.email','o.id','order_status','o.created_at');
        // Set default order
        $this->order = array('o.created_at' => 'desc');  



        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    if ($value['name'] == 'order_status') {
                        $value['search']['value']--;
                    }
                    if($value['name'] != ''){
                        if($value['name'] == 'o.created_at'){
                                $dates            = explode('-',$value['search']['value']);
                                $start_date       = date('md',strtotime($dates['0']));
                                $end_date         = date('md',strtotime($dates['1']));
                                $this->db->where("DATE_FORMAT(c.created_at,'%m%d') >=", $start_date);
                                $this->db->where("DATE_FORMAT(c.created_at,'%m%d') <=", $end_date);
                         }else{
                                $this->db->like($value['name'],$value['search']['value']);
                         }
                    }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){

            if($postData['search']['value']){
                if($i===0){
                        $this->db->group_start();
                        $this->db->like($item, $postData['search']['value']);
                }else{
                        $this->db->or_like($item, $postData['search']['value']);  
                    
                }
                if(count($this->column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
         


        if(isset($postData['order'])){
            if($postData['order'][0]['column'] == '1' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5') {
                $this->db->order_by($this->column_order[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            }
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    //product
    public function getProductDetailsRows($postData){
        $this->_get_product_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllProductDetails(){
        $this->db->from('products');
        return $this->db->count_all_results();
    }
    public function countFilteredProductDetails($postData){
        $this->_get_product_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_product_details_datatables_query($postData){
        
        $this->db->select('p.*,p.id as product_id,category_name');
        $this->db->join('categories c','c.id = p.category_id');
        $this->db->join('home_section_products hsp','hsp.product_id = p.id','left');
        $this->db->order_by('p.id','desc');
        $this->db->from('products p');
        // Set orderable column fields
        $this->column_order = array(null,'product_name','product_type','packaging_size','unit_price','sell_price','category_name','p.status','new_products','recommended_products','p.created_at');

        // Set searchable column fields
        $this->column_search = array('product_name','product_type','packaging_size','unit_price','sell_price','category_name','new_products','recommended_products','p.status','p.created_at');
        // Set default order
        $this->order = array('p.created_at' => 'desc');  



        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    if ($value['name'] == 'status') {
                        $value['search']['value']--;
                    }
                    if($value['name'] != ''){
                        if($value['name'] == 'p.created_at'){
                                $dates            = explode('-',$value['search']['value']);
                                $start_date       = date('md',strtotime($dates['0']));
                                $end_date         = date('md',strtotime($dates['1']));
                                $this->db->where("DATE_FORMAT(p.created_at,'%m%d') >=", $start_date);
                                $this->db->where("DATE_FORMAT(p.created_at,'%m%d') <=", $end_date);
                         }else if($value['name'] == 'new_products'){
                            if($value['search']['value'] == '1'){
                                $this->db->like('hsp.section_id',$value['search']['value']);
                            }
                         }else if($value['name'] == 'recommended_products'){
                            if($value['search']['value'] == '1'){
                                $this->db->like('hsp.section_id',$value['search']['value']);
                            }
                         }else{
                                $this->db->like($value['name'],$value['search']['value']);
                         }
                    }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){

            if($postData['search']['value']){
                if($i===0){
                        $this->db->group_start();
                        $this->db->like($item, $postData['search']['value']);
                }else{
                        $this->db->or_like($item, $postData['search']['value']);  
                    
                }
                if(count($this->column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
         


        if(isset($postData['order'])){
            if($postData['order'][0]['column'] == '1' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5') {
                $this->db->order_by($this->column_order[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            }
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    //sale
    public function getSaleDetailsRows($postData){
        $this->_get_sale_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllSaleDetails(){
        $this->db->from('order_masters');
        return $this->db->count_all_results();
    }
    public function countFilteredSaleDetails($postData){
        $this->_get_sale_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_sale_details_datatables_query($postData){
        
        $this->db->select('o.id as order_id,o.*,c.*');
        $this->db->where('o.status','1');
        $this->db->join('customers c','c.unique_id = o.customer_unique_id','left');
        $this->db->order_by('o.id','desc');
        $this->db->from('order_masters o');
        // Set orderable column fields
        $this->column_order = array(null,'c.name','c.mobile','c.email','c.address','o.id as order_id','order_status','o.created_at');

        // Set searchable column fields
        $this->column_search = array('c.name','c.mobile','c.email','c.address','o.id as order_id','order_status','o.created_at');
        // Set default order
        $this->order = array('o.created_at' => 'desc');  


        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    if($value['name'] == 'o.created_at'){
                            $dates            = explode('-',$value['search']['value']);
                            $start_date       = date('md',strtotime($dates['0']));
                            $end_date         = date('md',strtotime($dates['1']));
                            $this->db->where("DATE_FORMAT(c.created_at,'%m%d') >=", $start_date);
                            $this->db->where("DATE_FORMAT(c.created_at,'%m%d') <=", $end_date);
                     }else if($value['name'] == 'order_id'){
                            $this->db->or_like('o.id',$value['search']['value']);
                     }else{
                            $this->db->or_like($value['name'],$value['search']['value']);
                     }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){
            if($postData['search']['value']){
                if($i===0){
                        $this->db->group_start();
                        $this->db->like($item, $postData['search']['value']);
                }else{
                        $this->db->or_like($item, $postData['search']['value']);  
                    
                }
                if(count($this->column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
         


        if(isset($postData['order'])){
            if($postData['order'][0]['column'] == '1' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5') {
                $this->db->order_by($this->column_order[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            }
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getOrderGraphData($first_date = false,$last_date = false,$type){
        if($first_date){
            $this->db->where('DATE(created_at) >=',$first_date);    
        }
        if($last_date){
            $this->db->where('DATE(created_at) <=',$last_date);    
        }
        $this->db->group_by($type.'(created_at)'); 
        $this->db->select('SUM(final_total) as final_total,DATE(created_at) as created_at');
        return $this->db->get('order_masters')->result_array();
    }
    public function getEnquiryGraphData($first_date = false,$last_date = false,$type){
        if($first_date){
            $this->db->where('DATE(created_at) >=',$first_date);    
        }
        if($last_date){
            $this->db->where('DATE(created_at) <=',$last_date);    
        }
        $this->db->group_by($type.'(created_at)'); 
        $this->db->select('COUNT(id) as final_count,DATE(created_at) as created_at');
        return $this->db->get('enquiry_master')->result_array();
    }
    public function getDashboardData(){
            $query = "SELECT 
              ( SELECT COUNT(id) FROM customers WHERE DATE(created_at) = CURDATE())  AS todays_customer,
              
              ( SELECT COUNT(id) FROM order_masters WHERE DATE(created_at) = CURDATE())  AS todays_order,
              ( SELECT SUM(final_total) FROM order_masters WHERE DATE(created_at) = CURDATE())  AS todays_sale,
              
              ( SELECT SUM(final_total) FROM order_masters WHERE DATE(created_at) = CURDATE())  AS todays_sale,
              ( SELECT SUM(rate * qty) FROM order_details WHERE DATE(created_at) = CURDATE() AND product_status = '3') AS todays_damage,
              ( SELECT COUNT(id) FROM customers)  AS total_customer,
              
              ( SELECT COUNT(id) FROM order_masters)  AS total_order,
              ( SELECT SUM(final_total) FROM order_masters)  AS total_sale,
             
              ( SELECT SUM(rate * qty) FROM order_details WHERE product_status = '3')  AS total_damage";

            $query_result = $this->db->query($query);
            return $query_result->row_array();  
    }
    public function getCustomerList(){
        $this->db->select('c.*,em.id as enquiry_id,em.*');
        $this->db->join('customer_1 c','c.unique_id = em.customer_unique_id');
        return $this->db->get('enquiry_master em')->result_array();
    }
    
    public function getDamageProductList(){
        $this->db->select('dm.*,dd.*,product_name,dm.id as damage_id');
        $this->db->join('damage_details dd','dd.damage_id = dm.id');
        $this->db->join('products p','p.id = dd.product_id');
        $this->db->order_by('dm.id','desc');
        $this->db->group_by('dm.id');
        return $this->db->get('damage_master dm')->result_array();
    }
    public function getDamageDetails($filter){
        if($filter){
            $this->db->where($filter);
        }
        $this->db->select('dm.*,dd.*,product_name');
        $this->db->join('damage_details dd','dd.damage_id = dm.id');
        $this->db->join('products p','p.id = dd.product_id');
        $this->db->join('stock s','s.product_id = dd.product_id');
        return $this->db->get('damage_master dm')->result_array();
    }


    public function getOrderProductDetails($filter){
        if($filter){
         $this->db->where($filter);   
        }
        $this->db->select('SUM(qty) as total_sell_qty,SUM(price) as total_sell_price');
        return $this->db->get('order_details p')->row_array();
    }
    public function getCustomerReport($filter = null){
        if($filter){
         $this->db->where($filter);   
        }
        $this->db->where('om.status','1');
        $this->db->select('c.unique_id as customer_unique_id,name,mobile,email,address,COUNT(om.id) as number_of_orders,SUM(final_total) as total_order');
        $this->db->join('order_masters om','om.customer_unique_id = c.unique_id','left');
        $this->db->group_by('c.id');
        return $this->db->get('customers c')->result_array();
    }
    public function getcustomerOrderList($filter = null){
        if($filter){
         $this->db->where($filter);   
        }
        $this->db->where('om.status','1');
        $this->db->select('om.id as order_id,name,mobile,email,address,subtotal,om.created_at');
        $this->db->join('order_masters om','om.customer_unique_id = c.unique_id');
        $this->db->group_by('om.id');
        return $this->db->get('customers c')->result_array();
    }

    public function getCustomerDetails($filter){
        $this->db->select('c.id as customer_id,c.*,ca.*,c.status as status');
        if($filter){
            $this->db->where($filter);
        }
        $this->db->join('customer_addresses ca','ca.customer_unique_id = c.unique_id','left');
        return $this->db->get('customers c')->row_array();
    }
    public function getCustomerListDetails($filter){
        $this->db->select('c.id as customer_id,c.*,ca.*,c.status as customer_status');
        if($filter){
            $this->db->where($filter);
        }
        $this->db->join('customer_addresses ca','ca.customer_unique_id = c.unique_id','left');
        $this->db->group_by('mobile');
        return $this->db->get('customers c')->result_array();
    }

    public function getPaidAmount($filter){
        $this->db->where($filter);
        $this->db->select('SUM(recieved_amount) as amount');
        return $this->db->get('payment_details')->row_array();
    }

    //get Customer details 
    public function getCustomerDetailsRows($postData){
        $this->_get_customer_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllCustomerDetails(){
        $this->db->from('customers');
        return $this->db->count_all_results();
    }
    public function countFilteredCustomerDetails($postData){
        $this->_get_customer_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_customer_details_datatables_query($postData){



        $this->db->select('c.id as customer_id,unique_id,c.name,c.mobile,c.email,c.status,register_type,c.created_at as created,ca.*');
        $this->db->join('customer_addresses ca','ca.customer_unique_id = c.unique_id','left outer');
        $this->db->group_by('c.mobile');
        $this->db->from('customers c');
        // Set orderable column fields
        $this->column_order = array('name','mobile','address','email','c.status','register_type','c.created_at');

        // Set searchable column fields
        $this->column_search = array('name','mobile','address','email','c.status','register_type','c.created_at');
        // Set default order
        $this->order = array('c.created_at' => 'desc');  


        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){



                    if($value['name'] == 'name' || $value['name'] == 'mobile' || $value['name'] == 'email' || $value['name'] == 'c.status' || $value['name'] == 'register_type'){

                            
                            $this->db->or_like($value['name'],$value['search']['value']);
                     }else if($value['name'] == 'address'){
                      
                            $this->db->or_like('street_address',$value['search']['value']);
                            $this->db->or_like('pincode',$value['search']['value']);
                            $this->db->or_like('city',$value['search']['value']);
                     }else if($value['name'] == 'c.created_at'){
                            $dates            = explode('-',$value['search']['value']);
                            $start_date       = date('md',strtotime($dates['0']));
                            $end_date         = date('md',strtotime($dates['1']));
                            $this->db->where("DATE_FORMAT(c.created_at,'%m%d') >=", $start_date);
                            $this->db->where("DATE_FORMAT(c.created_at,'%m%d') <=", $end_date);
                     }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){

            if($postData['search']['value']){
                
                if($i===0){
                        
                        $this->db->like($item, $postData['search']['value']);
                }else{
                    if($item == 'address'){
                         
                            $this->db->or_like('street_address',$postData['search']['value']);
                            $this->db->or_like('pincode',$postData['search']['value']);
                            $this->db->or_like('city',$postData['search']['value']);
                    }else{
                        
                        $this->db->or_like($item, $postData['search']['value']);
                    }                    
                }
               
            }
            $i++;
        }
         


        if(isset($postData['order'])){
            if($postData['order'][0]['column'] == '1' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5') {
                $this->db->order_by($this->column_order[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            }
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getEnquiryDetailsRows($postData){
        $this->_get_enquiry_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllEnquiryDetails(){
        $this->db->from('enquiry_master');
        return $this->db->count_all_results();
    }
    public function countFilteredEnquiryDetails($postData){
        $this->_get_enquiry_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_enquiry_details_datatables_query($postData){

        $this->db->select('e.*');
        $this->db->order_by('e.id','desc');
        $this->db->from('enquiries e');
        // Set orderable column fields
        $this->column_order = array(null,'first_name','last_name','mobile','email','comment','status','created_at');

        // Set searchable column fields
        $this->column_search = array('first_name','last_name','mobile','email','comment','status','created_at');
        // Set default order
        $this->order = array('created_at' => 'desc');  

        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    if($value['name'] == 'created_at'){
                            $dates            = explode('-',$value['search']['value']);
                            $start_date       = date('md',strtotime($dates['0']));
                            $end_date         = date('md',strtotime($dates['1']));
                            $this->db->where("DATE_FORMAT(created_at,'%m%d') >=", $start_date);
                            $this->db->where("DATE_FORMAT(created_at,'%m%d') <=", $end_date);
                     }else{
                            $this->db->or_like($value['name'],$value['search']['value']);
                     }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){
            if($postData['search']['value']){
                if($i===0){
                        $this->db->group_start();
                        $this->db->like($item, $postData['search']['value']);
                }else{
                    
                        $this->db->or_like($item, $postData['search']['value']);
                    
                }
                if(count($this->column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
         


        if(isset($postData['order'])){
            if($postData['order'][0]['column'] == '1' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5') {
                $this->db->order_by($this->column_order[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            }
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function deletePayment($filter){
        $this->db->where($filter);
        return $this->db->delete('payment_details');
    }

    public function getStockList(){

        $this->db->select("p.id as p_id,product_name,image,product_type,pav.packaging_size,s.*,s.id as stock_id");
        $this->db->join('stocks s','s.product_id = p.id','left');
        $this->db->join('product_attribute_values pav','s.product_id = pav.product_id','left');
        $this->db->where('product_type','1');
        $this->db->order_by("p.created_at desc");
        return $this->db->get('products p')->result_array();
    }
    public function getStockDetails($filter){
        $this->db->where($filter);
        $this->db->select("product_name,image,s.*,s.id as stock_id,p.id as product_id");
        $this->db->join('stocks s','s.product_id = p.id','left');
        return $this->db->get('products p')->row_array();
    }


    //blog list
    public function getBlogDetailsRows($postData){
        $this->_get_blog_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllBlogDetails(){
        $this->db->where('status','1');
        $this->db->from('blogs');
        return $this->db->count_all_results();
    }
    public function countFilteredBlogDetails($postData){
        $this->_get_blog_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_blog_details_datatables_query($postData){

        $this->db->select('id,title,post_by,date,image,description,status');
        $this->db->where('status','1');
        $this->db->from('blogs');
        // Set orderable column fields
        $this->column_order = array('id','title','post_by','date','description','status');

        // Set searchable column fields
        $this->column_search = array('title','post_by','date','description','status');
        // Set default order
        $this->order = array('id' => 'desc');  


        foreach ($_POST['columns'] as $key => $value) {

                

                if(!empty($value['search']['value'])){



                    if($value['name'] == 'title' || $value['name'] == 'post_by'  || $value['name'] == 'description' || $value['name'] == 'status'){
                            $this->db->or_like($value['name'],$value['search']['value']);
                     }else if($value['name'] == 'date'){
                            $dates            = explode('-',$value['search']['value']);
                            $start_date       = date('md',strtotime($dates['0']));
                            $end_date         = date('md',strtotime($dates['1']));
                            $this->db->where("DATE_FORMAT(date,'%m%d') >=", $start_date);
                            $this->db->where("DATE_FORMAT(date,'%m%d') <=", $end_date);
                     }
                }else if($value['name'] == 'status'){
                    if($value['search']['value'] == '0'){
                        $this->db->or_like($value['name'],$value['search']['value']);
                    }else if(!empty($value['search']['value'])){
                        $this->db->or_like($value['name'],$value['search']['value']);
                    }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){

            if($postData['search']['value']){
                
                if($i===0){
                        
                        $this->db->like($item, $postData['search']['value']);
                }else{
                    
                        $this->db->or_like($item, $postData['search']['value']);
                                      
                }
               
            }
            $i++;
        }
         


        if(isset($postData['order'])){
            if($postData['order'][0]['column'] == '1' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5') {
                $this->db->order_by($this->column_order[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            }
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getProductAttributeValues($filter){
        $this->db->select('p.*,pav.*,pav.id as attribute_id');
        $this->db->where($filter);
        $this->db->join('products p','p.id = pav.product_id');
        return $this->db->get('product_attribute_values pav')->result_array();
    }

    //product
    public function getStockDetailsRows($postData){
        $this->_get_stock_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllStockDetails(){
        $this->db->from('products');
        return $this->db->count_all_results();
    }
    public function countFilteredStockDetails($postData){
        $this->_get_stock_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_stock_details_datatables_query($postData){
        
        $this->db->select('p.*,stock_in,stock_out,(stock_in - stock_out) AS remaning_stock');
        $this->db->where('product_type','1');
        $this->db->join('stocks s','s.product_id = p.id','left');
        $this->db->order_by('p.id','desc');
        $this->db->from('products p');
        // Set orderable column fields
        $this->column_order = array(null,'image','product_name','packaging_size','stock_in','stock_out','remaning_stock');

        // Set searchable column fields
        $this->column_search = array('image','product_name','packaging_size','stock_in','stock_out','remaning_stock');
        // Set default order
        $this->order = array('p.created_at' => 'desc');  

        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    
                    if($value['name'] != ''){
                        if($value['name'] == 'created_at'){
                                $dates            = explode('-',$value['search']['value']);
                                $start_date       = date('md',strtotime($dates['0']));
                                $end_date         = date('md',strtotime($dates['1']));
                                $this->db->where("DATE_FORMAT(created_at,'%m%d') >=", $start_date);
                                $this->db->where("DATE_FORMAT(created_at,'%m%d') <=", $end_date);
                         }else{
                                $this->db->like($value['name'],$value['search']['value']);
                         }
                    }
                }
        }

         
         $i = 0;
        
        
        foreach($this->column_search as $item){

            if($postData['search']['value']){
                if($i===0){
                        $this->db->group_start();
                        $this->db->like($item, $postData['search']['value']);
                }else{
                        $this->db->or_like($item, $postData['search']['value']);  
                    
                }
                if(count($this->column_search) - 1 == $i){
                    $this->db->group_end();
                }
            }
            $i++;
        }
         


        if(isset($postData['order'])){
            if($postData['order'][0]['column'] == '1' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5') {
                $this->db->order_by($this->column_order[$postData['order'][0]['column']], $postData['order'][0]['dir']);
            }
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

}

?>