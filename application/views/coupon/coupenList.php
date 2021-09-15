
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo TITLE; ?></title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/core.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/colors.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/custom.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <script src="<?php echo base_url() ?>js/plugins/ui/moment/moment.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/pickers/pickadate/picker.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/pickers/pickadate/picker.date.js"></script>

    <!-- Theme JS files --> 
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/datatables.min.js"></script>

    <script src="<?php echo base_url() ?>js/app.js"></script>
    <script src="<?php echo base_url() ?>js/custom.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>

    <!-- /theme JS files -->

    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
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
                            <li><a href="#">Coupon</a></li>
                            <li class="active">Coupon List</li>
                        </ul>


                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <div class="row">
                            <div class="col-md-7">
                            <a class="btn btn-sm btn-success" href="#" data-target="#add_modal" data-toggle="modal"><i class="icon-plus2"></i> Add Coupon</a>
                             </div>
                            </div>
                        </div>


                        <table class="table" id="coupon-list">
                            <thead>
                                <tr>
                                   
                                    <th>Sr. No.</th>
                                    <th>Coupon Code</th>
                                    <th>Type</th>
                                    <th>Start Date</th>
                                    <th>Expiry Date</th>
                                    <th>Discount</th>
                                    <th>Max Discount</th>
                                    <th>Available Coupons</th> 
                                    <th>Minimum Bill Amount</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($coupon)) {
                                    $i = 1;
                                      foreach($coupon as $row){
                                      
                                ?>
                                    <tr>
                                    <td><?php echo $i ?></td>    
                                    <td><?php echo $row['coupon_code'] ?></td>
                                    <td><?php if($row['type'] == '1'){ echo "Flat"; }else{ echo "Percentage"; }; ?></td>
                                    <td><?php echo date('d-m-Y h:i:s',strtotime($row['start_date'])); ?></td>
                                    <td><?php echo date('d-m-Y h:i:s',strtotime($row['expiry_date'])); ?></td>
                                    <td><?php echo $row['discount']; ?></td>
                                    <td><?php echo $row['max_discount']; ?></td>
                                    <td><?php echo $row['available_coupons']; ?></td>
                                    <td><?php echo $row['minimum_bill_amount']; ?></td>
                                    <td><?php if($row['active'] == '1'){
                                        echo '<button class="btn btn-success btn-sm">Active</button>';
                                    }else{
                                        echo '<button class="btn btn-danger btn-sm">Inactive</button>';
                                    }  ?></td>
                                    
                                    <td><?php echo date('d-m-Y',strtotime($row['created_at']));?></td>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="#" id="<?php echo $row['id'] ?>" data-toggle="modal" data-target="#edit_modal" class="editcoupen"><i class="icon-file-pdf"></i> Edit</a></li>
                                                   
                                                    
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>

                                    
                                </tr>
                                <?php 
                                    $i++;
                                    } }?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /basic responsive configuration -->


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

</body>

</html>


<div id="add_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Coupon</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" method="post" id="coupen_form">
                <div class="modal-body">
  
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Coupon Code</label>
                                <input type="text" placeholder="Coupon Code" class="form-control" id="coupon_code" name="coupon_code">
                            </div>

                            <div class="col-sm-6">
                                <label>Type</label>
                                <select class="form-control" name="type" id="type">
                                    <option value="">Please Select type</option>
                                    <option value="1">Flat</option>
                                    <option value="2">Percentage</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Discount</label>
                                <input type="number" placeholder="Discount" class="form-control" id="discount" name="discount">
                            </div>

                            <div class="col-sm-6">
                                <label>Max Discount</label>
                                <input type="number" placeholder="Max Discount" class="form-control" id="max_discount" name="max_discount">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Start Date</label>
                                  <input type="date" class="form-control" placeholder="Start Date&hellip;" name="start_date" id="start_date">
                            </div>

                            <div class="col-sm-6">
                                <label>End Date</label>
                                  
                                  <input type="date" class="form-control" placeholder="Expiry Date&hellip;" name="expiry_date" id="expiry_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>No of coupon</label>
                                  <input type="number" class="form-control" placeholder="No of coupon" name="available_coupons" id="available_coupons">
                            </div>

                            <div class="col-sm-6">
                                <label>Minimum Bill Amount</label>
                                  <input type="number" class="form-control" placeholder="Minimum Bill Amount" name="minimum_bill_amount" id="minimum_bill_amount">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Active</label>
                                <select class="form-control" name="active" id="active">
                                    <option value="">Please Select type</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Description</label>
                                <textarea class="form-control" id="description" placeholder="Enter Description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn bg-primary">Submit</button>  
                </div>
            </form>
        </div>
    </div>
