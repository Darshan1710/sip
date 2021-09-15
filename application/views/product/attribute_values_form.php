<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo TITLE; ?></title>

  <!-- Global stylesheets -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>css/core.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>css/components.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>css/colors.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>css/custom.css" rel="stylesheet" type="text/css">
  <link href="<?php echo base_url() ?>css/jquery-ui.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->

  <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
  <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>

  <!-- /core JS files -->

  <script src="<?php echo base_url ()?>js/plugins/ui/moment/moment.min.js"></script>

   <script src="<?php echo base_url() ?>js/core/libraries/jquery_ui/interactions.min.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>

  <script src="<?php echo base_url() ?>js/app.js"></script>
  <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>
  <script src="<?php echo base_url() ?>js/custom.js"></script>


  <!-- /theme JS files -->

</head>

<body>

  <!-- Main navbar -->
<?php $this->load->view('common/navbar'); ?>
  <!-- /main navbar -->


  <!-- Page container -->
  <div class="page-container">

    <!-- Page content -->
    <div class="page-content">

      <!-- Main sidebar -->
      <?php $this->load->view('common/sidebar'); ?>
      <!-- /main sidebar -->


      <!-- Main content -->
      <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-default">


          <div class="breadcrumb-line">
            <ul class="breadcrumb">
              <li><a href="<?php echo base_url() ?>Admin/dashboard"><i class="icon-home2 position-left"></i> Home</a></li>
              <li><a href="#">Order</a></li>
              <li class="active">Add Order</li>
            </ul>

          </div>
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-flat">

                <div class="panel-body">
         

                  <legend class="text-semibold">Product Variant Information</legend>
                  <div class="error-div">
                    </div>
                    <form method="post" action="#" id="add">
                  <?php 

                  if(isset($order_details)){
                    $count = COUNT($order_details);
                  }else{
                    $count = 1;
                  } ?>
                  <input class="hidden_count"  name="hidden_count" value="<?php echo $count; ?>" id="hidden_count" type="hidden">
                  <input type="hidden" name="id" value="<?php if($this->uri->segment(3) != ''){ echo $this->uri->segment(3); }else{ echo 'new'; } ?>">
                  
                  
                  <?php if(isset($attributes) && !empty($attributes)){?>
                    <div class="row clone-div">
                    <?php $i = 1;
                    foreach($attributes as $row){?>  
                    
                    <div class="row <?php echo $i; ?>">
                    
                    <input type="hidden" name="attribute_id[]" class="form-control" value="<?php echo set_value('attribute_id',isset($row['attribute_id']) ? $row['attribute_id'] : '')?>"  id="attribute_id_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                    <input type="hidden" name="product_id[]" class="form-control" value="<?php echo set_value('product_id',isset($row['product_id']) ? $row['product_id'] : '')?>"  id="product_id_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Packaging Size</label>
                          <input type="text" name="packaging_size[]" class="form-control" placeholder="Packaging Size" value="<?php echo set_value('packaging_size',isset($row['packaging_size']) ? $row['packaging_size'] : '')?>"  id="packaging_size_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>MRP</label>
                          <input type="number" name="mrp[]" class="form-control" placeholder="MRP" value="<?php echo set_value('mrp',isset($row['unit_price']) ? $row['unit_price'] : '')?>"  id="mrp_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Sell Price</label>
                          <input type="number" name="sell_price[]" class="form-control" placeholder="Sell Price" value="<?php echo set_value('sell_price',isset($row['sell_price']) ? $row['sell_price'] : '')?>"  id="sell_price_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Discount</label>
                          <input type="number" name="discount[]" class="form-control" placeholder="Discount" value="<?php echo set_value('discount',isset($row['discount']) ? $row['discount'] : '')?>"  id="discount_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Moq</label>
                          <input type="number" name="moq[]" class="form-control" placeholder="Moq" value="<?php echo set_value('moq',isset($row['moq']) ? $row['moq'] : '')?>"  id="moq_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                        <label>Stock</label>
                          <input type="number" name="stock[]" class="form-control" placeholder="Stock" value="<?php echo set_value('stock',isset($row['stock']) ? $row['stock'] : '')?>"  id="stock_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                      </div>
                    </div>

                    <div class="col-md-1">
                      <div class="form-group">
                          <label>&nbsp;</label>
                          <button class="btn btn-primary form-control remove" data-remove="1" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      </div>
                    </div>
                  </div>
                  <?php $i++; } }else{ ?>
                  <div class="row clone-div">
                    
                    <div class="row 1">
                    
                    <input type="hidden" name="attribute_id[]" class="form-control" value="new">
                    <input type="hidden" name="product_id[]" class="form-control" value="new">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Packaging Size</label>
                          <input type="text" name="packaging_size[]" class="form-control" placeholder="Packaging Size">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>MRP</label>
                          <input type="number" name="mrp[]" class="form-control" placeholder="MRP">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Sell Price</label>
                          <input type="number" name="sell_price[]" class="form-control" placeholder="Sell Price">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Discount</label>
                          <input type="number" name="discount[]" class="form-control" placeholder="Discount">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Moq</label>
                          <input type="number" name="moq[]" class="form-control" placeholder="Moq">
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                        <label>Stock</label>
                          <input type="number" name="stock[]" class="form-control" placeholder="Stock">
                      </div>
                    </div>

                    <div class="col-md-1">
                      <div class="form-group">
                          <label>&nbsp;</label>
                          <button class="btn btn-primary form-control remove" data-remove="1" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>


                  <div class="row">
                  <div class="col-md-1">
                    <button class="btn btn-primary" type="button" id="add_button" data-count="1"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                  </div>
                  </div>
                  


                  <div class="row">
                    <button class="btn btn-primary pull-right submit-button" id="order_submit">Submit</button>
                  </div>
                  </form>
              </div>
            </div>
          </div>
          <!-- /select2 selects -->

          <!-- Footer -->
          <?php $this->load->view('common/footer'); ?>
          <!-- /footer -->

        </div>
        <!-- /content area -->

      </div>
      <!-- /main content -->

    </div>
    <!-- /page content -->

  </div>
  <!-- /page container -->

</body>
</html>


<div class="loader">
<center>
 <img class="loading-image" src="<?php echo base_url()?>images/loader.gif" alt="loading..">
</center>
</div>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>">
<script type="text/javascript">
      $(document).ajaxStart(function(){
          $('.loader').show();
          $('.submit-button').prop('disabled', true);
        });

        $(document).ajaxComplete(function(){
          $('.loader').hide();
          $('.submit-button').prop('disabled', false);
        });
        

        $(document).on('click','.remove',function(){
            var count = $(this).data('remove');
            $('.'+count).remove();
        });


        $(document).on('click','#add_button',function(){
            // $('.clone-row').first().clone().last().appendTo('#clone-div');
            var base_url = $('#base_url').val();
           
                    var id  = $('#hidden_count').val();

                    var j  = parseInt(id)+1;
      
                    $('#hidden_count').val(j);


                        var div = 
                              '<div class="row '+j+'">'+
                              '<input type="hidden" name="attribute_id[]" class="form-control" "  id="attribute_id_'+j+'" data-count="'+j+'" value="new">'+
                              '<input type="hidden" name="product_id[]" class="form-control" value="new"  id="product_id_'+j+'" data-count="'+j+'">'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                  '<label>Packaging Size</label>'+
                                  '<input type="text" class="form-control" placeholder="Packaging Size"'+
                                    'name="packaging_size[]"  id="packaging_size_'+j+'" data-count="'+j+'">'+
                                  '</div></div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                  '<label>MRP</label>'+
                                  '<input type="number" class="form-control" placeholder="MRP"'+
                                    'name="mrp[]"  id="mrp_'+j+'" data-count="'+j+'">'+
                                  '</div></div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Sell Price:</label>'+
                                    '<input type="number" class="form-control" placeholder="Sell Price"'+
                                    'name="sell_price[]"  id="sell_price_'+j+'" data-count="'+j+'">'+
                                    '</div>'+
                              '</div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Discount:</label>'+
                                    '<input type="number" class="form-control" placeholder="Discount"'+
                                    'name="discount[]" min="1" data-count="'+j+'">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Moq:</label>'+
                                    '<input type="number" class="form-control moq moq_'+j+'"'+ 
                                    'placeholder="Moq" name="moq[]" id="moq_'+j+'" data-count="'+j+'">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-1">'+
                                '<div class="form-group">'+
                                    '<label>Stock:</label>'+
                                    '<input type="number" class="form-control stock stock_'+j+'"'+ 
                                    'placeholder="Stock" name="stock[]" id="stock_'+j+'" data-count="'+j+'">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-1">'+
                              '<div class="form-group">'+
                                  '<label>&nbsp;</label>'+
                                  '<button class="btn btn-primary form-control remove"'+
                                  'data-remove="'+j+'" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
                              '</div>'+
                            '</div>'+
                            '</div>';

     
                            //console.log(div);
                        $('.clone-div').last().append(div);

                        $('.select-search').select2();
                        

        });
        
        $('#add').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Product/addConfigurableProducts',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                      window.location.href = base_url+'Product/productList';
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);

                            if(key == 'delivery_boy_id' || key == 'delivery_zone_id'){
                              element.closest('.select').next('.select2').after(value);
                            }else{
                              element.closest('.form-control').after(value);
                            }
                            
                        });
                    }else if(obj.errCode == 5){
                      $('.error-div').empty();
                      $('.error-div').append(obj.message);
                    }

                }

            });

        });
          
</script>