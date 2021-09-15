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
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- /global stylesheets -->

  <!-- Core JS files -->
  <script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
  <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
  <!-- /core JS files -->

  <!-- Theme JS files -->
  <!-- <script src="<?php echo base_url() ?>js/plugins/pickers/pickadate/picker.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/pickers/pickadate/picker.date.js"></script> -->
  <script src="<?php echo base_url ()?>js/plugins/notifications/jgrowl.min.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/ui/moment/moment.min.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/daterangepicker.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/anytime.min.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.date.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/picker.time.js"></script>
  <script src="<?php echo base_url ()?>js/plugins/pickers/pickadate/legacy.js"></script>


  <!--  <script src="<?php echo base_url() ?>js/core/libraries/jquery_ui/interactions.min.js"></script>
  <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script> -->

  <script src="<?php echo base_url() ?>js/app.js"></script>
<!--   <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script> -->
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
              <li><a href="#">Package</a></li>
              <li class="active">Add Package</li>
            </ul>

          </div>
        </div>
        <!-- /page header -->


        <!-- Content area -->
        <div class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-flat">
                <div class="panel-heading">
                  <h5 class="panel-title">Order Form</h5>
                  <div class="col-sm-6">
                  <h6 class="card-title">Name :<code><?php echo $order['name'] ?></code></h6>
                  <h6 class="card-title">Mobile :<code><?php echo $order['mobile'] ?></code></h6>
                  </div>
                  <div class="col-sm-6">
                  <h6 class="card-title">Email :<code><?php echo $order['email'] ?></code></h6>
                  <h6 class="card-title">Address :<code><?php echo $order['address'] ?></code></h6>

                  </div>
            
 
                                <button class="btn btn-primary" type="button" id="add_button" data-count="1"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                </div>

                <div class="panel-body">

                  <hr>
                  <form method="post" action="<?php echo base_url()?>Admin/addOrder">
                  <?php 
                  $i = 1;
                  foreach($enquiry_details as $row){ ?>
                  <div class="row" id="clone-div">
                    <div class="<?php echo $i; ?>">
                    <input class="hidden"  value="<?php echo $i; ?>" id="hidden">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Product Name</label>
                        <select class="form-control" name="product_id" readonly id="product_id_<?php echo $i; ?>" data-count="<?php echo $i ?>" disabled>
                          <option>Please Select Product</option>
                          <?php foreach($products as $p){ ?>
                          <option value="<?php echo $p['id'] ?>" <?php echo set_select('product_id', $p['id'], $row['product_id'] == $p['id'] ? TRUE : FALSE ); ?>><?php echo $p['product_name'] ?></option>
                          <?php } ?> 
                          </select>
                          <p><?php echo form_error('product_id') ?></p>
                          <input type="hidden" name="product_name" value="<?php echo $row['product_id'] ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Unit Price:</label>
                          <input type="text" class="form-control" placeholder="Unit Price" name="unit_price[]" value="<?php echo set_value('id',isset($row['unit_price']) ? $row['unit_price'] : '')?>" readonly id="unit_price_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('unit_price[]') ?></p>
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Qty:</label>
                          <input type="text" class="form-control qty" placeholder="Qty" name="qty[]" value="<?php echo set_value('id',isset($row['qty']) ? $row['qty'] : '0')?>" id="qty_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('qty[]') ?></p>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Price:</label>
                          <input type="text" class="form-control price_<?php echo $i; ?>" placeholder="Price" name="price[]" value="<?php echo set_value('id',isset($row['price']) ? $row['price'] : '0')?>" id="price_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('price[]') ?></p>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>&nbsp;</label>
                          <button class="btn btn-primary form-control remove" data-remove="<?php echo $i; ?>" type="button">Remove</button>
                      </div>
                    </div>
                  </div>
                </div>
                  <?php } ?>

                  <div class="row">
                  <div class="col-md-offset-7 col-md-1"><label style="margin-top: 10%">Total</label></div>
                  <div class=" col-md-4">
                    <div class="form-group">
                    <input type="text" name="total" readonly="" class="form-control" id="total">
                    </div>
                  </div>
                  </div>

                  <div class="row">
                    <button class="btn btn-primary pull-right submit-button">Submit</button>
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
<script type="text/javascript">
    $(document).on('focusout','.qty',function(){
            var qty = $(this).val();
            var count = $(this).data('count');
            var unit_price = $('#unit_price_'+count).val();
            var total = qty * unit_price;
            $('#price_'+count).val(total);

            var final_total = 0;
            for(var i = 1; i <= count; i++){
                var price = $('.price_'+i).val();
                final_total = parseInt(final_total)+parseInt(price);
            }
            $('#total').val(final_total);
        });

        $(document).on('click','.remove',function(){
            var count = $(this).data('remove');
            $('.'+count).remove();
            var qty_count = $('.qty').length;
            var final_total = 0;
            for(var i = 1; i <= qty_count; i++){
                var price = $('.price_'+i).val();
                final_total = parseInt(final_total)+parseInt(price);
            }
            if(final_total == 0){
              $('.submit-button').prop('disabled',true);
            }
            $('#total').val(final_total);
        });


        $(document).on('change','.pro', function() {
            var base_url = $('#base_url').val();
            var id = $(this).val();
            var hidden_id = $('#hidden').val();
            $.ajax({
                type : 'post',
                data : {id:id},
                url : base_url+'Admin/getProductDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){
                        $('#unit_price_'+hidden_id).val(obj.message.unit_price)
                    }else{
                        alert('No products found');
                    }
                }
            });
        });

        $(document).on('click','#add_button',function(){
            // $('.clone-row').first().clone().last().appendTo('#clone-div');
            var base_url = $('#base_url').val();
            $.ajax({
                url : base_url+'Admin/getProductList',
                success:function(data){
                    var obj = $.parseJSON(data);
                    var id  = $('#hidden').val();

                    var j  = ++id;
                    $('.hidden').val(j);

                    if(obj.errCode == -1){
                        var div = 
                              '<div class="'+j+'">'+
                              '<div class="col-md-3">'+
                                '<div class="form-group">'+
                                  '<label>Product Name</label>'+
                                  '<select class="form-control pro products_'+j+'"'+
                                                   'name="products[]" id="products" data-count="'+j+'">'+
                                                      '<option value="">Please Select Product</option>';

                                                  $.each(obj.message,function(index,value){
                                                      div += '<option value="'+value.id+'" data-price="'+value.price+'">'+value.product_name+'</option>';
                                                      });
                    div   +=  '</select></div></div>'+
                              '<div class="col-md-3">'+
                                '<div class="form-group">'+
                                    '<label>Unit Price:</label>'+
                                    '<input type="text" class="form-control" placeholder="Unit Price"'+
                                    'name="unit_price[]"  id="unit_price_'+j+'" data-count="'+j+'">'+
                                    '</div>'+
                              '</div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Qty:</label>'+
                                    '<input type="text" class="form-control qty" placeholder="Qty"'+
                                    'name="qty[]" data-count="'+j+'" value="0">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Price:</label>'+
                                    '<input type="text" class="form-control price_'+j+'"'+ 
                                    'placeholder="Price" name="price[]" id="price_'+j+'" data-count="'+j+'" value="0">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-2">'+
                              '<div class="form-group">'+
                                  '<label>&nbsp;</label>'+
                                  '<button class="btn btn-primary form-control remove"'+
                                  'data-remove="'+j+'" type="button">Remove</button>'+
                              '</div>'+
                            '</div>'+
                            '</div>';

     

                        $('#clone-div').append(div);

     
                        
                    }else{
                        alert('No products found');
                    }
                }
            });
        });
</script>