</div>

<div id="edit_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Coupon</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <form action="#" id="updateCoupen">
                <div class="modal-body">
                    <input type="hidden" name="id" class="id">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Coupen</label>
                                <input type="text" placeholder="coupon_code" class="form-control coupon_code" name="coupon_code">
                            </div>

                            <div class="col-sm-6">
                                <label>Type</label>
                                <select class="form-control type" name="type">
                                    <option value="">Please Select type</option>
                                    <option value="1">Percentage</option>
                                    <option value="2">Rupees</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Discount</label>
                                <input type="number" placeholder="discount" class="form-control discount"  name="discount">
                            </div>

                            <div class="col-sm-6">
                                <label>Max Discount</label>
                                <input type="number" placeholder="max_discount" class="form-control max_discount"  name="max_discount">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Start Date</label>
                                  <input type="text" class="form-control start_date" placeholder="Start Date&hellip;" name="start_date" >
                                
                            </div>

                            <div class="col-sm-6">
                                <label>Expiry Date</label>
                                  <input type="text" class="form-control expiry_date" placeholder="Expiry Date&hellip;" name="expiry_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>No of coupon</label>
                                  <input type="number" class="form-control available_coupons" placeholder="No of coupon" name="available_coupons">
                            </div>

                            <div class="col-sm-6">
                                <label>Minimum Bill Amount</label>
                                  <input type="number" class="form-control minimum_bill_amount" placeholder="Minimum Bill Amount" name="minimum_bill_amount" >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Active</label>
                                <select class="form-control active" name="active">
                                    <option value="">Please Select type</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Description</label>
                                <textarea class="form-control description" placeholder="Enter Description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn bg-primary">Submit</button>
                    
                </div>
            </form>
        </div>
    </div>
</div>



<!-- /Edit modal -->

