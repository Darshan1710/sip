<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Advertise extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function advertiseList(){
        $data['advertise'] = $this->AdminModel->getList('advertises');
        $this->load->view('advertise/advertise',$data);
    }
    public function addAdvertise(){
        $this->form_validation->set_rules('file','','callback_file_check');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
 
            if(isset($_FILES)){
                $upload = upload_image($_FILES,'file');

                if($upload['errCode'] == -1){
                    $image = $upload['image'];
                }else{
                    $returnArr['errCode']      = 3;
                    $returnArr['message']['image']      = $upload['image'];
                    echo json_encode($returnArr);exit;
                }
            }else{
                $image = '';
            }

            $data = array(
                          'image'             =>$image,
                          'status'          =>$this->input->post('status')
                      );

            $addExperience = $this->AdminModel->insert('advertises',$data);

            if($addExperience){
                $returnArr['errCode']     = -1;
                $returnArr['message']  = 'Advertise Added Successfully';
            }else{
                $returnArr['errCode']     = 2;
                $returnArr['message']  = 'Please try again';
            }
           
        }else{
            $returnArr['errCode'] = 3;

            $returnArr['message']['file'] = form_error('file');
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'][$key] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }
    public function editAdvertise(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $category = $this->AdminModel->getDetails('advertises',$filter);
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
    public function updateAdvertise(){
       $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){

                if(isset($_FILES) && !empty($_FILES)){
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

                $filter     = array('id'=>$this->input->post('id'));
                 $data = array(
                               'image'          =>$image,
                               'status'          =>$this->input->post('status')
                              );
                $updateMenu = $this->AdminModel->update('advertises',$filter,$data);
                if($updateMenu){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']     = 'Advertise Updated Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']     = 'Please try again';
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

    public function deleteAdvertise(){
        $id = $this->uri->segment(3);
        if($id){
            $filter = array('id'=>$id);
            $data   = array('status'=>'0');

            $update = $this->AdminModel->update('advertises',$filter,$data);

            if($update){
                $returnArr['error'] = false;
                $returnArr['message'] = 'Delete Successfully';
            }else{
                $returnArr['error'] = true;
                $returnArr['message'] = 'Please trya again';
            }
        }else{
            $returnArr['error'] = true;
            $returnArr['message'] = 'Id is required';
        }
        echo json_encode($returnArr);

    }

}
