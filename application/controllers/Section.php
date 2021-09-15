<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    //coupen code system
    public function sectionList(){
        if($this->session->userdata('logged_in')){
            $filter = array('status'=>'1');
            $data['section'] = $this->AdminModel->getList('home_sections',$filter);
            $this->load->view('section_list',$data);
        }else{
            redirect(base_url().'Admin/logout');
        }
    }
    public function addSection(){ 
        $this->form_validation->set_rules('section','Section','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();

            $data = array(  'title'        => $input_data['section']   
                            );

            $result = $this->AdminModel->insert('home_sections',$data);
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
    public function editSection(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean');
        if($this->form_validation->run()){
            $id = $this->input->post('id');

            $filter = array('id'=>$id);
            $result = $this->AdminModel->getDetails('home_sections',$filter);


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
    public function updateSection(){ 
        $this->form_validation->set_rules('section','Section','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
       if($this->form_validation->run()){
            $input_data = $this->input->post();

            $filter = array('id'=>$input_data['id']);
            $data = array(  'title'        => $input_data['section']
                            );
            
            $result = $this->AdminModel->update('home_sections',$filter,$data);
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
