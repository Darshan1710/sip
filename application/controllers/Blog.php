<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function blogList() {
        $filter            = array('status'=>'1');
        $data['blog']      = $this->AdminModel->getList('blogs',$filter);
        $this->load->view('blog/blogList', $data);
    }

    public function getBlogListDetails(){

         $data = $row = array();



        // Fetch member's records
        $memData = $this->AdminModel->getBlogDetailsRows($_POST);
        

        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;

            $image = '<img src="'.$m = !empty($member->image) ? $member->image : 'https://thumbs.dreamstime.com/b/no-image-available-icon-photo-camera-flat-vector-illustration-132483141.jpg'.'" width="50px" height="50px">';

            if($member->status == 2){
              $status = '<button class="btn btn-danger btn-sm">Inactive</button>';
            }else{
              $status = '<button class="btn btn-success btn-sm">Active</button>';
            }

            $action = '<td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="'.base_url().'Blog/editBlog/'.$member->id.'"  ><i class="icon-file-excel"></i> Edit</a></li>
                                    <li><a  id="'.$member->id.'" class="delete" data-table="'.$hash = $this->encryption->encrypt('blogs').'"><i class="icon-file-excel"></i> Delete</a></li>
                                </ul>
                            </li>
                        </ul>
                    </td>';


            $data[] = array($member->id,
                            $member->title, 
                            $image,
                            $member->post_by,
                            date('d-m-Y h:i A',strtotime($member->date)),
                            $status,
                            $action
                        );
        }


        //echo $this->db->last_query();exit;
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AdminModel->countAllBlogDetails(),
            "recordsFiltered" => $this->AdminModel->countFilteredBlogDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);

    }
    public function blogForm() {
        if($this->session->userdata('logged_in')){
            $filter    = array('status'=>'1');
            $data['main_view'] = 'blogForm';
            $this->load->view('blog/blogForm',$data);
        }else{
            redirect(base_url());
        }
    }

    
    public function addBlog() {



            $this->form_validation->set_rules('title','Title','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('post_by','Post By','required|xss_clean|max_length[255]');
            $this->form_validation->set_rules('date','Date','required');
            $this->form_validation->set_rules('status','Status','required|xss_clean|max_length[255]');
            $this->form_validation->set_rules('file','','callback_file_check');
            $this->form_validation->set_rules('description','Description','required');
            if($this->form_validation->run()){
                
                $title    = $this->input->post('title');
                $post_by  = $this->input->post('post_by');
                $status   = $this->input->post('status');
                $description   = $this->input->post('description');
                $date   = $this->input->post('date');

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



                $blog = array(
                              'title'   =>$title,
                              'post_by' =>$post_by,
                              'date'    =>date('Y-m-d h:i:s',strtotime($date)),
                              'image'   =>$image,
                              'description'   =>$description,
                              'status'  =>$status
                          );

                $addBlog = $this->AdminModel->insert('blogs',$blog);

                if($addBlog){
                    $returnArr['errCode'] = -1;
                    $returnArr['message'] = 'success';
                }else{
                    $returnArr['errCode'] = 2;
                    $returnArr['message'] = 'Please try again'; 
                }
            }else{

                $returnArr['errCode'] = 3;

                foreach ($this->input->post() as $key => $value) {
                    $returnArr['message'][$key] = form_error($key);
                }
            }
            echo json_encode($returnArr);
    }

    public function editBlog(){
        if($this->session->userdata('logged_in')){
            $data['id'] = $this->uri->segment(3);
            $this->form_validation->set_data($data);
            $this->form_validation->set_rules('id','Id','required|trim|xss_clean|max_length[11]|numeric');
            if($this->form_validation->run()){
                $id     = $this->uri->segment(3);
                $filter = array('id'=>$id);
                $blog = $this->AdminModel->getDetails('blogs',$filter);
                if($blog){
                    $c_filter           = array('status'=>'1');
                    $data['blog']       = $blog;
                    $data['main_view']  = 'editBlog';
                    $this->load->view('blog/editBlog',$data);
                }else{
                    redirect(base_url('blog/blogList'));
                }
            }else{
                redirect(base_url('blog/blogList'));
            }
        }else{
            redirect(base_url());
        }
    }

    public function updateBlog() {

        if($this->session->userdata('logged_in')){
            $this->form_validation->set_rules('title','Title','required|trim|xss_clean|max_length[255]');
            $this->form_validation->set_rules('post_by','Post By','required|xss_clean|max_length[255]');
            $this->form_validation->set_rules('date','Date','required');
            $this->form_validation->set_rules('status','Status','required|xss_clean|max_length[255]');
            $this->form_validation->set_rules('description','Description','required');
            if($this->form_validation->run()){
                $blog_id  = $this->input->post('id');
                $title    = $this->input->post('title');
                $post_by    = $this->input->post('post_by');
                $date    = $this->input->post('date');
                $description  = $this->input->post('description');
                $status  = $this->input->post('status');

                if(isset($_FILES['image']['name']) && !empty($_FILES)){
                    $upload = upload_image($_FILES,'image');

                    if($upload['errCode'] == -1){
                        $image = $upload['image'];
                    }else{
                        $returnArr['errCode']      = 3;
                        $returnArr['message']['image']      = $upload['image'];
                        echo json_encode($returnArr);exit;
                    }
                }else{
                    $image = $this->input->post('old_image');
                }

                $blog = array(
                              'title'   =>$title,
                              'post_by' =>$post_by,
                              'date'    =>date('Y-m-d h:i:s',strtotime($date)),
                              'image'   =>$image,
                              'description'   =>$description,
                              'status'  =>$status
                          );

                $filter     = array('id'=>$blog_id);
                $updateBlog = $this->AdminModel->update('blogs',$filter,$blog);

                if($updateBlog){
                    $returnArr['errCode'] = -1;
                    $returnArr['message'] = 'success';
                }else{
                    $returnArr['errCode'] = 2;
                    $returnArr['message'] = 'failed';    
                }
            }else{
               $returnArr['errCode'] = 3;
               foreach($this->input->post() as $key => $value){
                    $returnArr['message'][$key] = form_error($key);
               }
            }
        }else{
            $returnArr['errCode'] = 4;
            $returnArr['message'] = 'Session is expired'; 
        }

        echo json_encode($returnArr);
    }



    public function deleteBlog(){
        $id = $this->uri->segment(3);
        if($id){
            $filter = array('id'=>$id);
            $data   = array('status'=>'0');
            $table_name = 'blogs';
            $update = $this->AdminModel->update($table_name,$filter,$data);

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

    public function file_check($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png','image/jpg');
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
