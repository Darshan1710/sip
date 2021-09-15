<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deliveryzone extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

   
    //delivery zone
    public function deliveryZoneList(){
        $filter = array('status'=>'1');
        $data['delivery_zone']  = $this->AdminModel->getList('delivery_zone',$filter);
        $this->load->view('delivery_zone_list',$data);
    }
    public function addDeliveryZone(){
        $this->form_validation->set_rules('name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('name'=>$this->input->post('name'));

            $checkMenu = $this->AdminModel->getDetails('delivery_zone',$filter);
            if($checkMenu){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['mobile']      = '<p class="error">Zone Already Exists</p>';
            }else{  

                    $data = array('name'            =>$this->input->post('name'),
                                  'status'          =>$this->input->post('status')
                              );

                    $addExperience = $this->AdminModel->insert('delivery_zone',$data);

                    if($addExperience){
                        $returnArr['errCode']     = -1;
                        $returnArr['message']  = 'Delivery Zone Added Successfully';
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
    public function editDeliveryZone(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $supplier = $this->AdminModel->getDetails('delivery_zone',$filter);
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
    public function updateDeliveryZone(){
       $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
       $this->form_validation->set_rules('name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'),
                            'name'=>$this->input->post('delivery_zone'));

            $experience = $this->AdminModel->getDetails('delivery_zone',$filter);
            if($experience){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['product']      = '<p class="error">Delivery Zone Already Exists</p>';
            }else{
                $filter     = array('id'=>$this->input->post('id'));
                 $data = array('name'            =>$this->input->post('name'),
                              'status'          =>$this->input->post('status')
                          );
                $updateMenu = $this->AdminModel->update('delivery_zone',$filter,$data);
                if($updateMenu){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']  = 'Delivery Zone Updated Successfully';
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
    public function deleteDeliveryZone(){
        if($this->session->userdata('logged_in')){
            $filter = array('id'=>$this->uri->segment(3));

            if($filter){    
                $data = array('status'=>'0');
                $update = $this->Package_model->update('delivery_zone',$filter,$data);
                redirect(base_url().'Customer/deliveryZoneList');
            }else{
                redirect(base_url().'Customer/deliveryZoneList');
            }
        }else{
            $this->load->view('login');
        }
    }
   

}
