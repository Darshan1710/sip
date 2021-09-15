<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ImageController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('AdminModel');
    }

    public function gallery($id,$type) {
        
        $filter = array('status'=>'1','product_id'=>$id);
        if($type == '3'){
            $album_data = $this->AdminModel->getList('product_images',$filter);
        }else{
            $album_data = $this->AdminModel->getList('affiliate_images',$filter);
        }
        

        $data = array();
        if($album_data){
            $index = 0;
            foreach ($album_data as $row){

                    $data['images'][$index]['id']        = $row['id'];
                    $data['images'][$index]['thumbnail'] = $row['product_images'];
                    $index++;
            }
        }        
   
        $this->load->view('product/gallery', $data);
    }
    
     public function create_album() {
        $album_id = NULL;
        $input_data = $this->input->post();
        $filter = array('album_name'=>$input_data['album_name']);
        $album_exist = $this->AdminModel->check_album_exist($filter);
        if(empty($album_exist)) {
        $path = "assets/images/album";
        $album = $path . '/' . $input_data['album_name'];
        $album_thumbnail = $path . '/' . $input_data['album_name'];

        $album_data = array(
            'album_name' => $input_data['album_name']        );

        $album_id = $this->AdminModel->insert_album_data($album_data);
        $album = $path . '/' . $album_id;

        $album_thumbnail = $path . '/' . $album_id;
        mkdir($album, 0755, TRUE);
        // mkdir($album_thumbnail, 0755, TRUE);
        }
        if($album_id){
            $result = array('status'=>'true','album_id'=>$album_id);
        }else{
            $result = array('status'=>'false','album_id'=>'');
        }

        echo json_encode($result);
    }
    
    public function album_name_exist() {  
        $this->Admin_model->check_album_exist();
    }
    public function deleteAlbum(){
        $album_id = $this->uri->segment(3);
        $filter = array('album_id'=>$album_id);
        $album_details = $this->AdminModel->getPhotoList($filter);

        // if($album_details){
        //     foreach($album_details as $row){
        //         unlink('assets/images/album/'.$row['album_id'].'/'.$row['image']);    
        //     }    
        // }
        
        
        $deletePhoto = $this->AdminModel->deletePhoto($filter);

        // rmdir('assets/images/album/'.$album_id);

        $deleteAlbum = $this->AdminModel->deleteAlbum($filter);
        if($deletePhoto){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'Delete Successfully';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'Error Occur';
        }
        echo json_encode($returnArr);
    } 
    public function view_photos($album_id) {
        $data['album_id'] = $album_id;
        $filter = array('id' => $album_id);
        $album_data = $this->AdminModel->getDetails('package',$filter);
        if ($album_data) {
            $data['album_name'] = $album_data['name'];
        }
        $p_filter = array('package_id'=>$album_id);
        $data['photo_data'] = $this->AdminModel->getList('package_images',$p_filter);

        $this->load->view('product/viewPhoto', $data);
    }

    public function imageListView() {
        $data['data'] = $this->AdminModel->getImageDetails();
        $data['main_view'] = 'imageView';
        $this->load->view('base_template_admin', $data);
    }

    public function addImage() {
        $this->AdminModel->addImage();
    }

    public function deletePhoto() {

        $id = $this->input->post('id');
        $type = $this->input->post('type');

        $filter = array('id'=>$id);

        $data = array('status'=>'0');
        if($type == '3'){
            $photo_details = $this->AdminModel->getDetails('product_images',$filter);
            $deletePhoto = $this->AdminModel->update('product_images',$filter,$data);
        }else{
            $photo_details = $this->AdminModel->getDetails('affiliate_images',$filter);
            $deletePhoto = $this->AdminModel->update('affiliate_images',$filter,$data);
        }
        
        // unlink('.'.$photo_details['product_images']);
        

        
        if($deletePhoto){
            $returnArr['errCode'] = -1;
            $returnArr['message'] = 'Delete Successfully';
        }else{
            $returnArr['errCode'] = 2;
            $returnArr['message'] = 'Error Occur';
        }
        echo json_encode($returnArr);
    }
    public function upload_photo($album_id) {
        
        $type = $this->input->post('type');
        if($album_id){
            $filter = array('product_id'=>$album_id);
            if($type == 4){
                $images = $this->AdminModel->getList('affiliate_images',$filter);
            }else{
                $images = $this->AdminModel->getList('product_images',$filter);                
            }
            

            

            if(COUNT($images) < 8){
                $image_name = $this->input->post('file');
                if(!empty($_FILES['file']['name'])){

                    $extension = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);

                    $config['upload_path'] = './uploads';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['file_name'] = time().'.'.$extension;
                    $config['max_size'] = '10000';
                    $config['maintain_ratio'] = TRUE;
                    $config['width'] = 784;                
                    $config['height'] = 588;
                    $config['overwrite'] = TRUE;
                    $config['remove_spaces'] = TRUE;
                    
                    $this->load->library('upload', $config);

                         if (!$this->upload->do_upload('file'))
                        {
                            $error = array('error' => $this->upload->display_errors());  

                            $returnArr['error'] = 2;
                            $returnArr['message'] = $error;
                        }
                        else
                        {
                            $upload_data =$this->upload->data();

                            // $image_config['image_library'] = 'gd2';
                            // $image_config['source_image'] = './assets/images/album/' . $album_id . '/' . $upload_data['file_name'];
                            // $image_config['new_image'] = './assets/images/album/' . $album_id. '/' . $upload_data['file_name'];
                            // $image_config['create_thumb'] = TRUE;
                            // $image_config['thumb_marker'] = '_thumb';
                            // $image_config['maintain_ratio'] = TRUE;
                            // $image_config['width'] = 784;
                            // $image_config['height'] = 588;


                            // $this->load->library('image_lib', $image_config);
                            // $this->image_lib->resize();
                                
                                $filter = array('id'=>$album_id);
                                if($type == 4){
                                    $products = $this->AdminModel->getDetails('affiliate_products',$filter);
                                }else{
                                    $products = $this->AdminModel->getDetails('products',$filter);    
                                }
                                

                                if($products['product_type'] == '2'){
                                    $s_filter = array('parent_id'=>$album_id);
                                    $subproducts = $this->AdminModel->getList('product_attribute_values',$s_filter);


                                    foreach($subproducts as $s){
                                            
                                        $image_filter = array('product_id'=>$s['product_id']);
                                        $image = $this->AdminModel->getDetails('product_images',$image_filter);

                                        // if(empty($image)){ 
                                            $data = array(
                                                'product_images' => '/uploads/'.$config['file_name'],
                                                'product_id' => $s['product_id'],
                                                'status'     =>'1'
                                             );

                                            $this->AdminModel->insert('product_images',$data);    
                                        // }
                                        
                                    }
                                }
                                
                                $data = array(
                                    'product_images' => '/uploads/'.$config['file_name'],
                                    'product_id' => $album_id,
                                    'status'     =>'1'
                                 );
                                
                                


                                if($this->input->post('type') == '3'){
                                    $this->AdminModel->insert('product_images',$data);
                                }else{
                                    $this->AdminModel->insert('affiliate_images',$data);
                                }
                                 

                                $returnArr['error'] = -1;
                                $returnArr['message'] = 'Success';
                        }
                    }else{
                        $returnArr['error'] = 2;
                        $returnArr['message'] = 'Please Select File';
                    }

            }else{
                $returnArr['error'] = 2;
                $returnArr['message'] = 'Image limit exceed';
            }
        }else{
            $returnArr['error']   = 2;
            $returnArr['message'] = 'Package Not found';
        }

        echo json_encode($returnArr);
        
    }
    public function getImageDetails(){
        $id       = $this->input->post('id');
        $filter   = array('id'=>$id);

        $type     = $this->input->post('type');
        if($type == '3'){
            $imageDetails = $this->AdminModel->getDetails('product_images',$filter);
        }else{
            $imageDetails = $this->AdminModel->getDetails('affiliate_images',$filter);
        }
        

        if($imageDetails){
            $returnArr['errCode'] = -1;
            $returnArr['data']    = $imageDetails;
          }else{
            $returnArr['errCode'] = 2;
            $returnArr['data']    = 'No data';
        }
        echo json_encode($returnArr);
    }

    public function updateImageDetails(){

        $this->form_validation->set_rules('photo_id','Photo Id','required|trim|xss_clean|numeric');
        if($this->form_validation->run()){
            $photo_id = $this->input->post('photo_id');
            $image    = $this->input->post('old_image');
            $type     = $this->input->post('type');

            $filter = array('id'=>$photo_id);
            if($type == '3'){
                $imageDetails = $this->AdminModel->getDetails('product_images',$filter);
            }else{
                $imageDetails = $this->AdminModel->getDetails('affiliate_images',$filter);
            }
            


            if($_FILES){
                    $config['upload_path']      = './uploads/';
                    $config['allowed_types']    = 'gif|jpg|png|jpeg';
                    $config['file_name']        = time();
                    $config['max_size']         = '10000';
                    $config['maintain_ratio']   = TRUE;
                    $config['width']            = 784;                
                    $config['height']           = 588;
                    $config['overwrite']        = TRUE;
                    $config['remove_spaces']    = TRUE;
                    
                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('files'))
                    {
                        $error = array('error' => $this->upload->display_errors());  
                        $returnArr['errCode'] = 2;
                        $returnArr['message'] = $error['error'];
                    }
                    else
                    {
                        $returnArr['errCode'] = -1;
                        $returnArr['message'] =  'Success';

                          
                        $upload_data =$this->upload->data();

                       
                        $filter = array('id'=>$photo_id);
                        $data = array(
                            'product_images'     => '/uploads/'.$upload_data['file_name']
                         );

                        if($type == '3'){
                            $this->AdminModel->update('product_images',$filter,$data); 
                        }else{
                            $this->AdminModel->update('affiliate_images',$filter,$data);
                        }
                }
            }

        }else{
            $returnArr['errCode'] = 2;
            foreach ($this->input->post() as $key => $value) {
                $returnArr['message'] = form_error($key);
            }
        }
        echo json_encode($returnArr);
    }

    public function videoGallery(){
        $data['result']    = $this->AdminModel->getVideos();
        $data['main_view'] = 'video_gallery';
        $this->load->view('base_template_admin', $data);
    }
    public function addVideo(){
        if($this->session->userdata('logged_in')){
            $this->form_validation->set_rules('video','Video URL','required|trim|max_length[255]');
            if($this->form_validation->run()){
                $video = $this->input->post('video');

                $url_array = explode('=',$video);
                $data = array('video'=>end($url_array));

                $add_video = $this->AdminModel->addVideo($data);
                redirect(base_url().'ImageController/videoGallery');
            }else{  
                $data['main_view'] = 'video_gallery';
                $this->load->view('base_template_admin', $data);           
            }
        }else{
            redirec(base_url());
        }
    }
    
    
     

}
