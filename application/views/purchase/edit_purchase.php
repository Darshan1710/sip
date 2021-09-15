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
  <script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
  <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>js/jquery-ui.min.js"></script>
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
              <li><a href="#">Purchase </a></li>
              <li class="active">Add Purchase</li>
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
                  <h5 class="panel-title">Purchase Form</h5>
                  <hr>
                  <form method="post" action="#" id="addPurchase">
                    <legend class="text-semibold">Customer Info</legend>
                  <div class="row">
                    
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Supplier:</label>
                          <select class="form-control select" name="supplier_id">
                              <option value="">Please Select Supplier</option>
                              <?php $i = 1;
                                 if(!empty($suppliers)){ 
                                foreach ($suppliers as $key => $value) { ?>
                                  <option value="<?php echo $value['supplier_id'] ?>" <?php echo set_select('supplier_id', $value['supplier_id'], $value['supplier_id'] == $purchase['supplier_id'] ?  TRUE: FALSE ); ?>><?php echo $value['name'] ?></option>
                                <?php  }
                                } ?>
                            </select>
                            <p><?php echo form_error('supplier_id'); ?></p>
                        </div>
                    </div>
                  </div>

                  <legend class="text-semibold">Order Information</legend>
                  <div class="error-div">
                    </div>
                  <?php 

                  if(isset($purchase_details)){
                    $count = COUNT($purchase_details);
                  }else{
                    $count = 1;
                  } ?>
                  <input type="hidden" class="hidden"  value="<?php echo $count; ?>" id="hidden">
                  <input type="hidden"  value="<?php echo $count; ?>" id="total_count">
                  <input type="hidden" name="purchase_id" value="<?php if($this->uri->segment(3) != ''){ echo $this->uri->segment(3); }else{ echo 'new'; } ?>">
                  <?php if(isset($purchase_details)){

                  $i = 1;
                  foreach($purchase_details as $row){ ?>
                  <div class="row clone-div">
                    
                    <div class="<?php echo $i; ?>">
                    
                    
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Product Name</label>
                        <select class="form-control select" name="product_id" readonly id="product_id_<?php echo $i; ?>" data-count="<?php echo $i ?>" disabled>
                          <option>Please Select Product</option>
                          <?php foreach($products as $p){ ?>
                          <option value="<?php echo $p['id'] ?>" <?php echo set_select('product_id', $p['id'], $row['product_id'] == $p['id'] ? TRUE : FALSE ); ?>><?php echo $p['product_name'] ?></option>
                          <?php } ?> 
                          </select>
                          <p><?php echo form_error('product_id') ?></p>
                          <input type="hidden" name="product_name[]" value="<?php echo $row['product_id'] ?>">
                      </div>
                    </div>
                    
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Stock:</label>
                          <input type="text" class="form-control" placeholder="0" name="stock_in[]" value="<?php echo set_value('id',isset($row['remaning_stock']) ? $row['remaning_stock'] : '')?>" readonly id="stock_in_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Rate:</label>
                          <input type="text" class="form-control" placeholder="Unit Price" name="rate[]" value="<?php echo set_value('id',isset($row['rate']) ? $row['rate'] : '')?>" id="rate_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('rate[]') ?></p>
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
                          <label>Subtotal:</label>
                          <input type="text" class="form-control subtotal_<?php echo $i; ?>" placeholder="Subtotal" name="subtotal[]" value="<?php echo set_value('id',isset($row['subtotal']) ? $row['subtotal'] : '0')?>" id="price_<?php echo $i; ?>" data-count="<?php echo $i ?>">
                          <p><?php echo form_error('subtotal[]') ?></p>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <div class="form-group">
                          <label>&nbsp;</label>
                          <button class="btn btn-primary form-control remove" data-remove="<?php echo $i; ?>" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                  <?php $i++; } }else{
                    echo "1";exit;
                    $i = 0;
                   ?>
                    <div class="row clone-div" >
                    

                    </div>
                  <?php } ?>
                  <div class="row">
                  <div class="col-md-1">
                    <button class="btn btn-primary" type="button" id="add_button" data-count="1"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                  </div>
                  <div class="col-md-offset-6 col-md-1"><label style="margin-top: 10%">Total</label></div>
                  <div class=" col-md-4">
                    <div class="form-group">
                    <input type="text"  readonly="" class="form-control" id="total" value="<?php echo set_value('total',isset($purchase['total']) ? $purchase['total'] : '0')?>">
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

      $( "#mobile" ).autocomplete({
            source: function(request, response) {
                 $.ajax({  
                 url : "<?php echo site_url('Admin/getCustomerNumber?');?>",
                 data: { mobile : request.term},
                 dataType: "json",
                 type: "POST",
                 success: function(data){
                  response(data.items);
                 } 

                 });
             },
             minLength: 3
          });

      $(document).on('focusout','.qty',function(){
            var qty = $(this).val();
            var count = $(this).data('count');
            var total_count = $("#total_count").val();
            var unit_price = $('#rate_'+count).val();
            var total = qty * unit_price;
            $('#subtotal_'+count).val(total);

            var final_total = 0;
            for(var i = 1; i <= total_count; i++){
                var price = $('.subtotal_'+i).val();
                if(price){
                  final_total = parseFloat(final_total)+parseFloat(price);
                }
            }
            $('#total').val(final_total);
        });

        $(document).on('click','.remove',function(){
            var count = $(this).data('remove');
            $('.'+count).remove();
            var qty_count = $('.qty').length;
            var total_count = $("#total_count").val();
            var final_total = 0;
            for(var i = 1; i <= total_count; i++){
                var price = $('.subtotal_'+i).val();
                if(price){
                  final_total = parseInt(final_total)+parseInt(price);
                }
                
            }
            // if(final_total == 0){
            //   $('.submit-button').prop('disabled',true);
            // }
            $('#total').val(final_total);
        });


        $(document).on('change','.pro', function() {
            var base_url = $('#base_url').val();
            var id = $(this).val();
            var hidden_id = $('#hidden').val();
            $.ajax({
                type : 'post',
                data : {id:id},
                url : base_url+'Product/getProductDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){
                        $('#rate_'+hidden_id).val(obj.message.rate);
                        $('#stock_'+hidden_id).val(obj.message.stock)
                    }else{
                        alert('No products found');
                    }
                }
            });
        });

        $(document).on('change','#mobile', function() {
            var base_url = $('#base_url').val();
            var mobile = $(this).val();
            var hidden_id = $('#hidden').val();
            $.ajax({
                type : 'post',
                data : {mobile:mobile},
                url : base_url+'Customer/getCustomerDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){
                        $('#name').val(obj.data.name);
                        $('#email').val(obj.data.email);
                        $('#mobile').val(obj.data.mobile);
                        $('#address').val(obj.data.address);
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
                url : base_url+'Product/getProductList',
                success:function(data){
                    var obj = $.parseJSON(data);
                    var id  = $('#hidden').val();

                    var j  = ++id;
                    $('#hidden').val(j);
                    $('#total_count').val(j);

                    if(obj.errCode == -1){


                        var div = 
                              '<div class="'+j+'">'+
                              '<div class="col-md-3">'+
                                '<div class="form-group">'+
                                  '<label>Product Name</label>'+
                                  '<select class="select-search form-control pro products_'+j+'"'+
                                                   'name="product_name[]" id="product_name" data-count="'+j+'">'+
                                                      '<option value="">Please Select Product</option>';

                                                  $.each(obj.message,function(index,value){

                                                    var packaging_size = value.product_type == 1 ? '('+value.packaging_size+')' : '';

                                                      div += '<option value="'+value.id+'" data-price="'+value.sell_price+'">'+value.product_name+packaging_size+'</option>';
                                                      });
                    div   +=  '</select></div></div>'+
                              
                              '<div class="col-md-2">'+
                              '<div class="form-group">'+
                                  '<label>Stock:</label>'+
                                  '<input type="text" class="form-control" placeholder="0"'+ 'name="stock_in[]"  id="stock_'+j+'"'+
                                   'data-count="'+j+'">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<label>Rate:</label>'+
                                    '<input type="text" class="form-control" placeholder="Rate"'+
                                    'name="rate_[]"  id="rate_'+j+'" data-count="'+j+'">'+
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
                                    '<label>Subtotal:</label>'+
                                    '<input type="text" class="form-control subtotal_'+j+'"'+ 
                                    'placeholder="Subtotal" name="subtotal[]" id="subtotal_'+j+'" data-count="'+j+'" value="0">'+
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


                        $('.clone-div').last().append(div);

                        $('.select-search').select2();
     
                        
                    }else{
                        alert('No products found');
                    }
                }
            });
        });

        $('#addPurchase').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Purchase/updatePurchase',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        alert(obj.message);
                        window.location.href = base_url+'Purchase/purchaseList';

                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);
                            element.closest('.form-control').after(value);
                        });
                    }else if(obj.errCode == 5){
                      $('.error-div').append(obj.message);
                    }

                }

            });

        });
</script>