<script type="text/javascript">
    $(document).ready(function() {

        
                    var table = $('#coupon-list').DataTable({
            "autoWidth": true,
            "scrollY": '50vh',
            "scrollX": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
             "dom" : 'Blfrtip',
                         "buttons": [
                               {
                                   "extend": 'excelHtml5',
                                   "title" : 'Coupon',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'csv',
                                   "title" : 'Coupon',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'pdfHtml5',
                                   "title" : 'Coupon',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                 "extend"  : 'print',
                                 "title"   : 'Coupon',
                                 "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                "extend" : 'colvis'
                               }
                         ]
        });

                    //submit contact form
                    $('#coupen_form').submit(function(e){
                        e.preventDefault();
                        var base_url = $('#base_url').val();
                        var formData = new FormData($(this)[0]);
                         $.ajax({
                                type:'post',
                                data:formData,
                                url: base_url+'Coupon/addCoupen',
                                processData: false,
                                contentType: false,
                                success:function(data){
                                    var obj = $.parseJSON(data);
                                   
                                    if(obj.errCode == -1){
                                        alert('Added Successfully');
                                        window.location.reload();
                                    }else if(obj.errCode == 2){
                                        alert('Error Occur');
                                    }else{
                                        
                                        $('.error').remove();
                                        $.each(obj.message,function(key,value){
                                            
                                            var element = $('#'+key);
                                            element.closest('.form-control').after(value);
                                        });
                                    }
                                }

                            });
                    });

                    $(document).on('click', '.editcoupen', function() {
                        var base_url = $('#base_url').val();
                        var id = $(this).attr('id');
                        $.ajax({
                            type: 'post',
                            data: {
                                id: id
                            },
                            url: base_url + 'Coupon/editcoupen',
                            success: function(data) {
                                var obj = $.parseJSON(data);
                                if (obj.errCode == -1) {
                                    $('.id').val(obj.data.id);
                                    $('.coupon_code').val(obj.data.coupon_code);
                                    $('.start_date').val(obj.data.start_date);
                                    $('.expiry_date').val(obj.data.expiry_date);
                                    $('.type').val(obj.data.type);
                                    $('.discount').val(obj.data.discount);
                                    $('.max_discount').val(obj.data.max_discount);
                                    $('.available_coupons').val(obj.data.available_coupons);
                                    $('.minimum_bill_amount').val(obj.data.minimum_bill_amount);
                                    $('.active').val(obj.data.active);
                                    $('.description').val(obj.data.description);
                                } else if(obj.errCode == 2){
                                    alert(obj.data);
                                }else if(obj.errCode == 3){
                                    alert('Inputs are not valid');
                                }

                            }

                        });
                        });

                        $('#updateCoupen').submit(function(e) {
                        e.preventDefault();
                        var form_data = new FormData($(this)[0]);
                        var base_url = $('#base_url').val();
                        $.ajax({
                            type: 'post',
                            data: form_data,
                            processData: false,
                            contentType: false,
                            url: base_url + 'Coupon/updateCoupon',
                            success: function(data) {
                                var obj = $.parseJSON(data);
                                if (obj.errCode == -1) {
                                    alert(obj.message);
                                    location.reload();
                                }else if(obj.errCode == 2){
                                    alert(obj.message);
                                } else if(obj.errCode == 3){
                                    $('.error').remove();
                                    $.each(obj.message,function(key,value){
                                        
                                        var element = $('.'+key);
                                        element.closest('.form-control').after(value);
                                    });
                                }

                            }

                        });

                        });


                        //get mobile number list
                        var base_url = $('#base_url').val();

                        // $( "#customer_id" ).autocomplete({
                        //     source: function(request, response) {
                        //          $.ajax({  
                        //          url : base_url+'Admin/getCustomerId?',
                        //          data: { mobile : request.term},
                        //          dataType: "json",
                        //          type: "POST",
                        //          beforeSend: function(){
                        //                     $('.loader').show()
                        //             },
                        //             complete: function(){
                        //                     $('.loader').hide();
                        //             },
                        //          success: function(data){
                        //             response(data.items);
                        //          } 

                        //          });
                        //      },
                        //      minLength: 3
                        //   });

                         $('#check_discount').on('blur', function() {

                            var customer_id = $('#customer_id').val();
                            var bill_number = $('#bill_number').val();
                            var coupen_id = $('#coupen_id').val();
                            var max_discount = $('.check_discount').val();
                            var base_url = $('#base_url').val();
                            $.ajax({
                                type: 'post',
                                data: {coupen_id:coupen_id,customer_id:customer_id,bill_number:bill_number,check_discount:max_discount},
                                url: base_url + 'Admin/checkDiscount',
                                success: function(data) {
                                    var obj = $.parseJSON(data);
                                    if (obj.errCode == -1) {
                                        $('.show_discount').val(obj.message);
                                        $('.submit_button').removeAttr('disabled');
                                    }else if(obj.errCode == 3){
                                        $('.error').remove();
                                        $.each(obj.message,function(key,value){
                                            
                                            var element = $('.'+key);
                                            element.closest('.form-control').after(value);
                                        });
                                    }

                                }

                            });
                        });


                         //add coupen usage
                         $('#add_coupen_usage').submit(function(e) {
                            e.preventDefault();
                            var form_data = new FormData($(this)[0]);
                            var base_url = $('#base_url').val();
                            $.ajax({
                                type: 'post',
                                data: form_data,
                                processData: false,
                                contentType: false,
                                url: base_url + 'Coupon/addCoupenUsage',
                                success: function(data) {
                                    var obj = $.parseJSON(data);
                                    if (obj.errCode == -1) {
                                        alert(obj.message);
                                        window.location.href = base_url+"Coupon/couponUsage";
                                    }else if(obj.errCode == 2){
                                        alert(obj.message);
                                    } else if(obj.errCode == 3){
                                        $('.error').remove();
                                        $.each(obj.message,function(key,value){
                                            
                                            var element = $('.'+key);
                                            element.closest('.form-control').after(value);
                                        });
                                    }

                                }

                            });

                            });
                    
                });

    

</script>
