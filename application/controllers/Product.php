<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

     public function getProductList(){
        $filter = array('status'=>'1');
        $products = $this->AdminModel->getList('products',$filter);
        if($products){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = $products;
        }else{  
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'No products found';
        }
        echo json_encode($returnArr);
    }
    public function getProductDetails(){
        $id = $this->input->post('id');

        $filter = array('status'=>'1','p.id'=>$id);
        $products = $this->AdminModel->getProductData($filter);

        if($products){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = $products;
        }else{  
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'No products found';
        }
        echo json_encode($returnArr);
    }
    public function productList(){
        $data['section'] = $this->AdminModel->getList('home_sections');
        $c_filter = array('status'=>'1');
        $data['category'] = $this->AdminModel->getList('categories',$c_filter);
        $product = $this->AdminModel->getProductList('products');

        $i = 0;
        foreach($product as $row){
            $filter = array('product_id'=>$row['product_id'],
                            'section_id'=>'1'
                        );
            $new_products = $this->AdminModel->getDetails('home_section_products',$filter);

            $product[$i]['new_products'] = isset($new_products) ? '1' : '0';

            $filter = array('product_id'=>$row['product_id'],
                            'section_id'=>'2'
                        );
            $featured_products = $this->AdminModel->getDetails('home_section_products',$filter);

            $product[$i]['featured_products'] = isset($featured_products) ? '1' : '0';

            $filter = array('product_id'=>$row['product_id'],
                            'section_id'=>'3'
                        );
            $upcoming_products = $this->AdminModel->getDetails('home_section_products',$filter);

            $product[$i]['upcoming_products'] = isset($upcoming_products) ? '1' : '0';
            $i++;
        }

  
        $data['product']     = $product;
        $data['homesection'] = $this->AdminModel->getList('home_sections');
        $this->load->view('product/products',$data);
    }
    public function getProductListDetails(){
        $data = $row = array();
        
        // Fetch member's records
        $memData = $this->AdminModel->getProductDetailsRows($_POST);
         // echo $this->db->last_query();exit;
        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;
                                       
                                    
            $action = '<td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="'.base_url().'Product/editProduct/'.$member->product_id.'" id="'.$member->product_id.'"><i class="icon-file-pdf"></i> Edit</a></li>
                                    <li><a  id="'.$member->product_id.'" class="delete" data-table="'.$hash = $this->encryption->encrypt('products').'"><i class="icon-file-excel"></i> Delete</a></li>
                                    <li><a href="'.base_url().'ImageController/gallery/'.$member->product_id.'/3"><i class="icon-file-excel"></i> Add Images</a></li>
                                </ul>
                            </li>
                        </ul>
                        </td>';

        $image = '<img src="'.base_url().$member->image.'" width="50px" height="50px">';

        $filter = array('product_id'=>$member->product_id,
                        'section_id'=>'1'
                        );
        $new_products = $this->AdminModel->getDetails('home_section_products',$filter);

        $new_products_status = isset($new_products) ? '<button class="btn btn-success btn-sm">Active</button>' : '<button class="btn btn-danger btn-sm">Inactive</button>';

        $filter = array('product_id'=>$member->product_id,
                        'section_id'=>'2'
                    );
        $featured_products = $this->AdminModel->getDetails('home_section_products',$filter);

        $featured_products_status = isset($featured_products) ? '<button class="btn btn-success btn-sm">Active</button>' : '<button class="btn btn-danger btn-sm">Inactive</button>';

        $status = $member->status == '1' ? '<button class="btn btn-success btn-sm">Active</button>' : '<button class="btn btn-danger btn-sm">Inactive</button>';

        $product_type = $member->product_type == '1' ? 'simple' : 'configurable';


            $data[] = array($member->product_id,
                            $i,
                            $action,
                            $image,
                            $member->product_name,
                            $product_type, 
                            $member->packaging_size,
                            $member->unit_price,
                            $member->sell_price,
                            $member->category_name,
                            $new_products_status,
                            $featured_products_status,
                            $status,
                            date('d-m-Y h:i A',strtotime($member->created_at))
                        );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AdminModel->countAllProductDetails(),
            "recordsFiltered" => $this->AdminModel->countFilteredProductDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }
    public function addProduct(){

        $this->form_validation->set_rules('product_name','Product Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('unit_price','Unit Price','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('sell_price','Sell Price','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('short_description','Short Description','');
        $this->form_validation->set_rules('long_description','Long Description','');
        $this->form_validation->set_rules('file','','callback_file_check');
        $this->form_validation->set_rules('category_id','Category','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('discount','Discount','trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('stock','Stock','trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('product_type','Product Type','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('active','Active','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');

        if($this->form_validation->run()){
            $filter = array('product_name'=>$this->input->post('product_name'));

            $checkMenu = $this->AdminModel->getDetails('products',$filter);
            if($checkMenu){
                    $returnArr['errCode']               = 3;
                    $returnArr['message']['product_name']      = '<p class="error">Products Already Exists</p>';
            }else{  
                     
                    if(isset($_FILES)){
                        $upload = upload_image($_FILES,'file');

                        if($upload['errCode'] == -1){
                            $image = $upload['image'];
                        }else{
                            $returnArr['errCode']      = 3;
                            $returnArr['message']['image']      = $upload['image'];
                            echo json_encode($returnArr);exit;
                        }
                    }else{
                        $image = '';
                    }

                    $data = array('product_name'=>$this->input->post('product_name'),
                                  'sku'         =>time(),
                                  'unit_price'  =>$this->input->post('unit_price'),
                                  'sell_price'  =>$this->input->post('sell_price'),
                                  'short_description'=>$this->input->post('short_description'),
                                  'long_description' =>$this->input->post('long_description'),
                                  'category_id' =>$this->input->post('category_id'),
                                  'discount'    =>$this->input->post('discount'),
                                  'product_type'=>$this->input->post('product_type'),
                                  'image'       =>$image,
                                  'status'      =>$this->input->post('status')
                              );

                    $id = $this->AdminModel->insert('products',$data);

                    if($id){

                        $stock_data = array('product_id'=>$id,
                                            'stock_in'  =>$this->input->post('stock'),
                                            'stock_out' =>0,
                                            'remaning_stock'=>$this->input->post('stock')
                                        );
                        $this->AdminModel->insert('stocks',$stock_data);

                        $returnArr['errCode']     = -1;
                        $returnArr['product_id']  = $id;
                        $returnArr['product_type'] = $this->input->post('product_type');
                        $returnArr['message']  = 'Success';
                    }else{
                        $returnArr['errCode']     = 2;
                        $returnArr['message']  = 'Please try again';
                    }
            }
        }else{
            $returnArr['errCode'] = 3;
            $returnArr['message']['file'] = form_error('file');
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
            
        }
        echo json_encode($returnArr);
    }
    public function imageUpload(){
        if(isset($_FILES)){
            $upload = upload_image($_FILES,'upload');

            if($upload['errCode'] == -1){
                $url = base_url().$upload['image'];
            }else{
                $url = $upload['image'];
            }
        }else{
            $url = '';
        }

        echo json_encode(array('url'=>$url));
    }
    public function editProduct(){
            $c_filter = array('status'=>'1');
            $data['category'] = $this->AdminModel->getList('categories',$c_filter);

            $filter = array('id'=>$this->uri->segment(3));

            $data['product'] = $this->AdminModel->getDetails('products',$filter);

            $s_filter = array('product_id'=>$this->uri->segment(3));
            $data['stock'] = $this->AdminModel->getDetails('stocks',$s_filter);


            $this->load->view('product/editProduct',$data);

    }
    public function updateProduct(){


       $this->form_validation->set_rules('product_name','Product Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('unit_price','Unit Price','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('sell_price','Sell Price','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('short_description','Short Description','');
        $this->form_validation->set_rules('long_description','Long Description','');
        $this->form_validation->set_rules('category_id','Category','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required');
        $this->form_validation->set_rules('product_type','Product Type','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('active','Active','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('discount','Discount','trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('stock','Stock','trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->uri->segment(3),
                            'sku'=>$this->input->post('sku'));

            
            $product_data = $this->AdminModel->getDetails('products',$filter);
           // echo $this->db->last_query();exit;
            $price_data   = array('product_id'=>$this->uri->segment(3),
                                  'price'     =>$this->input->post('unit_price')
                                 );
            
            $this->db->insert('product_price_backup',$price_data);

            if($product_data){
                    $returnArr['errCode']               = 3;
                    $returnArr['message']['product_name']      = '<p class="error">Product Already Exists</p>';
            }else{
                if(isset($_FILES) && !empty($_FILES)){
                    $upload = upload_image($_FILES,'image');

                    if($upload['errCode'] == -1){
                        $image = $upload['image'];
                    }else{
                        $returnArr['errCode']      = 3;
                        $returnArr['message']['image']      = $upload['image'];
                        echo json_encode($returnArr);exit;
                    }
                }else{
                    $image = $this->input->post('old_image');
                }

                $filter     = array('id'=>$this->uri->segment(3));
                $data = array('product_name'=>$this->input->post('product_name'),
                                  'unit_price'  =>$this->input->post('unit_price'),
                                  'sell_price'  =>$this->input->post('sell_price'),
                                  'short_description'=>$this->input->post('short_description'),
                                  'long_description'=>$this->input->post('long_description'),
                                  'category_id' =>$this->input->post('category_id'),
                                  'discount'    =>$this->input->post('discount'),
                                  'product_type'=>$this->input->post('product_type'),
                                  'image'       =>$image
                              );


          
                $updateMenu = $this->AdminModel->update('products',$filter,$data);
              //  echo $this->db->last_query();exit;
                if($updateMenu){

                    $s_filter = array('product_id'=>$this->uri->segment(3));
                    $stock_details = $this->AdminModel->getDetails('stocks',$s_filter);

                    $stock = $this->input->post('stock');
                    $stock = $stock - $stock_details['remaning_stock'];
                    $stock_in = $stock_details['stock_in'];

                    $stock_data = array('stock_in'=>$stock_in + $stock,
                                        'remaning_stock'=>$stock_in + $stock
                                        );
                    $this->AdminModel->update('stocks',$s_filter,$stock_data);

                    $returnArr['errCode']     = -1;
                    $returnArr['product_id']  = $this->uri->segment(3);
                    $returnArr['product_type']= $this->input->post('product_type');
                    $returnArr['message']  = 'Product Updated Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']  = 'Please try again';
                }
            }
        }else{
            $returnArr['errCode'] = 3;

            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }


        }
        echo json_encode($returnArr);
    }
    public function addSectionProductsStatus(){
        $ids = $this->input->post('ids');    
        $section = $this->input->post('section');
        


        $filter = array('id'=>$section);
        $section_details = $this->AdminModel->getDetails('home_sections',$filter);

        
        $section_name = str_replace('_',' ',strtolower($section_details['title']));
        

        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['product_id'] =$row;
            $data[$i]['section_id'] = $section;
            
            $product_data[$i]['id'] = $row;
            $product_data[$i][$section_name] = '1';
 
            $i++;


        }
            


        $update = $this->AdminModel->insertBatch('home_section_products',$data);

        //$this->AdminModel->updateBatch('products',$product_data,'id');

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function activateProductsStatus(){
        $ids = $this->input->post('ids');    
        

        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['id'] =$row;
            $data[$i]['status'] = '1';
            $i++;
        }
            
        $update = $this->AdminModel->updateBatch('products',$data,'id');

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function deactivateProductsStatus(){
        $ids = $this->input->post('ids');    
        echo "<pre>";
        print_r($ids);exit;

        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['id'] =$row;
            $data[$i]['status'] = '0';
            $i++;
        }
            
        $update = $this->AdminModel->updateBatch('products',$data,'id');

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function removeSectionProductsStatus(){
        $ids = $this->input->post('ids');    
        $section = $this->input->post('section');
  
        $data = [];
        $i = 0;
        foreach($ids as $row){
            $filter = array('product_id'=>$row,
                            'section_id'=>$section);
            $delete = $this->AdminModel->delete('home_section_products',$filter);
        }
        

        if($delete){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function outOfStock(){
        $ids = $this->input->post('ids');    
        
  
        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['id'] =$row;
            $data[$i]['out_of_stock'] = '1';
            $i++;
        }
            
        $update = $this->AdminModel->updateBatch('products',$data,'id');
        
        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }
    public function stockIn(){
        $ids = $this->input->post('ids');    
        
  
        $data = [];
        $i = 0;
        foreach($ids as $row){
            $data[$i]['id'] =$row;
            $data[$i]['out_of_stock'] = '0';
            $i++;
        }
            
        $update = $this->AdminModel->updateBatch('products',$data,'id');
        
        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }

        echo json_encode($returnArr);
    }

    public function importProductPriceForm(){
        $this->load->view('product/importProductPriceForm');
    }

    public function importPriceData(){
        $this->form_validation->set_rules('file','','callback_file_check');
        if($this->form_validation->run()){

                $new_image_name = time().str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['file']['name']);

                $config['upload_path']      = 'uploads/';
                $config['allowed_types']    = 'csv';
                $config['file_name']        = $new_image_name;
                $config['max_size']         = '0';
                $config['max_width']        = '0';
                $config['max_height']       = '0';
                $config['$min_width']       = '0';
                $config['min_height']       = '0';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $upload = $this->upload->do_upload('file');
                if(!$upload)
                {
                    $data['error'] = true;
                    $data['imageError'] =  $this->upload->display_errors();
                    
                }else{
                    $csvData = $this->csvreader->parse_csv($_FILES['file']['tmp_name']);


                    if(!empty($csvData)){
                        $insertCount = $updateCount = $rowCount = $notAddCount = 0;

                        foreach($csvData as $row){
                            
                            $rowCount++;

                            $filter = array('product_name'=>$row['product_name']);
                            $product = $this->AdminModel->getDetails('products',$filter);

                            if($product){
                                $filter = array('id'=>$row['id']);
                                $data   = array('sell_price'=>$row['sell_price'],
                                                'unit_price'=>$row['unit_price'],
                                                'discount'  =>$row['discount'],
                                                'sku'       =>$row['sku'],
                                                'packaging_size'=>$row['packaging_size'],
                                                'seller_name'=>$row['seller_name'],
                                                'category_id'=>$row['category_id']
                                               );
                                $this->AdminModel->update('products',$filter,$data);
                                $updateCount++;
                            }else{
                                $data   = array('id'          =>$row['id'],
                                                'product_name'=>$row['product_name'],
                                                'unit_price'  =>$row['unit_price'],
                                                'sell_price'  =>$row['sell_price'],
                                                'discount'    =>$row['discount'],
                                                'sku'         =>$row['sku'],
                                                'packaging_size'=>$row['packaging_size'],
                                                'seller_name' =>$row['seller_name'],
                                                'category_id' =>$row['category_id'],
                                                'status'      =>'1'
                                                );
                                $this->AdminModel->insert('products',$data);
                                $insertCount++;
                            }

                        }

                        $notAddCount = $rowCount - $insertCount;

                        $data['notAddCount'] = $notAddCount;
                        $data['rowCount']    = $rowCount;
                        $data['updateCount'] = $updateCount;
                        $data['insertCount'] = $insertCount;
                        $data['message']     = 'Import Successfully';

                        $this->load->view('product/importProductPriceForm',$data);
                    }               
                }

        }else{
            $this->load->view('product/importProductPriceForm');
        }

    }
    public function file_check($str){
        $allowed_mime_type_arr = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain','application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png','image/jpg');
        $mime = get_mime_by_extension($_FILES['file']['name']);
        if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only pdf/gif/jpg/png/csv file.');
                return false;
            }
        }else{

            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }
     public function attributeValues(){
        
        $id = $this->uri->segment(3);
        $data['product_id'] = $id; 

        $filter = array('parent_id'=>$id);
        $data['attributes'] = $this->AdminModel->getProductAttributeValues($filter);

        // echo "<pre>";
        // print_r($data);exit;
        
        $this->load->view('product/attribute_values_form',$data);
    } 
    public function getAttributeValues(){
        $attribute_id = $this->input->post('id');

        $filter = array('id'=>$attribute_id);
        $values = $this->AdminModel->getList('product_attribute',$filter);

        $data = explode(',',$values);

        if(!empty($data)){
            $error = false;
            $message = $data;
        }else{
            $error = true;
            $message = '';
        }

        echo json_encode(array('error'=>$error,'message'=>$message));
    }

    public function addConfigurableProducts(){

         $this->form_validation->set_rules('id','Id','trim|xss_clean|max_length[255]');
          if($this->form_validation->run()){
            $id = $this->input->post('id');

            $filter = array('id'=>$id);
            $product = $this->AdminModel->getDetails('products',$filter);
           
            $product_data = array();
            $i = 1;
            if(!empty($_POST['packaging_size'][0])){
                foreach($this->input->post('packaging_size') as $key => $value){

                    $product_data = array('product_name'=>$product['product_name'],
                                            'sku'         =>$product['sku'].'_'.$i,
                                            'moq'         =>$_POST['moq'][$key],
                                            'packaging_size'=>$_POST['packaging_size'][$key],
                                            'image'       =>$product['image'],
                                            'unit_price'  =>$_POST['mrp'][$key],
                                            'sell_price'  =>$_POST['sell_price'][$key],
                                            'discount'    =>$_POST['discount'][$key],
                                            'seller_name' =>$product['seller_name'],
                                            'product_type'=>'1',
                                            'category_id' =>$product['category_id'],
                                            'sub_category'=>$product['sub_category'],
                                            'status'      =>'1',
                                            'active'      =>'2',
                                            'long_description'=>$product['long_description'],
                                            'short_description'=>$product['short_description']
                                        );

                    
                    $product_id = $_POST['product_id'][$key]; 

                    if($_POST['product_id'][$key] != 'new'){
                        $filter = array('id'=>$_POST['product_id'][$key]);
                        $this->AdminModel->update('products',$filter,$product_data); 
                    }else{
                        $product_id = $this->AdminModel->insert('products',$product_data);
                    }


                    if($_POST['attribute_id'][$key] != 'new'){
                        
                        $a_filter = array('parent_id'=>$this->input->post('id'),
                                        'product_id'=>$_POST['product_id'][$key]
                                            );
                        $attribute_data = array('packaging_size'=>$_POST['packaging_size'][$key]
                                            );

                        $this->AdminModel->update("product_attribute_values",$a_filter,$attribute_data);
                    }else{
                        
                        $attribute_data = array('parent_id'=>$this->input->post('id'),
                                                'product_id'=>$product_id,
                                                'packaging_size'=>$_POST['packaging_size'][$key]
                                            );

                        $this->AdminModel->insert("product_attribute_values",$attribute_data);
                    }

                    

                    $stock_data = array("product_id"=>$this->input->post('id'),
                                        "stock_in"  =>$_POST['stock'][$key],
                                        "stock_out" =>0,
                                        "remaning_stock"=>$_POST['stock'][$key]
                                        );
                    $this->AdminModel->insert("stocks",$stock_data);

                    $i++;
                }


                    $returnArr['errCode'] = -1;
                    $returnArr['message'] = 'Add Successfully';
                
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please add some variants';
            }

            
            
          }else{
            $returnArr['errCode'] = 3;

            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
          }
          echo json_encode($returnArr);
    }

    public function affiliateProductList(){
        $data['categories'] = $this->AdminModel->getList('affiliate_categories');
        $data['products'] = $this->AdminModel->getList('affiliate_products');

        $this->load->view('product/affiliate_productslist',$data);   
    }
    public function addAffiliateProduct(){

        $this->form_validation->set_rules('product_name','Product Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('category_id','Category','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('link','Link','required|trim|xss_clean');
        $this->form_validation->set_rules('description','Description','');
        $this->form_validation->set_rules('file','','callback_file_check');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');

        if($this->form_validation->run()){
            $filter = array('product_name'=>$this->input->post('product_name'));

            $checkMenu = $this->AdminModel->getDetails('affiliate_products',$filter);
            if($checkMenu){
                    $returnArr['errCode']               = 3;
                    $returnArr['message']['product_name']      = '<p class="error">Products Already Exists</p>';
            }else{  
                     
                    if(isset($_FILES)){
                        $upload = upload_image($_FILES,'file');

                        if($upload['errCode'] == -1){
                            $image = $upload['image'];
                        }else{
                            $returnArr['errCode']      = 3;
                            $returnArr['message']['image']      = $upload['image'];
                            echo json_encode($returnArr);exit;
                        }
                    }else{
                        $image = '';
                    }

                    $data = array('product_name'=>$this->input->post('product_name'),
                                  'image'       =>$image,
                                  'category_id' =>$this->input->post('category_id'),
                                  'link'        =>$this->input->post('link'),
                                  'description' =>$this->input->post('description'),
                                  'status'      =>$this->input->post('status')
                              );

                    $id = $this->AdminModel->insert('affiliate_products',$data);

                    if($id){

                        $returnArr['errCode']     = -1;
                        $returnArr['product_id']     = $id;
                        $returnArr['message']  = 'Success';
                    }else{
                        $returnArr['errCode']     = 2;
                        $returnArr['product_id']     = $id;
                        $returnArr['message']  = 'Please try again';
                    }
            }
        }else{
            $returnArr['errCode'] = 3;
            $returnArr['product_id']     = '';
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
            $returnArr['message']['file'] = form_error('file');
        }
        
        echo json_encode($returnArr);
    }
    public function editAffiliateProduct(){
            $c_filter = array('status'=>'1');
            $data['categories'] = $this->AdminModel->getList('affiliate_categories',$c_filter);

            $filter = array('id'=>$this->uri->segment(3));

            $data['product'] = $this->AdminModel->getDetails('affiliate_products',$filter);

            $s_filter = array('product_id'=>$this->uri->segment(3));
            $data['stock'] = $this->AdminModel->getDetails('stocks',$s_filter);


            $this->load->view('product/editAffiliateProduct',$data);

    }
    public function updateAffiliateProduct(){

        
        $this->form_validation->set_rules('product_name','Product Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('category_id','Category','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('link','Link','required|trim|xss_clean');
        $this->form_validation->set_rules('description','Description','');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');

        if($this->form_validation->run()){
            $filter = array('product_name'=>$this->input->post('product_name'),
                            'id !='          =>$this->uri->segment(3));

            $checkMenu = $this->AdminModel->getDetails('affiliate_products',$filter);
            if($checkMenu){
                    $returnArr['errCode']               = 3;
                    $returnArr['message']['product_name']      = '<p class="error">Products Already Exists</p>';
            }else{  
             
                     
                    if(isset($_FILES) && !empty($_FILES['file']['name'])){
                        $upload = upload_image($_FILES,'file');

                        if($upload['errCode'] == -1){
                            $image = $upload['image'];
                        }else{
                            $returnArr['errCode']      = 3;
                            $returnArr['message']['image']      = $upload['image'];
                            echo json_encode($returnArr);exit;
                        }
                    }else{
                        $image = $this->input->post('old_image');
                    }

                    $filter = array('id'=>$this->uri->segment(3));
                    $data = array('product_name'=>$this->input->post('product_name'),
                                  'image'       =>$image,
                                  'category_id' =>$this->input->post('category_id'),
                                  'link'        =>$this->input->post('link'),
                                  'description' =>$this->input->post('description'),
                                  'status'      =>$this->input->post('status')
                              );

                    $id = $this->AdminModel->update('affiliate_products',$filter,$data);

                    if($id){

                        $returnArr['errCode']     = -1;
                        $returnArr['message']  = 'Success';
                    }else{
                        $returnArr['errCode']     = 2;
                        $returnArr['message']  = 'Please try again';
                    }
            }
        }else{
            print_r(validation_errors());exit;
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
            $returnArr['message']['file'] = form_error('file');
        }
        
        echo json_encode($returnArr);
    }
    public function productReports(){
        $product = $this->AdminModel->getList('products');

        $i = 0;
        foreach($product as $row){
            $i++;
            $filter = array('product_id'=>$row['id'],'status'=>'1');
            $order      = $this->AdminModel->getOrderProductDetails($filter);

            $report[$i]['product_name']     = $row['product_name'];
            $report[$i]['image']            = $row['image'];
            $report[$i]['unit_price']       = $row['unit_price'];
            $report[$i]['sell_price']       = $row['sell_price'];
            $report[$i]['total_sell_qty']   = $order['total_sell_qty'];
            $report[$i]['total_sell_price']   = $order['total_sell_price'];
        }


        $data['reports'] = $report;
        $this->load->view('product/product_reports',$data);
    }

    

}
