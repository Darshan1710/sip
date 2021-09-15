<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pincode extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    //coupen code system
    public function pincodeList(){
        if($this->session->userdata('logged_in')){
            $filter = array('status'=>'1');
            $data['pincode'] = $this->AdminModel->getList('pincodes',$filter);
            $this->load->view('pincode/pincode_list',$data);
        }else{
            redirect(base_url().'Admin/logout');
        }
    }
    public function addPincode(){ 
        $this->form_validation->set_rules('pincode','Pincode','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('shipping_rate','Shipping Rate','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();

            $data = array('pincode'        => $input_data['pincode'],
                          'shipping_rate'  => $input_data['shipping_rate'],
                          'status'         => $input_data['status'],   
                            );

            $result = $this->AdminModel->insert('pincodes',$data);
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
    public function editPincode(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean');
        if($this->form_validation->run()){
            $id = $this->input->post('id');

            $filter = array('id'=>$id);
            $result = $this->AdminModel->getDetails('pincodes',$filter);


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
    public function updatePincode(){ 
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('pincode','Pincode','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('shipping_rate','Shipping Rate','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
       if($this->form_validation->run()){
            $input_data = $this->input->post();

            $p_filter = array('pincode' =>$input_data['pincode'],'id !='=>$input_data['id']);
            $pincode_data = $this->AdminModel->getDetails('pincodes',$p_filter);

            if(!$pincode_data){
                $filter = array('id'     =>$input_data['id']);
                $data =   array('pincode'=> $input_data['pincode'],
                                'shipping_rate'=>$input_data['shipping_rate'],
                                'status' =>$input_data['status']
                            );
                
                $result = $this->AdminModel->update('pincodes',$filter,$data);
                if($result){
                    $returnArr['errCode'] = -1;
                    $returnArr['message'] = 'Updated Successfully';
                }else{
                    $returnArr['errCode'] = 2;
                    $returnArr['message'] = 'Please try again';
                }
            }else{
                $returnArr['errCode'] = 3;
                $returnArr['message'] = 'Pincode shipping rate already exists';
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
