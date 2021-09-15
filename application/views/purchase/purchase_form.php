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
              <li><a href="#">Purchase</a></li>
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
                  <form method="post" action="#" id="addPurchase">
                  <div class="row">
                    <legend class="text-semibold">Purchase Info</legend>
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Supplier:</label>
                            <select class="form-control select-search" name="supplier_id">
                              <option value="">Please Select Supplier</option>
                              <?php $i = 1;
                                 if(!empty($suppliers)){ 
                                foreach ($suppliers as $key => $value) { ?>
                                  <option value="<?php echo $value['supplier_id'] ?>"><?php echo $value['name'] ?></option>
                                <?php  }
                                } ?>
                            </select>
                        </div>
                    </div>
                  </div>
                  <div class="row" id="pur_clone_div">
                    <div class="col-md-3">
                      <div class="form-group">
                          <label>Product:</label>
                          <select class="form-control select-search" name="product_id[]">
                              <option value="">Please Select Product</option>
                              <?php if(!empty($products)){ 
                                foreach ($products as $key => $value) { ?>
                                  <option value="<?php echo $value['id'] ?>"><?php 
                                  $packaging_size = '';
                                  if($value['product_type'] == '1'){
                                     $packaging_size = ' ('.$value['packaging_size'].')';
                                  }

                                  echo $value['product_name'].$packaging_size  ?></option>
                                <?php  }
                                } ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Rate:</label>
                          <input type="number" class="form-control rate" id="rate_<?php echo $i; ?>" name="rate[]" data-count="<?php echo $i ?>" value="0">
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label>Quantity:</label>
                          <input type="number" class="form-control supp_qty" id="supp_qty_<?php echo $i; ?>" name="qty[]" data-count="<?php echo $i ?>" value="0">
                        </div>
                    </div>
                    
                     <div class="col-md-3">
                      <div class="form-group">
                          <label>Total:</label>
                          <input type="text" class="form-control total_price" id="total_price_<?php echo $i; ?>" name="total[]" readonly data-count="<?php echo $i ?>" value="0">
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                            &nbsp;
                        </div>
                    </div>
                    
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <button class="btn btn-primary form-control" type="button" id="add_sup_button" data-count="1"><i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                      </div>
                    </div>
                    <div class="col-md-offset-4 col-md-1"><label style="margin-top: 10%">Total</label></div>

                      <div class=" col-md-3">
                        <div class="form-group">
                        <input type="text"  readonly="" class="form-control" id="total">
                        </div>
                      </div>
                      <div class="col-md-2">
                        <button class="btn btn-success form-control submit-button">Submit</button>    
                      </div>
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
<script type="text/javascript">
  $(document).ajaxStart(function(){
          $('.loader').show();
          $('.submit-button').prop('disabled', true);
        });

        $(document).ajaxComplete(function(){
          $('.loader').hide();
          $('.submit-button').prop('disabled', false);
        });
        
        
    // $(document).on('change','.supp_qty',function(){
    //     var qty = $(this).val();
    //     var count = $(this).data('count');
    //     var unit_price = $('#rate_'+count).val();
    //     var total = qty * unit_price;
    //     $('#total_price_'+count).val(total);
    //     var final_total = 0;
    //     var cnt = $('.supp_qty').last().data('count');
    //     for(var i = 1; i <= cnt; i++){
    //         var price = $('#total_price_'+i).val();
    //         price = (price != undefined) ? price : 0;
    //         final_total = parseInt(final_total)+parseInt(price);
    //     }
    //     $('#total').val(final_total);
    // });

    $(document).on('focusout','.supp_qty',function(){
        var unit_price = $(this).val();
        var count = $(this).data('count');
        var qty = $('#rate_'+count).val();
        var total = qty * unit_price;
        $('#total_price_'+count).val(total);
        var final_total = 0;
        var cnt = $('.supp_qty').last().data('count');
        for(var i = 1; i <= cnt; i++){
            var price = $('#total_price_'+i).val();
            price = (price != undefined) ? price : 0;
            final_total = parseInt(final_total)+parseInt(price);
        }
        $('#total').val(final_total);
    });

    $(document).on('click','.remove',function(){

        var count = $(this).data('remove');
        $('.supp_row_'+count).remove();
        var cnt = $('.supp_qty').last().data('count');
        var final_total = 0;
        for(var i = 1; i <= cnt; i++){
            var price = $('#total_price_'+i).val();
            price = (price != undefined) ? price : 0;
            final_total = parseInt(final_total)+parseInt(price);
        }
        $('#total').val(final_total);
    });
    var j = 2;
    $(document).on('click','#add_sup_button',function(){
        var base_url = $('#base_url').val();
        var p = '<?php echo json_encode($products) ?>';
        p = $.parseJSON(p);
        
        var div = 
              '<div class="supp_row_'+j+'">'+
              '<div class="col-md-3">'+
                '<div class="form-group">'+
                  '<label>Product</label>'+
                  '<select class="form-control select-search" name="product_id[]">'+
                      '<option value="">Please Select Product</option>';
                          $.each(p,function(index,value){
                              div += '<option value="'+value.product_id+'">'+value.product_name+'</option>';
                          });
                div   +=  '</select></div></div>'+
                          
                          '<div class="col-md-2">'+
                            '<div class="form-group">'+
                                '<label>Rate:</label>'+
                                '<input type="text" class="form-control rate"'+
                                'name="rate[]" id="rate_'+j+'" data-count="'+j+'" value="0">'+
                            '</div>'+
                          '</div>'+
                          '<div class="col-md-2">'+
                            '<div class="form-group">'+
                                '<label>Quantity:</label>'+
                                '<input type="text" class="form-control supp_qty"'+
                                'name="qty[]"  id="supp_qty_'+j+'" data-count="'+j+'" value="0">'+
                                '</div>'+
                          '</div>'+
                          '<div class="col-md-3">'+
                            '<div class="form-group">'+
                                '<label>Total:</label>'+
                                '<input type="text" class="form-control"'+ 
                                'name="total[]" id="total_price_'+j+'" data-count="'+j+'" value="0" readonly>'+
                            '</div>'+
                          '</div>'+
                          '<div class="col-md-1">'+
                          '<div class="form-group">'+
                              '<label>&nbsp;</label>'+
                              '<button class="btn btn-primary form-control remove"'+
                              'data-remove="'+j+'" type="button"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
                          '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div>';
                    $('#pur_clone_div').append(div);
                    $('.select-search').select2();
                    j = j+1;
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
                url: base_url + 'Purchase/addPurchase',
                success: function(data) {
                    var result = $.parseJSON(data);
                    if (result.flag == 0) {
                        alert(result.msg);
                    } else{
                        alert(result.msg);
                        window.location.href = base_url+'Purchase/purchaseList';
                    }

                }

            });

        });
</script>