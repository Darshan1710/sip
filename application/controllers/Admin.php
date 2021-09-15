<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('AdminModel');
    }

    public function index() {
        $this->load->view('login');
    }

    public function registerView() {
        $this->load->view('register.php');
    }

    public function AddRegister() {
        $this->AdminModel->AddRegister();
    }

    public function login() {

        $this->form_validation->set_rules('username','Username','required|trim|xss_clean');
        $this->form_validation->set_rules('password','Password','required|trim|xss_clean');
        if($this->form_validation->run()){
            $username = $this->input->post('username');
            $password = $this->input->post('password');


            $filter = array('username' => $username,
                            'password' =>md5($password));


            $result = $this->AdminModel->getDetails('admin',$filter);
            if ($result) {

                    $logdata = array(
                        'logged_in' => TRUE,
                        'username'  => $result['username'],
                        'user_id'   => $result['id'],
                        'first_name'=> $result['first_name'],
                        'last_name' => $result['last_name']
                    );
                    
                    $this->session->set_userdata($logdata);
                    $this->dashboard();
            } else {
                $this->load->view('login');
            } 
        }else{
            $this->load->view('login');
        }
          
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        $this->load->view('login.php');
    }

     public function dashboard(){

        $count_data = $this->AdminModel->getDashboardData();


        $data['dashboard']['todays_customer'] = isset($count_data['todays_customer']) ? $count_data['todays_customer'] : 0;
        $data['dashboard']['todays_enquiry'] = isset($count_data['todays_enquiry']) ? $count_data['todays_enquiry'] : 0;
        $data['dashboard']['todays_order'] = isset($count_data['todays_order']) ? $count_data['todays_order'] : 0;
        $data['dashboard']['todays_sale'] = isset($count_data['todays_sale']) ? $count_data['todays_sale'] : 0;
        $data['dashboard']['total_customer'] = isset($count_data['total_customer']) ? $count_data['total_customer'] : 0;
        $data['dashboard']['total_enquiry'] = isset($count_data['total_enquiry']) ? $count_data['total_enquiry'] : 0;
        $data['dashboard']['total_order'] = isset($count_data['total_order']) ? $count_data['total_order'] : 0;
        $data['dashboard']['total_sale'] = isset($count_data['total_sale']) ? $count_data['total_sale'] : 0;
        $data['dashboard']['todays_purchase'] = isset($count_data['todays_purchase']) ? $count_data['todays_purchase'] : 0;
        $data['dashboard']['total_purchase'] = isset($count_data['total_purchase']) ? $count_data['total_purchase'] : 0;
        $data['dashboard']['todays_damage'] = isset($count_data['todays_damage']) ? $count_data['todays_damage'] : 0;
        $data['dashboard']['total_damage'] = isset($count_data['total_damage']) ? $count_data['total_damage'] : 0;


        $first_date = date('Y-m-d',strtotime('-7 days'));
        $last_date  = date('Y-m-d');
        $type       = 'DATE';

       
        if(isset($_POST['date_picker']) && !empty($_POST['date_picker'])){
            $dates            = explode('-',$_POST['date_picker']);
            $first_date       = date('Y-m-d',strtotime($dates['0']));
            $last_date         = date('Y-m-d',strtotime($dates['1']));
        }

        
        if(!empty($_POST['type'])){
            $type  = $this->input->post('type');
        }


        $order_data = $this->AdminModel->getOrderGraphData($first_date,$last_date,$type);


        $data['order']       = $order_data;
        $data['date_picker'] = isset($_POST['date_picker']) ? $_POST['date_picker'] : '';
        $data['type']        = $type;

  
        $this->load->view('dashboard',$data);
    }



   

    public function convertToOrder(){
        if($this->session->userdata('logged_in')){
            $id = $this->uri->segment(3);
            $o_filter = array('em.id'=>$id);
            $data['enquiry'] = $this->AdminModel->getEnquiryMasterData($o_filter);

            $data['products'] = $this->AdminModel->getList('products');

            $filter = array('enquiry_id'=>$id);
            $data['enquiry_details'] = $this->AdminModel->getEnquiryDetails($filter);

            // $filter = array('status'=>'1');
            // $data['delivery_boy'] = $this->AdminModel->getList('delivery_boy',$filter);

            // $data['delivery_zone'] = $this->AdminModel->getList('delivery_zone',$filter);
            $this->load->view('order_form',$data);
        }else{
            $this->load->view('login');
        }
        
    }
    public function cancelEnquiry(){
        $id = $this->input->post('id');

        $filter = array('id'=>$id);
        $data = array('enquiry_status'=>'2');
        $update = $this->AdminModel->update('enquiry_master',$filter,$data);

        if($update){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'failed';
        }
        echo json_encode($returnArr);
    }
   



    public function assignCustomerForm($id){
        $data['order_id'] = $id;
        $this->load->view('customer/assign_customer',$data);
    }
    public function assignCustomer($id){
        $this->form_validation->set_rules('order_id','Order Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('customer_unique_id','Customer Unique Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email','Email','trim|xss_clean|max_length[255]|valid_email');
        if($this->form_validation->run()){
            $filter = array('mobile'=>$this->input->post('mobile'));

            $checkMenu = $this->AdminModel->getDetails('customers',$filter);
            if($checkMenu){

                    $unique_id = $checkMenu['unique_id'];

                    $o_filter = array('id'=>$this->input->post('order_id'));
                    $o_data   = array('customer_unique_id'=>$unique_id);

                    $this->AdminModel->update('order_master',$o_filter,$o_data);

            }else{  
                    $unique_id = $this->input->post('customer_unique_id');

                    $data = array('unique_id'       =>$unique_id,
                                  'name'            =>$this->input->post('name'),
                                  'email'           =>$this->input->post('email'),
                                  'mobile'          =>$this->input->post('mobile')
                              );

                    $add = $this->AdminModel->insert('customers',$data);


                    $o_filter = array('id'=>$this->input->post('order_id'));
                    $o_data   = array('customer_unique_id'=>$this->input->post('customer_unique_id'));

                    $this->AdminModel->update('order_master',$o_filter,$o_data);

            }


                $returnArr['errCode']       = -1;
                $returnArr['order_id']      = $this->input->post('order_id');
                $returnArr['customer_unique_id']   = $unique_id;

        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }

    public function assignAddressForm($order_id,$customer_id){
        $data['order_id']       = $order_id;
        $data['customer_id']    = $customer_id;


        $filter = array('customer_unique_id'=>$customer_id);
        $data['address'] = $this->AdminModel->getList('customer_addresses',$filter);

        $this->load->view('customer/assign_address',$data);
    }

    public function assignAddress(){
        $this->form_validation->set_rules('customer_unique_id','Customer Unique Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('order_id','Order Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('address_id','Address Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'            =>$this->input->post('order_id'),
                            'customer_unique_id'   =>$this->input->post('customer_unique_id')
                        );

            $data = array('address'=>$this->input->post('address_id'));

            $update = $this->AdminModel->update('order_master',$filter,$data);

            if($update){
                $returnArr['errCode']       = -1;
                $returnArr['order_id']      = $this->input->post('order_id');
                $returnArr['customer_unique_id']   = $this->input->post('customer_unique_id');
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

    
    


        public function mailtrigger(){

        $orders = $this->AdminModel->getEnquiryList();
        
        foreach($orders as $o){
            $c_filter = array('id'=>$o['customer_id']);
            $customer   = $this->AdminModel->getDetails('customer',$c_filter);

            $filter = array('enquiry_id'=>$o['id']);
            $enquiry_details = $this->AdminModel->getEnquiryDetails($filter);

            $total = 0;
            foreach($enquiry_details as $row){
                 $total += $row['unit_price'] * $row['qty'];
            }


            //send email
             $bodyContent = "<div>Name: ".$customer['name']."<br>Mobile: ".$customer['mobile']."<br>Email: ".$customer['email']."<br>Address: ".$customer['address']."<br>Total : ".$total."<br></div><br><table>
            <tbody>
                <tr style='background-color:#A9A9A9'>
                    <td style='padding:20px'>Product Name*</td>
                    <td style='padding:20px'>Unit Price*</td>
                    <td style='padding:20px'>Qty</td>
                    <td style='padding:20px'>Price</td>
                </tr>";

            foreach($enquiry_details as $row){

                 $bodyContent .= "<tr style='background-color:#A9A9A9'>
                        <td style='padding:20px'>".$row['product_name']."</td>
                        <td style='padding:20px'>".$row['unit_price']."</td>
                        <td style='padding:20px'>".$row['qty']."</td>
                        <td style='padding:20px'>".$row['unit_price'] * $row['qty']."</td>
                    </tr>";
                
            }

            $bodyContent .= "</tbody></table>";

            $this->send_mail('kinidarshan07@gmail.com','Enquiry',$bodyContent);
        }
        

    }

    public function executeSql(){
        $enquiry = $this->AdminModel->getCustomerList('enquiry_master');

        foreach($enquiry as $e){
            $c_filter = array('mobile'=>$e['mobile']);
            $c_data   = $this->AdminModel->getDetails('customer',$c_filter);

            if($c_data){
                $add_customer = $c_data['id'];
                $filter = array('em.id'=>$e['enquiry_id']);
                $data   = array('customer_id'=>$add_customer);
                $this->AdminModel->update('enquiry_master em',$filter,$data);
            }else{
              $customer_data = array('name'   =>$e['name'],
                                   'mobile' =>$e['mobile'],
                                   'email'  =>$e['email'],
                                   'address'=>$e['address'],
                                   'created_at'=>date('Y-m-d h:i:s',strtotime($e['created_at']))
                               );
                $add_customer = $this->AdminModel->insert('customer',$customer_data);  
            }
            
        }
    }

    function send_mail($to,$subject,$bodyContent,$attachment = NULL) {
        

        $ci = & get_instance();
        $ci->load->library('email');
        $ci->email->from("naikjay75@gmail.com");
        $ci->email->to('naikjay75@gmail.com');
        $ci->email->cc('naikjay75@gmail.com');
        $ci->email->subject($subject);
        $ci->email->message($bodyContent);
        if($ci->email->send()){
            return  true;
        }else{
             return false;
        }
        

    } 


    public function saleList(){
        $this->load->view('sale_list');
    }
    public function getSaleList(){
        $data = $row = array();
        

        // Fetch member's records
        $memData = $this->AdminModel->getSaleDetailsRows($_POST);
         // echo $this->db->last_query();exit;
        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;

            $invoice = '<a href="'.base_url().'Order/orderDetails/'.$member->order_id.'">'.$member->order_id.'</a>';

            $print   = '<a href="'.base_url().'Order/invoice/'.$member->order_id.'"><i class="icon-printer"></i></a>';

            $address = wordwrap($member->address,15,"<br>\n");
            $data[] = array(
                            $i,
                            $invoice,
                            $member->name, 
                            $member->mobile,
                            $member->final_total,
                            date('d-m-Y h:i A',strtotime($member->created_at)),
                            $print
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

    public function file_check($str){
        $allowed_mime_type_arr = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain','application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
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


    

   

    public function sendMessage(){
        $this->form_validation->set_rules('ids','Ids','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('msg','Message','required|trim|xss_clean');
        if($this->form_validation->run()){
            $ids = $this->input->post('ids');
            $msg = $this->input->post('msg');
            
            
            $ids = explode(',',$ids);
            $ids = array_unique($ids);
            $ids = implode(',',$ids);

            // sent sms
            $username = urlencode("u_alphacore"); 
            $msg_token = urlencode("EEYN6t"); 
            $sender_id = urlencode("612324"); // optional (compulsory in transactional sms) 
            $message = urlencode($msg); 
            $mobile = urlencode($ids); 


            $api = "http://la-suit.vispl.in/api/send_promotional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile.""; 

            $response = file_get_contents($api);
            
            $data = json_decode($response,true);
            // sent sms

            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success'; 
        }else{
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }

        echo json_encode($returnArr);
    }

    public function sendBulkEmail(){

        $data['type'] = $this->input->post('type');
        $data['email'] = $this->input->post('email'); //email ids

        $this->form_validation->set_rules('subject','Subject','required|trim|xss_clean');
        $this->form_validation->set_rules('body','Email Body','required');
        if($this->form_validation->run()){
            $to         = $this->input->post('email');

            $from       = 'kinidarshan07@gmail.com';
            $subject    = $this->input->post('subject');
            $message    = $this->input->post('body');


            $send_mail  = $this->send_mail($to,$from,$subject,$message);

            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'success';
        }else{
             $returnArr['errCode'] = 3;
             foreach($this->input->post() as $key => $value){
                $returnArr['messages'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr); 

    }
    public function getEnquiryDetails(){
        $id = $this->uri->segment(3);
        $o_filter = array('em.id'=>$id);
        $data['enquiry'] = $this->AdminModel->getEnquiryMasterData($o_filter);

        $filter = array('enquiry_id'=>$id,'ed.status'=>'1');
        $data['enquiry_details'] = $this->AdminModel->getEnquiryDetails($filter);
        $this->load->view('enquiry_details',$data);
    }

    public function delete(){
        $id = $this->input->post('id');
        $table = $this->input->post('tablename');
        $type  = $this->input->post('type');

        $returnArr = delete($id,$table,$type);
        echo json_encode($returnArr); 
    }

    public function massDelete(){
        
        $ids = $this->input->post('ids');
        $table = $this->encryption->decrypt($this->input->post('tablename'));
        $type  = $this->input->post('type');
        $returnArr = massDelete($ids,$table,$type);
        echo json_encode($returnArr);
    }

    

}   
    