<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

   
    //coupen code system
    public function coupenList(){
        if($this->session->userdata('logged_in')){
            $filter = array('active'=>'1');
            $data['coupon'] = $this->AdminModel->getList('coupons',$filter);
            $this->load->view('coupon/coupenList',$data);
        }else{
            redirect(base_url().'Admin/logout');
        }
    }
    public function addCoupen(){ 



        $this->form_validation->set_rules('coupon_code','Coupon Code','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('type','Type','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('start_date','Start Date','required|trim|xss_clean');
        $this->form_validation->set_rules('expiry_date','Expiry Date','required|trim|xss_clean');
        $this->form_validation->set_rules('available_coupons','No Of Coupons','required|trim|xss_clean');
        $this->form_validation->set_rules('discount','Discount','required|trim|xss_clean');
        $this->form_validation->set_rules('max_discount','Max Discount','required|trim|xss_clean');
        $this->form_validation->set_rules('minimum_bill_amount','Minimum Bill Amount','required|trim|xss_clean');
        $this->form_validation->set_rules('active','Active','required|trim|xss_clean');
        $this->form_validation->set_rules('description','Description','required|trim|xss_clean');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();



            $data = array(  'coupon_code'   => $input_data['coupon_code'],
                            'start_date'    => date('Y-m-d',strtotime($input_data['start_date'])),
                            'expiry_date'      => date('Y-m-d',strtotime($input_data['expiry_date'])),
                            'type'          => $input_data['type'],
                            'discount'      => $input_data['discount'],
                            'max_discount'  => $input_data['max_discount'],
                            'description'   => $input_data['description'],
                            'available_coupons'          => $input_data['available_coupons'],
                            'minimum_bill_amount'      => $input_data['minimum_bill_amount'],
                            'active'        => $input_data['active'],
                            'description'   => $input_data['description']   
                            );

            $result = $this->AdminModel->insert('coupons',$data);
            if($result){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'Added Successfully';
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please try again';
            }
        }else{


            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['message'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }
    public function editCoupen(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean');
        if($this->form_validation->run()){
            $id = $this->input->post('id');

            $filter = array('id'=>$id);
            $result = $this->AdminModel->getDetails('coupons',$filter);

            $result['start_date'] = $result['start_date'] == NULL ? '' : date('d-m-Y',strtotime($result['start_date']));
            $result['expiry_date'] = $result['expiry_date'] == NULL ? '' : date('d-m-Y',strtotime($result['expiry_date']));

            $returnArr['errCode'] = -1;
            $returnArr['data']    = $result;
            
        }else{
            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['messages'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }
    public function updateCoupon(){ 
        $this->form_validation->set_rules('coupon_code','Coupon Code','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('type','Type','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('start_date','Start Date','required|trim|xss_clean');
        $this->form_validation->set_rules('expiry_date','Expiry Date','required|trim|xss_clean');
        $this->form_validation->set_rules('available_coupons','No Of Coupons','required|trim|xss_clean');
        $this->form_validation->set_rules('discount','Discount','required|trim|xss_clean');
        $this->form_validation->set_rules('max_discount','Max Discount','required|trim|xss_clean');
        $this->form_validation->set_rules('minimum_bill_amount','Minimum Bill Amount','required|trim|xss_clean');
        $this->form_validation->set_rules('active','Active','required|trim|xss_clean');
        $this->form_validation->set_rules('description','Description','required|trim|xss_clean');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
       if($this->form_validation->run()){
            $input_data = $this->input->post();

            $filter = array('id'=>$input_data['id']);
            $data = array(  'coupon_code'   => $input_data['coupon_code'],
                            'start_date'    => date('Y-m-d',strtotime($input_data['start_date'])),
                            'expiry_date'      => date('Y-m-d',strtotime($input_data['expiry_date'])),
                            'type'          => $input_data['type'],
                            'discount'      => $input_data['discount'],
                            'max_discount'  => $input_data['max_discount'],
                            'description'   => $input_data['description'],
                            'available_coupons'          => $input_data['available_coupons'],
                            'minimum_bill_amount'      => $input_data['minimum_bill_amount'],
                            'active'        => $input_data['active'],
                            'description'   => $input_data['description']   
                            );
            
            $result = $this->AdminModel->update('coupons',$filter,$data);
            if($result){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'Updated Successfully';
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please try again';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['messages'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }

}
