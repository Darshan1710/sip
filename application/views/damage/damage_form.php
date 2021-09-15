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

                <div class="panel-body">
                  <form method="post" action="#" id="addDamageOrder">


                  <legend class="text-semibold">Damage Product Information</legend>
                  <div class="error-div">
                    </div>

                  <input class="hidden_count"  name="hidden_count" value="0" id="hidden_count" type="hidden">


                    <div class="row clone-div" >
                    

                    </div>

                  <div class="row">
                  <div class="col-md-1">
                    <button class="btn btn-primary" type="button" id="add_button" data-count="1"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                  </div>
                  <div class="col-md-offset-6 col-md-1"><label style="margin-top: 10%">Total</label></div>
                  <div class=" col-md-4">
                    <div class="form-group">
                    <input type="text"  readonly="" class="form-control" id="total" value="<?php echo set_value('total',isset($enquiry['total']) ? $enquiry['total'] : '')?>">
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
        
      $( "#mobile" ).autocomplete({
            source: function(request, response) {
                 $.ajax({  
                 url : "<?php echo site_url('Customer/getCustomerNumber?');?>",
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
            var final_count = $('#hidden_count').val();
            var unit_price = $('#unit_price_'+count).val();
            var total = qty * unit_price;
            $('#price_'+count).val(total);

            var final_total = 0;
            for(var i = 1; i <= final_count; i++){
                var price = $('.price_'+i).val();
                if(price){
                  final_total = parseInt(final_total)+parseInt(price);
                }
                
            }
            $('#total').val(final_total);
        });

        $(document).on('click','.remove',function(){
            var count = $(this).data('remove');
            var final_count = $('#hidden_count').val();
            $('.'+count).remove();
            var qty_count = $('.qty').length;
            var final_total = 0;
            // var inputs = $(".price");
            for(var i = 1; i <= final_count; i++){
                var price = $('.price_'+i).val();
                if(price){
                  final_total = parseInt(final_total)+parseInt(price);
                }
            }
            $('#total').val(final_total);
        });


        $(document).on('change','.pro', function() {
            var base_url = $('#base_url').val();
            var id = $(this).val();
            var data_count = $(this).data('count');
            var hidden_id = $('#hidden_count').val();
            $.ajax({
                type : 'post',
                data : {id:id},
                url : base_url+'Product/getProductDetails',
                success:function(data){
                    var obj = $.parseJSON(data);

                    if(obj.errCode == -1){
                        $('#unit_price_'+data_count).val(obj.message.sell_price);
                        $('#stock_in_'+data_count).val(obj.message.stock);
                    }else{
                        alert('No products found');
                    }
                }
            });
        });

        $(document).on('change','#mobile', function() {
            var base_url = $('#base_url').val();
            var mobile = $(this).val();
            var hidden_id = $('#hidden_count').val();
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
                        alert('No Customer found');
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
                    var id  = $('#hidden_count').val();

                    var j  = parseInt(id)+1;
      
                    $('#hidden_count').val(j);

                    if(obj.errCode == -1){
                        var div = 
                              '<div class="'+j+'">'+
                              '<div class="col-md-3">'+
                                '<div class="form-group">'+
                                  '<label>Product Name</label>'+
                                  '<select class="select-search form-control pro products_'+j+'"'+
                                                   'name="product_name[]" id="product_name" data-count="'+j+'">'+
                                                      '<optgroup label="Products">Products>';

                                                  $.each(obj.message,function(index,value){
                                                      div += '<option value="'+value.id+'" data-price="'+value.price+'">'+value.product_name+'</option>';
                                                      });
                    div   +=  '</optgroup></select></div></div>'+
                              '<div class="col-md-1">'+
                                '<div class="form-group">'+
                                    '<label>Unit Price:</label>'+
                                    '<input type="text" class="form-control" placeholder="Unit Price"'+
                                    'name="unit_price[]"  id="unit_price_'+j+'" readonly data-count="'+j+'">'+
                                    '</div>'+
                              '</div>'+
                              '<div class="col-md-1">'+
                              '<div class="form-group">'+
                                  '<label>Stock:</label>'+
                                  '<input type="text" class="form-control" placeholder="0"'+ 'name="stock_in[]" readonly id="stock_in_'+j+'"'+
                                   'data-count="'+j+'">'+
                                '</div>'+
                            '</div>'+
                              '<div class="col-md-1">'+
                                '<div class="form-group">'+
                                    '<label>Qty:</label>'+
                                    '<input type="text" class="form-control qty" placeholder="Qty"'+
                                    'name="qty[]" data-count="'+j+'" value="0">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-1">'+
                                '<div class="form-group">'+
                                    '<label>Price:</label>'+
                                    '<input type="text" class="form-control price_'+j+'"'+ 
                                    'placeholder="Price" name="price[]" id="price_'+j+'" data-count="'+j+'" value="0">'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-4">'+
                                '<div class="form-group">'+
                                    '<label>Reason:</label>'+
                                    '<input type="text" class="form-control reason_'+j+'"'+ 
                                    'placeholder="Reason" name="reason[]" id="reason_'+j+'" data-count="'+j+'" value="">'+
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

        $('#addDamageOrder').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Product/addDamageOrder',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        alert(obj.message);
                        window.location.href = base_url+'Product/damageProductList';

                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);
                            element.closest('.form-control').after(value);
                            
                        });
                    }else if(obj.errCode == 5){
                      $('.error-div').empty();
                      $('.error-div').append(obj.message);
                    }

                }

            });

        });
</script>