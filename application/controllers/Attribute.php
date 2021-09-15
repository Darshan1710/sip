<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function attributeList(){
        $filter = array('status'=>'1');
        $data['attribute_list'] = $this->AdminModel->getList('product_attribute',$filter);
        $this->load->view('attribute/attribute',$data);
    }
    public function addAttribute(){
        $this->form_validation->set_rules('attribute','Attribute','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('values','values','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');

        if($this->form_validation->run()){

                    $data = array('attribute'      =>$this->input->post('attribute'),
                                  'status'          =>$this->input->post('status'),
                                  'values'          =>$this->input->post('values')
                              );

                    $add = $this->AdminModel->insert('product_attribute',$data);


                    if($add){
                        $returnArr['errCode']       = -1;
                        $returnArr['message']       = 'success';
                    }else{  
                        $returnArr['errCode']       = 2;
                        $returnArr['message']       = 'Please try again';
                    }
 
        }else{

            $returnArr['errCode'] = 3;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
            $returnArr['message']['file'] = form_error('file');
        }
        echo json_encode($returnArr);
    }
    public function editAttribute(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $category = $this->AdminModel->getDetails('product_attribute',$filter);
            if($category){
                $returnArr['errCode']      = -1;
                $returnArr['data']         = $category;
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
    public function updateAttribute(){
       $this->form_validation->set_rules('attribute','Attribute','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('values','values','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');

        if($this->form_validation->run()){
    

                    $filter = array('id'=>$this->input->post('id'));

                     $data = array('attribute'      =>$this->input->post('attribute'),
                                  'status'          =>$this->input->post('status'),
                                  'values'          =>$this->input->post('values')
                              );

                    $add = $this->AdminModel->update('product_attribute',$filter,$data);


                    if($add){
                        $returnArr['errCode']       = -1;
                        $returnArr['message']       = 'success';
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


}
