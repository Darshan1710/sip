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
              <li><a href="#">Offer</a></li>
              <li class="active">Add Offer</li>
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
                  <h5 class="panel-title">Offer Form </h5>
                  <hr>
                  <form method="post" action="#" id="addOffer" enctype="multipart/form-data">

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Product:</label>
                          <select class="select-search form-control" name="product_id" readonly id="product_id_<?php echo $i; ?>" data-count="<?php echo $i ?>" >
                            <optgroup label="Products">
                              <option>Please Select Product</option>
                              <?php foreach($products as $p){ ?>
                              <option value="<?php echo $p['id'] ?>"><?php echo $p['product_name'] ?></option>
                              <?php } ?> 
                            </optgroup>
                          </select>
                          <p><?php echo form_error('product_id') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Offer Image:</label>
                          <input type="file" class="form-control" placeholder="" name="file" id="file">
                          <p><?php echo form_error('file') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Offer Title:</label>
                          <input type="text" class="form-control" placeholder="" name="offer_title" id="offer_title">
                          <p><?php echo form_error('offer_title') ?></p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>HomeSection:</label>
                          <select class="form-control select" name="home_section"  id="home_section">
                          <option value="">Please Select</option>
                          <option value="1">Section Offer</option>
                          <option value="2">Section Deal</option>
                          </select>
                          <p><?php echo form_error('home_section') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Status:</label>
                          <select class="form-control select" name="status"  id="status">
                          <option value="">Please Select</option>
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                          </select>
                          <p><?php echo form_error('status') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Deal Expiry:</label>
                          <input type="date" name="deal_expiry" class="form-control" id="deal_expiry">
                          <p><?php echo form_error('deal_expiry') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Description:</label>
                          <textarea  name="description" class="form-control" id="description"></textarea>
                          <p><?php echo form_error('description') ?></p>
                        </div>
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
        


        $('#addOffer').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Offer/addOffer',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        window.location.href = base_url+'Offer/offerList';

                    }else if (obj.errCode == 2){
                        alert(obj.message);
                    }else if (obj.errCode == 3){
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);

                            if(key == 'home_section' || key == 'status' || key == 'product_id'  ){
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