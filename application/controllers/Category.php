<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function categoryList(){
        $data['category'] = $this->AdminModel->getList('categories');
        $this->load->view('category/category',$data);
    }
    public function addCategory(){
        $this->form_validation->set_rules('category','Category','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('file','','callback_file_check');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('category_name'=>$this->input->post('category'));

            $checkMenu = $this->AdminModel->getDetails('categories',$filter);
            if($checkMenu){
                    $returnArr['errCode']                   = 3;
                    $returnArr['messages']['category']      = '<p class="error">Products Already Exists</p>';
            }else{  
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

                    $data = array('category_name'   =>$this->input->post('category'),
                                  'category_icon'   =>$image,
                                  'status'          =>$this->input->post('status')
                              );

                    $addExperience = $this->AdminModel->insert('categories',$data);

                    if($addExperience){
                        $returnArr['errCode']     = -1;
                        $returnArr['message']  = 'Category Added Successfully';
                    }else{
                        $returnArr['errCode']     = 2;
                        $returnArr['message']  = 'Please try again';
                    }
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
    public function editCategory(){
        $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id'=>$this->input->post('id'));

            $category = $this->AdminModel->getDetails('categories',$filter);
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
    public function updateCategory(){
       $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[255]');
       $this->form_validation->set_rules('category','Category Name','required|trim|xss_clean|max_length[255]');
        $this->form_validation->set_rules('status','Status','required|trim|xss_clean|max_length[255]');
        if($this->form_validation->run()){
            $filter = array('id !='=>$this->input->post('id'),
                            'category_name'=>$this->input->post('categories'));

            $experience = $this->AdminModel->getDetails('categories',$filter);
            if($experience){
                    $returnArr['errCode']               = 3;
                    $returnArr['messages']['product']      = '<p class="error">Category Already Exists</p>';
            }else{
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
                 $data = array('category_name'   =>$this->input->post('category'),
                               'category_icon'   =>$image,
                               'status'          =>$this->input->post('status')
                              );
                $updateMenu = $this->AdminModel->update('categories',$filter,$data);
                if($updateMenu){
                    $returnArr['errCode']     = -1;
                    $returnArr['message']     = 'Category Updated Successfully';
                }else{
                    $returnArr['errCode']     = 2;
                    $returnArr['message']     = 'Please try again';
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

    public function deleteCategory(){
        $id = $this->uri->segment(3);
        if($id){
            $filter = array('id'=>$id);
            $data   = array('status'=>'0');

            $update = $this->AdminModel->update('categories',$filter,$data);

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
