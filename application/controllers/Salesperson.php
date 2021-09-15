<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salesperson extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    //Banner
    public function salespersonList(){
        $filter = array('status'=>'1');
        $data['sales_person']  = $this->AdminModel->getList('suppliers',$filter);

        $this->load->view('supplier/supplier_list',$data);
    }
    public function addSupplier(){
        $this->form_validation->set_rules('name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('address','Address','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('mobile'=>$this->input->post('mobile'));

            $checkMenu = $this->AdminModel->getDetails('suppliers',$filter);
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

                    $addExperience = $this->AdminModel->insert('suppliers',$data);

                    if($addExperience){
                        $returnArr['errCode']     = -1;
                        $returnArr['message']  = 'Supplier Added Successfully';
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
    public function editSupplier(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $supplier = $this->AdminModel->getDetails('suppliers',$filter);
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
    public function updateSupplier(){
       $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
       $this->form_validation->set_rules('name','Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('mobile','Mobile','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('email','Email','required|trim|xss_clean|max_length[255]|valid_email');
        $this->form_validation->set_rules('address','Address','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'),
                            'mobile'=>$this->input->post('mobile'));

            $experience = $this->AdminModel->getDetails('suppliers',$filter);
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
                $updateMenu = $this->AdminModel->update('suppliers',$filter,$data);
                if($updateMenu){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']  = 'Supplier Updated Successfully';
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
    public function deleteSupplier(){
        if($this->session->userdata('logged_in')){
            $filter = array('id'=>$this->uri->segment(3));

            if($filter){    
                $data = array('status'=>'0');
                $update = $this->Package_model->update('supplier',$filter,$data);
                redirect(base_url().'Customer/supplierList');
            }else{
                redirect(base_url().'Customer/supplierList');
            }
        }else{
            $this->load->view('login');
        }
    }
   

}
