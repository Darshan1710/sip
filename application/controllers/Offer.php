<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function offerList(){
        $filter = array('status'=>'1');
        $data['offer_list'] = $this->AdminModel->getList('home_offers',$filter);
        $this->load->view('offer/offer_list',$data);
    }
    public function offerForm(){
        $filter = array('status'=>'1','active'=>'1');
        $data['products'] = $this->AdminModel->getList('products',$filter);
        $this->load->view('offer/offer_form',$data);
    }
    public function addoffer(){
        $this->form_validation->set_rules('product_id','Product Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('file','','callback_file_check');
        $this->form_validation->set_rules('offer_title','Offer Title','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('description','Description','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('home_section','Home Section','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('deal_expiry','Deal Expiry','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');

        if($this->form_validation->run()){
    

                     if(isset($_FILES)){
                        $upload = upload_image($_FILES,'file');

                        if($upload['errCode'] == -1){
                            $image = $upload['image'];
                        }else{
                            $returnArr['errCode']      = 3;
                            $returnArr['messages']['image']      = $upload['image'];
                            echo json_encode($returnArr);exit;
                        }
                    }else{
                        $image = '';
                    }

                    $data = array('product_id'      =>$this->input->post('product_id'),
                                  'offer_image'     =>$image,
                                  'offer_title'     =>$this->input->post('offer_title'),
                                  'offer_description'  =>$this->input->post('description'),
                                  'home_section'   =>$this->input->post('home_section'),
                                  'status'          =>$this->input->post('status'),
                                  'deal_expiry'     =>$this->input->post('deal_expiry')
                              );

                    $add = $this->AdminModel->insert('home_offers',$data);


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
    public function editOffer(){
        $id = $this->uri->segment(3);
        $filter = array('id'=>$id);
        $filter = array('status'=>'1');
        $data['products'] = $this->AdminModel->getList('products',$filter);
        $data['offer'] = $this->AdminModel->getDetails('home_offers',$filter);

        $this->load->view('offer/edit_offer',$data);
    }
    public function updateoffer(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('product_id','Product Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('offer_title','Offer Title','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('description','Description','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('home_section','Home Section','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('deal_expiry','Deal Expiry','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('description','Description','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
    

                    if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name'])){
                        $upload = upload_image($_FILES,'file');

                        if($upload['errCode'] == -1){
                            $image = $upload['image'];
                        }else{
                            $returnArr['errCode']      = 3;
                            $returnArr['messages']['image']      = $upload['image'];
                            echo json_encode($returnArr);exit;
                        }
                    }else{
                        $image = $this->input->post('old_image');
                    }

                    $filter = array('id'=>$this->input->post('id'));

                    $data = array('product_id'      =>$this->input->post('product_id'),
                                  'offer_image'     =>$image,
                                  'offer_title'     =>$this->input->post('offer_title'),
                                  'offer_description'  =>$this->input->post('description'),
                                  'home_section'   =>$this->input->post('home_section'),
                                  'status'          =>$this->input->post('status'),
                                  'deal_expiry'     =>$this->input->post('deal_expiry')
                              );

                    $add = $this->AdminModel->update('home_offers',$filter,$data);


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

}
