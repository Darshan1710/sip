<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

        public function getOrderList(){
        $data = $row = array();
    

        // Fetch member's records
        $memData = $this->AdminModel->getOrderDetailsRows($_POST);


        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;

            $status = '';
            if($member->order_status == 1){
                $status =  '<button class="btn btn-primary btn-sm">pending</button>';
            }else if($member->order_status == 2){
                $status = '<button class="btn btn-success btn-sm">delivered</button>';
            }else if($member->order_status == 4){
                $status = '<button class="btn btn-danger btn-sm">damage</button>';
            }else if($member->order_status == 3){
                $status = '<button class="btn btn-warning btn-sm">canceled</button>';
            }else if($member->order_status == 5){
                $status = '<button class="btn btn-warning btn-sm">Out</button>';
            }

            $payment_status = '';
            if($member->payment_status == 1){
                $payment_status =  '<button class="btn btn-primary btn-sm">pending</button>';
            }else if($member->payment_status == 2){
                $payment_status = '<button class="btn btn-warning btn-sm">partial</button>';
            }else if($member->payment_status == 3){
                $payment_status = '<button class="btn btn-success btn-sm">done</button>';
            }


            $view_ordrer = '<a href="'.base_url().'Order/orderDetails/'.$member->order_id.'/'.$member->unique_id.'" class="btn btn-sm btn-success">View Order</a>';

            $action = '<td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="'.base_url().'Order/invoice/'.$member->order_id.'"><i class="icon-file-excel"></i> Invoice</a></li>
                                    <li><a href="'.base_url().'Order/editOrder/'.$member->order_id.'"><i class="icon-pencil"></i> Edit</a></li>
                                    <li><a href="'.base_url().'Order/checkoutForm/'.$member->order_id.'"><i class="icon-coin-dollar"></i> Add Payment</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>';

            $name = isset($member->name) ? $member->name : 'Walk in';
            $address = wordwrap($member->address,15,"<br>\n");
            $data[] = array($member->order_id,
                            $i,
                            $name, 
                            $member->mobile,
                            $member->email,
                            $view_ordrer,
                            $status,
                            $payment_status,
                            date('d-m-Y h:i A',strtotime($member->order_created_at)),
                            $action
                        );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AdminModel->countAllOrderDetails(),
            "recordsFiltered" => $this->AdminModel->countFilteredOrderDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }
    public function orderList(){
        $this->load->view('order/orderList');
    }
    public function orderForm(){
        $data['customer'] = array();

        if($this->uri->segment(3)){
            $id = $this->uri->segment(3);

            $c_filter = array('id'=>$id);
            $data['customer'] = $this->AdminModel->getCustomerDetails($c_filter);
        }
  
        $this->load->view('order/order_form',$data);
    }
    public function addOrder(){
        $this->form_validation->set_rules('customer_unique_id','Customer Id','trim|xss_clean|max_length[255]');


        if($this->form_validation->run()){

            $input_data     = $this->input->post();
            $id             = $this->input->post('enquiry_id');
            $total          = 0;
            $add            = false;
            $customer_unique_id = $input_data['customer_unique_id'];

            $discount_type  = !empty($input_data['discount_type']) ? $input_data['discount_type'] : '';
            $discount       = !empty($input_data['discount']) ? $input_data['discount'] : 0;
            $delivery_charge = !empty($input_data['delivery_charge']) ? $input_data['delivery_charge'] : 0;


            $c_filter = array('unique_id'=>$customer_unique_id);
            $customer_details = $this->AdminModel->getDetails('customers',$c_filter);

            $ca_filter = array('customer_unique_id'=>$customer_unique_id);
            $customer_addresses = $this->AdminModel->getDetails('customer_addresses',$ca_filter);
            if(!empty($_POST['product_name'][0])){
                foreach($this->input->post('product_name') as $key => $value){
                    
                    if(!empty($_POST['product_name'][$key])){
                        $p_filter = array('id'=>$_POST['product_name'][$key]);
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        $total += $p_details['sell_price'] * $_POST['qty'][$key];
                    }

                    if($_POST['qty'][$key] == 0){
                        $returnArr['errCode'] = 2;
                        $returnArr['message'] = $p_details['product_name'].' Quantity should not be 0';
                        echo json_encode($returnArr);exit;
                    }

                        
                }

                $this->db->trans_start();


                $final_discount = 0;

                if($discount_type == '1'){
                    $final_discount = ($discount / 100) * $total;
                    $final_total = $total - $final_discount;
                    
                }else if($discount_type == '2'){
                    $final_discount = $discount;
                    $final_total = $total - $discount;

                }else{
                    $final_total = $total;
                }
                
                $final_total = $final_total + $delivery_charge;

                if($customer_unique_id == 'new'){
                    $customer_unique_id = time();
                }

                $order_data  = array('customer_unique_id'=>$customer_unique_id,
                                     'total'        =>$total,
                                     'discount_type'=>$discount_type,
                                     'discount'     =>$discount,
                                     'final_discount'=>$final_discount,
                                     'final_total'  =>$final_total,
                                     'delivery_charge'=>$delivery_charge,
                                     'coupon_id'    =>$this->input->post('coupen'),
                                     'created_at'   =>date('Y-m-d h:i:s')
                                     );

                    $order_id    = $this->AdminModel->insert('order_masters',$order_data);


                foreach($this->input->post('product_name') as $key => $value){
                
                    if(!empty($_POST['product_name'][$key])){
                        $p_filter = array('id'=>$_POST['product_name'][$key]);
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        $order_details[] = array('order_id'    =>$order_id,
                                                 'product_id'  =>$_POST['product_name'][$key],
                                                 'rate'        =>$_POST['sell_price'][$key],
                                                 'qty'         =>$_POST['qty'][$key],
                                                 'price'        =>$p_details['sell_price'] * $_POST['qty'][$key],
                                                'created_at'   =>date('Y-m-d h:i:s'));

                        $total += $p_details['sell_price'] * $_POST['qty'][$key];
                        

                    }
                        
                }


                $add = $this->AdminModel->insertBatch('order_details',$order_details);
            
                // send email

                $addresses_data = array(
                                        'street_address'=>$customer_addresses['street_address'],
                                        'pincode'       =>$customer_addresses['pincode'],
                                        'city'          =>$customer_addresses['city']);
            //send email
                 $bodyContent = "<div>Name: ".$customer_details['name']."<br>Mobile: ".$customer_details['mobile']."<br>Email: ".$customer_details['email']."<br>Address: ".implode(',', $addresses_data)."<br>Total : ".$total."<br></div><br><table>
                <tbody>
                    <tr style='background-color:#A9A9A9'>
                        <td style='padding:20px'>Product Name*</td>
                        <td style='padding:20px'>Unit Price*</td>
                        <td style='padding:20px'>Qty</td>
                        <td style='padding:20px'>Price</td>
                    </tr>";

                foreach($this->input->post('product_name') as $row){

                     $bodyContent .= "<tr style='background-color:#A9A9A9'>
                            <td style='padding:20px'>".$_POST['product_name'][$key]."</td>
                            <td style='padding:20px'>".$_POST['sell_price'][$key]."</td>
                            <td style='padding:20px'>".$_POST['qty'][$key]."</td>
                            <td style='padding:20px'>".$_POST['sell_price'][$key] * $_POST['qty'][$key]."</td>
                        </tr>";
                    
                }

                $bodyContent .= "</tbody></table>";

               // $this->send_mail('kinidarshan07@gmail.com','Thanks for your order',$bodyContent);


                //send sms
                $msg = 'Thanks for your order';
                $mobile = $customer_details['mobile'];

                $username = urlencode("u_alphacore"); 
                $msg_token = urlencode("EEYN6t"); 
                $sender_id = urlencode("612324"); // optional (compulsory in transactional sms) 
                $message = urlencode($msg); 
                $mobile = urlencode($mobile); 


                $api = "http://la-suit.vispl.in/api/send_promotional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile.""; 

            //    $response = file_get_contents($api);

              //  $data = json_decode($response,true);

                $this->db->trans_complete();

                if($add){
                    $returnArr['errCode']     = -1;
                    $returnArr['order_id']  = $order_id;
                    $returnArr['customer_unique_id']  = $customer_unique_id;
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

    public function editOrder(){
        $order_id = $this->uri->segment(3);
        $filter   = array('o.id'=>$order_id);
        $data['order'] = $this->AdminModel->getOrderMasterData($filter);

        $customer_unique_id = $data['order']['customer_unique_id'];
        $address_id         = $data['order']['address'];

        $filter['od.status']  = '1';
        $data['order_details'] = $this->AdminModel->getOrderDetails($filter);

        $filter = array('customer_unique_id'=>$customer_unique_id,
                        'id'                =>$address_id);
        $data['address'] = $this->AdminModel->getList('customer_addresses',$filter);

        $c_filter = array('unique_id'=>$customer_unique_id);
        $data['customer'] = $this->AdminModel->getDetails('customers',$c_filter);


        $data['products'] = $this->AdminModel->getList('products');


        $this->load->view('order/edit_order',$data);
    }
    public function updateOrder(){
        $this->form_validation->set_rules('order_id','Order Id','required|trim|xss_clean|max_length[255]');


        if($this->form_validation->run()){

            $input_data = $this->input->post();
            $order_id = $this->input->post('order_id');
            $customer_unique_id = $this->input->post('customer_unique_id');
            $total = 0;
            $add = false;
            $final_discount = 0;
            $final_total = 0;
            if(!empty($_POST['product_name'][0])){

                //insert backup data
                $o_filter = array('order_id'=>$order_id,'status'=>'1');   
                $order_backup_data = $this->AdminModel->getList('order_details',$o_filter);

                $this->db->trans_start();


                foreach($this->input->post('product_name') as $key => $value){
                
                    if(!empty($_POST['product_name'][$key])){

                        $p_filter = array('id'=>$_POST['product_name'][$key],'status'=>'1');;
                        $p_details = $this->AdminModel->getDetails('products',$p_filter);

                        if($_POST['qty'][$key] == 0){
                            $returnArr['errCode'] = 2;
                            $returnArr['message'] = 'Quantity should not be 0';
                            echo json_encode($returnArr);exit;
                        }


                        //new data
                        $order_details[] = array('order_id'    =>$order_id,
                                                 'product_id'  =>$_POST['product_name'][$key],
                                                 'rate'        =>$_POST['sell_price'][$key],
                                                 'qty'         =>$_POST['qty'][$key],
                                                 'price'       =>$p_details['sell_price'] * $_POST['qty'][$key]);

                        $total += $_POST['qty'][$key] * $_POST['sell_price'][$key];

                    }
                        
                }                

  
                foreach($order_backup_data as $backup){
                $order_backup_details[] = array('order_id'  =>$backup['order_id'],                           'product_id'=>$backup['product_id'],
                                                'rate'      =>$backup['rate'],
                                                'qty'       =>$backup['qty'],
                                                'price'     =>$backup['price'],
                                                'created_at'=>date('Y-m-d h:i:s')
                                                );

                }

                $this->AdminModel->insertBatch('order_backup_details',$order_backup_details);

                //update total in order master

                $discount_type = $input_data['discount_type'];
                $delivery_charge = $input_data['delivery_charge'];

                if($discount_type == '1'){
                    $final_discount = ($input_data['discount'] / 100) * $total;
                    $final_total = $total - $final_discount;
                    $final_total = $final_total + $delivery_charge;
                }else if($discount_type == '2'){
                    $final_discount = $input_data['discount'];
                    $final_total = $total - $input_data['discount'];
                    $final_total = $final_total + $delivery_charge;
                }else{
                    $final_total = $total + $delivery_charge;
                }

                $om_filter         = array('id'=>$order_id);
        $order_master_data = array('customer_unique_id'  =>$this->input->post('customer_unique_id'),
                                 'subtotal'        =>$total,
                                 'discount_type'=>$input_data['discount_type'],
                                 'discount'     =>$input_data['discount'],
                                 'final_discount'=>$final_discount,
                                 'final_total'  =>$final_total,
                                 'delivery_charge'=>$delivery_charge,
                                 // 'delivery_boy' =>$this->input->post('delivery_boy_id'),
                                 // 'delivery_zone'=>$this->input->post('delivery_zone_id')
                         );

                $this->AdminModel->update('order_masters',$om_filter,$order_master_data);

                //delete data from order details
                $o_data = array('status'=>'0');
                $delete_orders = $this->AdminModel->update("order_details",$o_filter,$o_data);

                $update_data[] = array(
                                    'order_id'   =>$order_id,
                                    'status'        =>'0');
                $this->AdminModel->updateBatch('order_details',$update_data,'order_id');

                $add = $this->AdminModel->insertBatch('order_details',$order_details);


                // $p_filter = array('pay_id'=>$order_id);
                // $payment_details = $this->AdminModel->getList('payment_details',$p_filter);

                // $j = 0;
                // $payment_details_backup_data = array();
                // foreach($payment_details as $p_row){
                //     $payment_details_backup_data[$j]['payment_id'] = $p_row['id'];
                //     $payment_details_backup_data[$j]['pay_id']     = $p_row['pay_id'];
                //     $payment_details_backup_data[$j]['pay_type']   = $p_row['pay_type'];
                //     $payment_details_backup_data[$j]['payment_mode']=$p_row['payment_mode'];
                //     $payment_details_backup_data[$j]['recieved_amount']=$p_row['recieved_amount'];
                //     $payment_details_backup_data[$j]['change']     = $p_row['change'];
                //     $payment_details_backup_data[$j]['upi']        = $p_row['upi'];
                //     $payment_details_backup_data[$j]['transcation_id'] = $p_row['transcation_id'];
                //     $payment_details_backup_data[$j]['card_number']= $p_row['card_number'];
                //     $payment_details_backup_data[$j]['cheque_number']= $p_row['cheque_number'];
                //     $payment_details_backup_data[$j]['cheque_date'] = $p_row['cheque_date'];
                //     $payment_details_backup_data[$j]['amount']      = $p_row['amount'];
                //     $j++;
                // }

                // if($payment_details_backup_data){
                //    $this->AdminModel->insertBatch('payment_backup_details',$payment_details_backup_data);

                //     $this->AdminModel->delete('payment_details',$p_filter); 
                // }
                

                $this->db->trans_complete();

                if($add){
                    $returnArr['errCode']     = -1;
                    $returnArr['order_id']    = $order_id;
                    $returnArr['customer_unique_id'] = $customer_unique_id;
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
    public function cancelOrder(){
        $ids = $this->input->post('id');

        $total = 0;
        foreach($ids as $row){

            $filter = array('id'=>$row);
            $order_details = $this->AdminModel->getDetails('order_details',$filter);

            $order_id   = $order_details['order_id'];

            $total = $order_details['qty'] * $order_details['rate'];
        }


        $f_filter = array('id'=>$order_id);
        $order_data  = $this->AdminModel->getDetails('order_master',$f_filter);

        $final_total = 0;
        if($order_data['final_total'] > 0){
            $final_total  = $order_data['final_total'] - $total;
             $final_total  = $final_total - $total;
        
            $f_data = array('final_total'=>$final_total);
            $this->AdminModel->update('order_master',$f_filter,$f_data);
        }

       

        $data = array('product_status'=>'2');
        $update = $this->AdminModel->updateMulitple('order_details',$ids,$data);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }
        echo json_encode($returnArr);
    }

    public function damageOrder(){
        $ids = $this->input->post('id');

        $total = 0;
        foreach($ids as $row){

            $filter = array('id'=>$row);
            $order_details = $this->AdminModel->getDetails('order_details',$filter);

            $order_id   = $order_details['order_id'];

            $total = $order_details['qty'] * $order_details['rate'];
        }


        $f_filter = array('id'=>$order_id);
        $order_data  = $this->AdminModel->getDetails('order_master',$f_filter);

        $final_total = 0;
        if($order_data['final_total'] > 0){
            $final_total  = $order_data['final_total'] - $total;
             $final_total  = $final_total - $total;
        
            $f_data = array('final_total'=>$final_total);
            $this->AdminModel->update('order_master',$f_filter,$f_data);
        }

        $data = array('product_status'=>'3');
        $update = $this->AdminModel->updateMulitple('order_details',$ids,$data);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }
        echo json_encode($returnArr);
    }
    public function deliveredOrder(){
        $id = $this->input->post('id');

        $filter = array('id'=>$id);
        $data = array('order_status'=>'1');
        $update = $this->AdminModel->update('order_masters',$filter,$data);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }
        echo json_encode($returnArr);
    }
    public function deletOrder(){
        $ids = $this->input->post('id');

        foreach($ids as $row){

            $filter = array('id'=>$row);
            $order_details = $this->AdminModel->getDetails('order_details',$filter);

            $qty        = $order_details['qty'];
            $product_id = $order_details['product_id'];
            $this->PurchaseModel->addStockOut('stock',$qty,$product_id);
        }

        $data = array('product_status'=>'4','status'=>'0');
        $update = $this->AdminModel->updateMulitple('order_details',$ids,$data);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }
        echo json_encode($returnArr);
    }

    public function getOrderDetails(){
        $this->form_validation->set_rules('order_id','Order Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){

            $filter = array('id'=>$this->input->post('order_id'));
            $order_details = $this->AdminModel->getDetails('order_masters',$filter);


            $p_filter = array('id'=>$this->input->post('order_id'));
            $p_data   = $this->AdminModel->getPaidAmount($p_filter);

            $amount = $order_details['final_total'];


            if($p_data){
                $amount = $order_details['final_total'] - round($p_data['amount'],2);
            }

            $data['amount'] = $amount;
            if($order_details){
                $returnArr['errCode']       = -1;
                $returnArr['message']       = $data;
            }else{  
                $returnArr['errCode']       = 2;
                $returnArr['message']       = 'Please try again';
            }

        }else{
          
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function changeDeliveryStatus(){
        $ids = $this->input->post('ids');
        $status = $this->input->post('status');
    
        $filter = array('order_status'=>$status);
        $update_status = $this->AdminModel->updateMulitple('order_masters',$ids,$filter);
      //  echo $this->db->last_query();exit;
        if($update_status){

             $this->session->set_flashdata('success', 'Product Delivery Status Change successfully');

            $returnArr['error']     = false;
            $returnArr['message']   = 'success';
        }else{
            $returnArr['error']     = true;
            $returnArr['message']   = 'failed';
        }
        echo json_encode($returnArr);
    }

    public function invoice(){
        $id = $this->uri->segment(3);

        $filter = array('o.id'=>$id);
        $data['customer'] = $this->AdminModel->getOrderMasterData($filter);

        $c_filter = array('order_id'=>$id,'od.status'=>'1','product_status'=>'1');
        $data['order_details'] = $this->AdminModel->getOrderDetails($c_filter);



        $this->load->view('order/invoice',$data);
    }

     public function orderDetails(){
        $id = $this->uri->segment(3);
        $o_filter = array('o.id'=>$id);
        $data['order'] = $this->AdminModel->getOrderMasterData($o_filter);

        $filter = array('order_id'=>$id,'od.status'=>'1');
        $data['order_details'] = $this->AdminModel->getOrderDetails($filter);
        $this->load->view('order/order_details',$data);
    }

    public function checkoutForm($order_id,$customer_id = NULL){
        
        
        $order_filter = array('id'=>$order_id);
        $status_details = $this->AdminModel->getDetails('order_masters',$order_filter);

        if($status_details['order_status'] != '2'){
           $this->session->set_flashdata('warning', 'Payment will be done after delivered status');
           redirect('/Order/orderList','refresh'); 
        }else{


            $data['order_id'] = $order_id;
            if($customer_id){
                $data['customer_id'] = $customer_id;
            }else{
                $data['customer_id'] = 0;
            }
        
            $filter = array('order_id'=>$order_id);
            $data['payment'] = $this->AdminModel->getList('payment_details',$filter);        

            $filter = array('id'=>$order_id);
            $order_details = $this->AdminModel->getDetails('order_masters',$filter);

            $p_filter = array('order_id'=>$order_id);
            $p_data   = $this->AdminModel->getPaidAmount($p_filter);

            $amount = $order_details['final_total'];


            if($p_data){
                $amount = $order_details['final_total'] - round($p_data['amount'],2);
            }

            $data['amount'] = $amount;
            $this->load->view('order/checkout',$data);
        }
    }


    public function addPayment(){
    
        $this->form_validation->set_rules('order_id','Order Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_id','Customer Id','trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('payment_mode','Payment Mode','required|trim|xss_clean|max_length[255]');
        if($this->input->post('payment_mode') == 'cash'){
            $payment_mode = '1';
            $this->form_validation->set_rules('amount','Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('cash_recieved_amount','Recieved Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('change','Change','required|trim|xss_clean|max_length[255]');
        }else if($this->input->post('payment_mode') == 'cheque'){
            $payment_mode = '2';
            $this->form_validation->set_rules('amount','Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('cheque_recieved_amount','Recieved Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('cheque_number','Cheque Number','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('cheque_date','Cheque Date','required');
        }else if($this->input->post('payment_mode') == 'nfet'){
            $payment_mode = '4';
            $this->form_validation->set_rules('amount','Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('nfet_recieved_amount','Recieved Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('account_number','Account Number','required|trim|xss_clean|max_length[255]');
        }else if($this->input->post('payment_mode') == 'upi'){
            $payment_mode = '3';
            $this->form_validation->set_rules('amount','Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('upi_recieved_amount','Recieved Amount','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('transcation_id','Transcation Id','trim|xss_clean|max_length[255]');
        }
        
        if($this->form_validation->run()){
            $input_data = $this->input->post();

            if(isset($input_data['customer_id'])){
                $unique_id = $input_data['customer_id'];
            }else{
                $unique_id = time();
            }

            $data = array('order_id'             =>$this->input->post('order_id'),
                          'payment_mode'        =>$payment_mode
                        );

            if($this->input->post('payment_mode') == 'cash'){
                $data['amount']             = $input_data['amount'];
                $data['recieved_amount']    = $input_data['cash_recieved_amount'];
                $data['change']             = $input_data['change'];
            }else if($this->input->post('payment_mode') == 'cheque'){
                $data['amount']             = $input_data['amount'];
                $data['recieved_amount']    = $input_data['cheque_recieved_amount'];
                $data['cheque_number']      = $input_data['cheque_number'];
            }else if($this->input->post('payment_mode') == 'nfet'){
                $data['amount']             = $input_data['amount'];
                $data['recieved_amount']    = $input_data['nfet_recieved_amount'];
                $data['account_number']     = $input_data['account_number'];
            }else if($this->input->post('payment_mode') == 'upi'){
                $data['amount']             = $input_data['amount'];
                $data['recieved_amount']    = $input_data['upi_recieved_amount'];
                $data['transcation_id']     = $input_data['transcation_id'];
            }

            $update = $this->AdminModel->insert('payment_details',$data);

            $p_filter = array('id'=>$this->input->post('order_id'));
            $p_data   = $this->AdminModel->getPaidAmount($p_filter);

            $o_filter = array('id'=>$this->input->post('order_id'));
            $o_data   = $this->AdminModel->getDetails('order_masters',$o_filter);


            if($o_data['final_total'] == $p_data['amount']){
                $payment_status_data = array('payment_status'=>'2');
                $this->AdminModel->update('order_masters',$o_filter,$payment_status_data);
            }

            if($update){
                $this->session->set_flashdata('success', 'Payment Added Successfully');

                $returnArr['errCode']       = -1;
                $returnArr['order_id']      = $this->input->post('order_id');
                $returnArr['customer_id']   = $this->input->post('customer_id');
                $returnArr['proceed']       = $o_data['final_total'] == $p_data['amount'] ? true : false;
            }else{  
                $returnArr['errCode']       = 2;
                $returnArr['message']       = 'Please try again';
            }
        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }

    public function deletePayment(){

        $id = $this->input->post('id');

        $filter = array('id'=>$id);
        $details = $this->AdminModel->getDetails('payment_details',$filter);

        $backup_data = array('payment_id'       =>$details['id'],
                             'order_id'         =>$details['order_id'],
                             'payment_mode'     =>$details['payment_mode'],
                             'recieved_amount'  =>$details['recieved_amount'],
                             'upi'              =>$details['upi'],
                             'transacation_id'  =>$details['transacation_id'],
                             'card_number'      =>$details['card_number'],
                             'cheque_number'    =>$details['cheque_number'],
                             'cheque_date'      =>$details['cheque_date'],
                             'amount'           =>$details['amount'],
                             'change'           =>$details['change'],
                             );

        $this->AdminModel->insert('payment_backup_details',$backup_data);

        $delete = $this->AdminModel->deletePayment($filter);

        if($delete){
            $returnArr['error']  = -1;
            $returnArr['message']= 'success';
        }else{
            $returnArr['error']  = 2;
            $returnArr['message']= 'failed';
        }

        echo json_encode($returnArr);
    }
}
