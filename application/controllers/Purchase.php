<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function purchaseList(){
        $data['purchase'] = $this->PurchaseModel->getPurchaseMasterDetails();

        $this->load->view('purchase/purchase_list',$data);
    }

    public function purchaseReports(){
        $this->load->view('purchase/purchase_reports');
    }

    public function getPurchaseReportsList(){
        $data = $row = array();
        

        // Fetch member's records
        $memData = $this->PurchaseModel->getPurchaseReportDetailsRows($_POST);



        $i = $_POST['start'];
        foreach($memData as $member){


            if($member->product_name){
                $i++;


                $image = '<img src="'.$member->image.'" width="50px" height="50px">';

                $qty   = '<a href="'.base_url().'Purchase/purchaseProductReports/'.$member->id.'">'.$member->qty.'</a>';
                $data[] = array(
                                $i,
                                $image, 
                                $member->product_name,
                                $qty
                            );
            }
            
        }




        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->PurchaseModel->countAllStockDetails(),
            "recordsFiltered" => $this->PurchaseModel->countFilteredStockDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }

    public function purchaseProductReports(){
        $data['id'] = $this->uri->segment(3);
        $filter     = array('id'=>$data['id']);
        $data['products'] = $this->AdminModel->getDetails('products');
        $this->load->view('purchase/purchase_product_reports',$data);
    }

    public function getPurchaseProductReportsList(){
        $data = $row = array();
        
        $id = $this->uri->segment(3);
        // Fetch member's records
        $memData = $this->PurchaseModel->getPurchaseProductReportDetailsRows($_POST,$id);



        $i = $_POST['start'];
        foreach($memData as $member){


                $i++;


                $data[] = array(
                                $i,
                                $member->rate, 
                                $member->qty,
                                $member->subtotal,
                                date('Y-m-d h:i:s',strtotime($member->created_at))
                            );

            
        }




        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->PurchaseModel->countAllPurchaseProductDetails(),
            "recordsFiltered" => $this->PurchaseModel->countFilteredPurchaseProductDetails($_POST,$id),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }

    public function purchaseForm(){
        $data['suppliers'] = $this->PurchaseModel->getSupplierList();
        $filter = array('status'=>'1');
        $data['products'] = $this->AdminModel->getList('products',$filter);
        $this->load->view('purchase/purchase_form',$data);
    }

    public function addPurchase(){
        $returnData['flag'] = 0;
        if(empty($this->input->post('supplier_id'))){
            $returnData['msg'] = 'Select the Supplier';
            echo json_encode($returnData);exit;
        }

        $total = 0;
        if(!empty($_POST['product_id'][0])){
            foreach ($this->input->post('product_id') as $key => $value) {

                $total += $_POST['rate'][$key] * $_POST['qty'][$key];

                if($_POST['qty'][$key] == 0){
                    $returnData['msg'] = 'Quantity Should not be 0';
                                echo json_encode($returnData);exit; 
                }                 
            }

            $data = ['supplier_id' => $_POST['supplier_id'],
                     'total'       => $total ];    
            $this->db->trans_start();
            $purAddId = $this->AdminModel->insert('purchases',$data); 
            
            foreach($this->input->post('product_id') as $key => $value){
                if(!empty($_POST['product_id'][$key])){
                    $purchase_details[] = [
                        'purchase_id'    => $purAddId,
                        'product_id'     => $_POST['product_id'][$key],
                        'rate'           => $_POST['rate'][$key],
                        'qty'            => $_POST['qty'][$key],
                        'subtotal'       => $_POST['total'][$key],
                        'created_at'   =>date('Y-m-d h:i:s')
                     ];
                }

            }

            $add = $this->AdminModel->insertBatch('purchases_details',$purchase_details);
            
            foreach($this->input->post('product_id') as $key => $val){
                if(!empty($_POST['product_id'][$key])){
                    $stock_details = [
                        'product_id'     => $_POST['product_id'][$key],
                        'stock_in'       => $_POST['qty'][$key],
                        'remaining_stock'=> $_POST['qty'][$key]
                    ];
                } 
                $prodId = $this->PurchaseModel->ckeckExistingProduct('stocks',$stock_details['product_id']);
                if(!empty($prodId)){
                    $this->PurchaseModel->updateStock('stocks',$stock_details['stock_in'],$stock_details['product_id']);
                }else{
                    $this->PurchaseModel->insertStock('stocks',$stock_details);
                }
            }
            $this->db->trans_complete();
            if($add){
                $returnData['msg'] = 'Purchase added successfully.';
                $returnData['flag'] = 1;
            }else{
                $returnData['msg'] = 'Failed to store Purchase data. Try again later.';
            }
        }else{
            $returnData['msg'] = 'Please Select Atleast one product';
                                echo json_encode($returnData);exit;
        }
        echo json_encode($returnData);exit;
    }

    public function editPurchase(){
        $purchase_id = $this->uri->segment(3);

        $data['suppliers'] = $this->PurchaseModel->getSupplierList();
        
        $filter   = array('id'=>$purchase_id);
        $data['purchase'] = $this->AdminModel->getDetails('purchases',$filter);

        $filter_2   = array('purchase_id'=>$purchase_id);
        $data['purchase_details'] = $this->PurchaseModel->getPurchaseDetails('purchases_details',$purchase_id);

       // echo $this->db->last_query();exit;
        $data['products'] = $this->AdminModel->getList('products');
        $this->load->view('purchase/edit_purchase',$data);
    }
    public function updatePurchase(){
        $this->form_validation->set_rules('purchase_id','Purchase Id','required|trim|xss_clean|max_length[255]');

        if($this->form_validation->run()){


            $purchase_id = $this->input->post('purchase_id');
            $total = 0;
            $add = false;
            if(!empty($_POST['product_name'][0])){

                $o_filter = array('purchase_id'=>$purchase_id,'status'=>'1');   
                $purchase_backup_data = $this->AdminModel->getList('purchases_details',$o_filter);

                $this->db->trans_start();

                foreach($this->input->post('product_name') as $key => $value){
                    
                    if(!empty($_POST['product_name'][$key])){

                        foreach($purchase_backup_data as $obp){

                           $this->PurchaseModel->subtractStockIn('stocks',$obp['qty'],$obp['product_id']);                 
                        }

                        $p_filter = array('id'=>$_POST['product_name'][$key]);
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        if($_POST['qty'][$key] == 0){
                            $returnArr['errCode'] = 2;
                            $returnArr['message'] = $p_details['product_name'].' Qty should not be 0';
                            echo json_encode($returnArr);exit;
                        }



                        //new data
                        $purchase_details[] = array('purchase_id'   =>$purchase_id,
                                                     'product_id'   =>$_POST['product_name'][$key],
                                                     'rate'         =>$_POST['rate'][$key],
                                                     'qty'          =>$_POST['qty'][$key],
                                                     'subtotal'     =>$_POST['rate'][$key] * $_POST['qty'][$key],
                                                      'status'      =>'1');

                        $total += $_POST['qty'][$key] * $_POST['rate'][$key];

                        $this->PurchaseModel->updateStock('stock',$_POST['qty'][$key],$_POST['product_name'][$key]);

                    }
                        
                }


                $om_filter         = array('id'     =>$purchase_id);
                        $purchase_master_data = array('total'  =>$total);
                        $this->AdminModel->update('purchase',$om_filter,$purchase_master_data);

                

            


                //insert backup data
                $o_filter = array('purchase_id'=>$purchase_id,'status'=>'1');   
                $purchase_backup_data = $this->AdminModel->getList('purchase_details',$o_filter);

                foreach($purchase_backup_data as $backup){
                $purchase_backup_details[] = array('purchase_id' =>$backup['purchase_id'],                           'product_id'     =>$backup['product_id'],
                                                'rate'           =>$backup['rate'],
                                                'qty'            =>$backup['qty'],
                                                'subtotal'       =>$backup['subtotal'],
                                                'created_at'   =>date('Y-m-d h:i:s')
                                                );
                }

                $this->AdminModel->insertBatch('purchase_backup_details',$purchase_backup_details);

                $update_data[] = array(
                                    'purchase_id'   =>$purchase_id,
                                    'status'        =>'0');
                $this->AdminModel->updateBatch('purchases_details',$update_data,'purchase_id');

                $add = $this->AdminModel->insertBatch('purchases_details',$purchase_details);



                
                
                $this->db->trans_complete();

                if($add){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']  = 'Purchase Updated Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']  = 'Please try again';
                }
            }else{
                $returnArr['errCode']     = 5;
                $returnArr['message']     = '<p class="error">Product Name is required</p><p class="error">Qty is required</p>';
            }

            
            

        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            } 
        }
        echo json_encode($returnArr);

    }

    public function viewPurchaseDetails(){
        $id = $this->uri->segment(3);
       
        $data['suppliers'] = $this->PurchaseModel->getPurchaseDetails('purchases_details',$id);

        $this->load->view('purchase/purchases_details',$data);
    }

    public function stockList(){
        $this->load->view('purchase/stock_details');
    }

    public function getStockList(){
        $data = $row = array();
        

        // Fetch member's records
        $memData = $this->PurchaseModel->getStockDetailsRows($_POST);



        $i = $_POST['start'];
        foreach($memData as $member){

            $stock_in = 0;
            $stock_out= 0;
            $total_stock_in = 0;
            $total_stock_out = 0;
            $todays_stock_in = 0;
            $todays_stock_out = 0;

            $filter   = array('product_id'=>$member->id);
            $filter['DATE(updated_at) <'] = date('Y-m-d');
            $filter['DATE(updated_at) <'] = date('Y-m-d');

            //total stock in stock out
            $stock_in_details = $this->PurchaseModel->getStockInDetails($filter);
   
            $stock_out_details = $this->PurchaseModel->getStockOutDetails($filter);
              
            
            if(isset($stock_in_details['stock_in'])){
                $date = date('d-m-Y h:i A',strtotime($stock_in_details['purchase_created_at']));
                $total_stock_in = $stock_in_details['stock_in'];
            }

                 
            if(isset($stock_out_details['stock_out'])){
                $date = date('d-m-Y h:i A',strtotime($stock_out_details['order_created_at']));
                $total_stock_out = $stock_out_details['stock_out'];
            }
            

            if(isset($_POST['columns'][6]['search']['value']) && !empty($_POST['columns'][6]['search']['value'])){

                $created_at       = date('Y-m-d',strtotime($_POST['columns'][6]['search']['value']));
                $p_filter['DATE(updated_at) >='] = $created_at;
                $p_filter['DATE(updated_at) <='] = $created_at;
                $p_filter['product_id']          = $member->id;

            }else{
      
                $p_filter['DATE(updated_at) >='] = date('Y-m-d');
                $p_filter['DATE(updated_at) <='] = date('Y-m-d');
                $p_filter['product_id']          = $member->id;
            }

            //total stock in stock out
            $todays_in_details = $this->PurchaseModel->getStockInDetails($p_filter);
            $todays_out_details = $this->PurchaseModel->getStockOutDetails($p_filter);


            if(isset($todays_in_details['stock_in'])){
                $todays_stock_in =  $todays_in_details['stock_in'];
            }

            if(isset($todays_out_details['stock_out'])){
                $todays_stock_out  = $todays_out_details['stock_out'];
            }


            if(isset($_POST['columns'][6]['search']['value']) && !empty($_POST['columns'][6]['search']['value'])){

                $created_at       = date('Y-m-d h:i A',strtotime($_POST['columns'][6]['search']['value']));

            }else{
                $created_at       = date('Y-m-d h:i A');
            }

            $old_remaning_stock = $total_stock_in - $total_stock_out;
            $stock_in = $todays_stock_in + $old_remaning_stock;
            $stock_out = $todays_stock_out;
            $remaining_stock = $stock_in - $stock_out;

            // echo '<br>total_stock_in'.$total_stock_in;
            // echo '<br>total_stock_out'.$total_stock_out;
            // echo '<br>todays_stock_in'.$todays_stock_in;
            // echo '<br>todays_stock_out'.$todays_stock_out;
            // echo '<br>old_remaning_stock'.$old_remaning_stock;
            // echo '<br>stock_in'.$stock_in;
            // echo '<br>stock_out'.$stock_out;
            // echo '<br>remaining_stock'.$remaining_stock;exit;

            if($member->product_name){
                $i++;

                $image = '<img src="'.$member->image.'" width="50px" height="50px">';

                $data[] = array(
                                $i,
                                $image, 
                                $member->product_name,
                                $stock_in,
                                $stock_out,
                                $remaining_stock,
                                $created_at
                            );
            }
            
        }




        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->PurchaseModel->countAllStockDetails(),
            "recordsFiltered" => $this->PurchaseModel->countFilteredStockDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }


    public function cancelPurchase(){
        $id = $this->uri->segment(3);

        $od_filter = array('purchase_id'=>$id,'status'=>'1');
        $purchase_details = $this->AdminModel->getList('purchases_details',$od_filter);

        foreach($purchase_details as $row){
            $this->PurchaseModel->subtractStockIn('stock',$row['qty'],$row['product_id']);
        }

        $filter = array('id'=>$id);
        $data   = array('purchase_status'=>'2');
        $this->AdminModel->update('purchase',$filter,$data);
        redirect(base_url().'Purchase/purchaseList');
    }
    public function deletePurchase(){
        $id = $this->uri->segment(3);

        $od_filter = array('purchase_id'=>$id,'status'=>'1');
        $purchase_details = $this->AdminModel->getList('purchases_details',$od_filter);

        foreach($purchase_details as $row){
            $this->PurchaseModel->subtractStockIn('stock',$row['qty'],$row['product_id']);
        }

        $filter = array('id'=>$id);
        $data   = array('status'=>'0');
        $this->AdminModel->update('purchase',$filter,$data);

        $filter_1 = array('purchase_id'=>$id);
        $data_1   = array('status'=>'0');
        $this->AdminModel->update('purchase',$filter_1,$data_1);
        redirect(base_url().'Purchase/purchaseList');
    }
}   
    