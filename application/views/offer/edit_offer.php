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
                  <input type="hidden" name="id" value="<?php echo $this->uri->segment(3)?>">
                <div class="row">
                  <div class="col-md-4">
                      <div class="form-group">
                          <label>Product:</label>
                          <select class="form-control select" name="product_id"  id="product_id">
                          <option value="">Please Select</option>
                          <?php foreach($products as $row){ ?>
                          <option value="<?php echo $row['id'] ?>" <?php echo set_select('product_id', $row['id'], $offer['product_id'] == $row['id'] ? TRUE : FALSE ); ?>><?php echo $row['product_name'] ?></option>
                          <?php } ?> 
                          </select>
                          <p><?php echo form_error('product_id') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Offer Image:</label>
                          <label>Image (1349 x 625)</label><br>
                            <img class="image" width="50px" height="35px" src="<?php echo $image = !empty($offer['offer_image']) ? base_url().$offer['offer_image']  : ''; ?>">
                            <button class="btn btn-sm btn-primary change_image" type="button">Change Image</button>
                            <input type="hidden" name="file" class="new_image">
                            <input type="hidden"  class="form-control old_image" name="old_image" value="<?php echo $image = empty($offer['offer_image']) ? set_value('old_image') : $offer['offer_image']?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Offer Title:</label>
                          <input type="text" class="form-control" placeholder="Buy more & Save more " name="offer_title" id="offer_title" value="<?php echo set_value('offer_title',isset($offer['offer_title']) ? $offer['offer_title'] : '')?>">
                          <p><?php echo form_error('offer_title') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Home Section:</label>
                          <select class="form-control select" name="home_section"  id="home_section">
                          <option value="">Please Select</option>
                          <option value="1" <?php echo set_select('home_section', '1', $offer['home_section'] == '1' ? TRUE : FALSE ); ?>>Section Offer</option>
                          <option value="2" <?php echo set_select('home_section', '2', $offer['home_section'] == '2' ? TRUE : FALSE ); ?>>Deal Of the day</option>
                          </select>
                          <p><?php echo form_error('home_section') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Status:</label>
                          <select class="form-control select" name="status"  id="status">
                          <option value="">Please Select</option>
                          <option value="1" <?php echo set_select('status', '1', $offer['status'] == '1' ? TRUE : FALSE ); ?>>Active</option>
                          <option value="0" <?php echo set_select('status', '0', $offer['status'] == '0' ? TRUE : FALSE ); ?>>Inactive</option>
                          </select>
                          <p><?php echo form_error('status') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Deal Expiry:</label>
                          <input type="date" name="deal_expiry" class="form-control" id="deal_expiry" value="<?php echo set_value('deal_expiry',isset($offer['deal_expiry']) ? $offer['deal_expiry'] : '')?>">
                          <p><?php echo form_error('deal_expiry') ?></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label>Description:</label><br>
                          <textarea class="form-control description" name="description" id="description"><?php echo set_value('description',isset($offer['offer_description']) ? $offer['offer_description'] : '')?></textarea>
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
        
         $('.change_image').on('click',function(){
        $('.image').css('display','none');
        $('.new_image').attr('type','file');
        $('.change_image').css('display','none');
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
                url: base_url + 'Offer/updateOffer',
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

                            if(key == 'offer_category' || key == 'category_id' || key == 'status' || key == 'is_home_banner' || key == 'is_home_offer'  ){
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