<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deliveryboy extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function deliveryBoyList(){
        $filter = array('status'=>'1');
        $data['delivery_boy']  = $this->AdminModel->getList('delivery_boy',$filter);
        $this->load->view('delivery_boy_list',$data);
    }
    public function addDeliveryBoy(){
        $this->form_validation->set_rules('name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('address','Address','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('mobile'=>$this->input->post('mobile'));

            $checkMenu = $this->AdminModel->getDetails('delivery_boy',$filter);
            if($checkMenu){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['mobile']      = '<p class="error">Mobile Number Already Exists</p>';
            }else{  

                    $data = array('name'            =>$this->input->post('name'),
                                  'email'           =>$this->input->post('email'),
                                  'mobile'          =>$this->input->post('mobile'),
                                  'address'         =>$this->input->post('address'),
                                  'status'          =>$this->input->post('status')
                              );

                    $addExperience = $this->AdminModel->insert('delivery_boy',$data);

                    if($addExperience){
                        $returnArr['errCode']     = -1;
                        $returnArr['message']  = 'Delivery Boy Added Successfully';
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
    public function editDeliveryBoy(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $supplier = $this->AdminModel->getDetails('delivery_boy',$filter);
            if($supplier){
                $returnArr['errCode']      = -1;
                $returnArr['data']         = $supplier;
            }else{
                $returnArr['errCode']     = 2;
                $returnArr['data']        = 'No data found';
            }
        }else{
            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function updateDeliveryBoy(){
       $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
       $this->form_validation->set_rules('name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('address','Address','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'),
                            'mobile'=>$this->input->post('mobile'));

            $experience = $this->AdminModel->getDetails('delivery_boy',$filter);
            if($experience){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['product']      = '<p class="error">Supplier Already Exists</p>';
            }else{
                $filter     = array('id'=>$this->input->post('id'));
                 $data = array('name'            =>$this->input->post('name'),
                              'email'           =>$this->input->post('email'),
                              'mobile'          =>$this->input->post('mobile'),
                              'address'         =>$this->input->post('address'),
                              'status'          =>$this->input->post('status')
                          );
                $updateMenu = $this->AdminModel->update('delivery_boy',$filter,$data);
                if($updateMenu){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']  = 'Delivery Boy Updated Successfully';
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
    public function deleteDeliveryBoy(){
        if($this->session->userdata('logged_in')){
            $filter = array('id'=>$this->uri->segment(3));

            if($filter){    
                $data = array('status'=>'0');
                $update = $this->Package_model->update('delivery_boy',$filter,$data);
                redirect(base_url().'Customer/deliveryBoyList');
            }else{
                redirect(base_url().'Customer/deliveryBoyList');
            }
        }else{
            $this->load->view('login');
        }
    }
   

}
