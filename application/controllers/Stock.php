<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    //Banner
    public function stockList(){
        if($this->session->userdata('logged_in')){

            $p_filter = array('status','1');
            $data['products']  = $this->AdminModel->getList('products',$p_filter);

            $this->load->view('stock/stock',$data);
        }else{
            redirect(base_url().'Admin/logout');
        }
    }
    public function getStockListDetails(){
        $data = $row = array();
        
        // Fetch member's records
        $memData = $this->AdminModel->getStockDetailsRows($_POST);
        
        $i = $_POST['start'];
        foreach($memData as $member){

            $i++;
                                       
                                    
            $action = '<td class="text-center">
                        <ul class="icons-list">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="#" class="edit" id="'.$member->id.'" data-toggle="modal" data-target="#edit_modal" ><i class="icon-file-pdf"></i> Add Stock</a></li>
                                </ul>
                            </li>
                        </ul>
                        </td>';

        $image = '<img src="'.base_url().$member->image.'" width="50px" height="50px">';

        $data[] = array($i,
                        $action,
                        $image,
                        $member->product_name,
                        $member->packaging_size,
                        $member->stock_in,
                        $member->stock_out,
                        $member->remaning_stock,
                        date('d-m-Y h:i A',strtotime($member->created_at))
                    );
        }



        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AdminModel->countAllStockDetails(),
            "recordsFiltered" => $this->AdminModel->countFilteredStockDetails($_POST),
            "data" => $data,
        );  
        
        // Output to JSON format
        echo json_encode($output);
    }
    public function editStock(){


            $s_filter = array('p.id'=>$this->input->post('id'));
            $stock = $this->AdminModel->getStockDetails($s_filter);
            // echo $this->db->last_query();exit;
            if($stock){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = $stock;
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = '';
            }
            echo json_encode($returnArr);

    }
    public function updateStock(){ 
        $this->form_validation->set_rules('product_id','Product Id','required|trim|xss_clean');
        $this->form_validation->set_rules('stock','Title','trim|xss_clean|max_length[255]');
        $this->form_validation->set_error_delimiters('<p class="error">','</p>');
        if($this->form_validation->run()){
            $input_data = $this->input->post();

            $s_filter = array('product_id'=>$this->input->post('product_id'));
            $stock_details = $this->AdminModel->getDetails('stocks',$s_filter);


            if($stock_details){
                
                $stock = $this->input->post('stock');
                $remaning_stock = $stock_details['remaning_stock'];
                $stock_in = $stock_details['stock_in'];


                $stock_data = array('stock_in'=>$stock_in + $stock,
                                    'remaning_stock'=>$remaning_stock + $stock
                                    );
                
                

                $update = $this->AdminModel->update('stocks',$s_filter,$stock_data);
            }else{

                $stock_data = array('product_id' =>$this->input->post('product_id'),
                                    'stock_in'=>$this->input->post('stock'),
                                    'remaning_stock'=>$this->input->post('stock')
                                    );
                
            
                $update = $this->AdminModel->insert('stocks',$stock_data);
            }
            

            if($update){
                $returnArr['errCode'] = -1;
                $returnArr['message'] = 'Added Successfully';
            }else{
                $returnArr['errCode'] = 2;
                $returnArr['message'] = 'Please try again';
            }
        }else{

            $returnArr['message']['file'] = form_error('file');
            $returnArr['errCode'] = 3;
            foreach($this->input->post() as $key => $value){
                    $returnArr['message'][$key] = form_error($key);
                }
            }
        echo json_encode($returnArr);   
    }

}
// k