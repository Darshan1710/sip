<?php

class PurchaseModel extends CI_Model {

	public function getList($table_name = NULL){
        $this->db->select('pd.id as pur_id,pd.*,s.name,s.id as supplier_id, pr.product_name');
        $this->db->join('purchases p','p.id = pd.purchase_id');
        $this->db->join('suppliers s','s.id = p.supplier_id');
        $this->db->join('products pr','pr.id = pd.product_id');
        return $this->db->get( $table_name . ' pd')->result_array();
    }
    public function getPurchaseDetails($table_name = NULL, $id){
    	$this->db->select('pd.id as pur_id,pd.*,s.name,pr.product_name,pr.sell_price,p.total,remaning_stock');
        $this->db->join('purchases p','p.id = pd.purchase_id');
        $this->db->join('suppliers s','s.id = p.supplier_id');
        $this->db->join('products pr','pr.id = pd.product_id');
        $this->db->join('stocks st','st.product_id = pr.id');
        $this->db->where('p.id',$id);
        return $this->db->get( $table_name . ' pd')->result_array();
    }
    public function getProductList(){
        $this->db->select('p.id as product_id,p.product_name');
        $this->db->where('p.status','1');
        return $this->db->get('products p')->result_array();
    }

    public function getSupplierList(){
        $this->db->select('s.id as supplier_id,s.name');
        $this->db->where('s.status','1');
        return $this->db->get('suppliers s')->result_array();
    }

    public function ckeckExistingProduct($table_name,$productId){
        $this->db->select('id as stock_id,stock_in');
        $this->db->where('product_id',$productId);
        return $this->db->get($table_name)->result_array();
    }

    public function insertStock($table_name,$data){
        $this->db->insert($table_name,$data);
        return $this->db->insert_id();
    }

    public function updateStock($table_name,$stock,$product_id){
        $sql = "UPDATE ". $table_name ." SET stock_in=stock_in+". $stock ." WHERE product_id=". $product_id;
        return $this->db->query($sql);
    }
    public function addStockOut($table_name,$stock,$product_id){
        $sql = "UPDATE ". $table_name ." SET stock_out=stock_out+". $stock ." WHERE product_id=". $product_id;
        return $this->db->query($sql);
    }
    public function subtractStockOut($table_name,$stock,$product_id){
        $sql = "UPDATE ". $table_name ." SET stock_out=stock_out-". $stock ." WHERE product_id=". $product_id;
        return $this->db->query($sql);
    }
    public function subtractStockIn($table_name,$stock,$product_id){
        $sql = "UPDATE ". $table_name ." SET stock_in=stock_in-". $stock ." WHERE product_id=". $product_id;
        return $this->db->query($sql);
    }

    public function getStockDetails(){
        $this->db->select('s.stock_in, s.stock_out ,p.product_name,p.image');
        $this->db->join('products p','s.product_id = p.id');
        return $this->db->get('stock s')->result_array();
    }
    public function getStockInDetails($filter){
        $this->db->where($filter);
        $this->db->where('status','1');
        $this->db->select('SUM(qty) as stock_in,created_at as purchase_created_at');
        return $this->db->get('purchase_details ')->row_array();
    }
    public function getStockOutDetails($filter){
        $this->db->where($filter);
        $this->db->where('status','1');
        $this->db->where('product_status','1');
        $this->db->or_where('product_status','3');
        $this->db->select('SUM(qty) as stock_out,created_at as order_created_at');
        return $this->db->get('order_details ')->row_array();
    }
    //order
    public function getStockDetailsRows($postData){
        $this->_get_stock_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllStockDetails(){
        $this->db->from('stock');
        return $this->db->count_all_results();
    }
    public function countFilteredStockDetails($postData){
        $this->_get_stock_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_stock_details_datatables_query($postData){
        
        $this->db->select('p.*');
        // $this->db->where('id','1');
        $this->db->order_by('p.id','asc');
        $this->db->from('products p');
        // Set orderable column fields
        $this->column_order = array(null,'image','product_name');

        // Set searchable column fields
        $this->column_search = array('image','product_name');
        // Set default order
        $this->order = array('id' => 'asc');  

        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    if($value['name'] == 'product_name'){
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
            if($postData['order'][0]['column'] == '0' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5' || $postData['order'][0]['column'] == '5') {
                
            }
        }else if(isset($this->order)){
            $order = $this->order;

            // $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    //order
    public function getPurchaseReportDetailsRows($postData){
        $this->_get_purchase_report_details_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllPurchaseDetails(){
        $this->db->from('purchase');
        return $this->db->count_all_results();
    }
    public function countFilteredPurchaseDetails($postData){
        $this->_get_purchase_report_details_datatables_query($postData);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_purchase_report_details_datatables_query($postData){
        
        $this->db->select('p.*,SUM(pd.qty) as qty');
        $this->db->join('products p','p.id = pd.product_id');
        $this->db->order_by('p.id','asc');
        $this->db->from('purchase_details pd');
        $this->db->group_by('p.id');
        // Set orderable column fields
        $this->column_order = array(null,'image','product_name','');

        // Set searchable column fields
        $this->column_search = array('image','product_name');
        // Set default order
        $this->order = array('id' => 'asc');  

        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    if($value['name'] == 'product_name'){
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
            if($postData['order'][0]['column'] == '0' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5' || $postData['order'][0]['column'] == '5') {
                
            }
        }else if(isset($this->order)){
            $order = $this->order;

            // $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getPurchaseProductReportDetailsRows($postData,$id){
        $this->_get_purchase_product_report_details_datatables_query($postData,$id);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function countAllPurchaseProductDetails(){
        $this->db->from('purchase_details');
        return $this->db->count_all_results();
    }
    public function countFilteredPurchaseProductDetails($postData,$id){
        $this->_get_purchase_product_report_details_datatables_query($postData,$id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function _get_purchase_product_report_details_datatables_query($postData,$id){
        

        $this->db->order_by('pd.id','asc');
        $this->db->where('product_id',$id);
        $this->db->from('purchase_details pd');
        // Set orderable column fields
        $this->column_order = array(null,'rate','qty','price','created_at');

        // Set searchable column fields
        $this->column_search = array('rate','qty','price','created_at');
        // Set default order
        $this->order = array('id' => 'asc');  

        foreach ($_POST['columns'] as $key => $value) {
                if(!empty($value['search']['value'])){

                    if($value['name'] == 'created_at'){
                            $dates            = explode('-',$value['search']['value']);
                            $start_date       = date('Y-m-d',strtotime($dates['0']));
                            $end_date         = date('Y-m-d',strtotime($dates['1']));
                            $this->db->where("DATE(created_at) >=", $start_date);
                            $this->db->where("DATE(created_at) <=", $end_date);
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
            if($postData['order'][0]['column'] == '0' || $postData['order'][0]['column'] == '2' || $postData['order'][0]['column'] == '3' || $postData['order'][0]['column'] == '4' || $postData['order'][0]['column'] == '5' || $postData['order'][0]['column'] == '5') {
                
            }
        }else if(isset($this->order)){
            $order = $this->order;

            // $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function getPurchaseMasterDetails(){
        $this->db->select('p.*,s.*,p.id as purchase_id');
        $this->db->where('p.status','1');
        $this->db->join('suppliers s','s.id = p.supplier_id');
        $this->db->order_by('p.id','desc');
        return $this->db->get('purchases p')->result_array();
    }
}