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
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo base_url() ?>js/plugins/loaders/pace.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>js/core/libraries/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/extensions/responsive.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>

    <script src="<?php echo base_url() ?>js/app.js"></script>
    <script src="<?php echo base_url() ?>js/custom.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/form_select2.js"></script>
    <script src="<?php echo base_url() ?>js/demo_pages/datatables_responsive.js"></script>
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
                            <li><a href="#.html">Supplier</a></li>
                            <li class="active">Supplier List</li>
                        </ul>


                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <a class="btn btn-sm btn-success" href="#" data-target="#add_modal" data-toggle="modal"><i class="icon-home4"></i> Add Supplier</a>
                        </div>
                        

                        <table class="table datatable-responsive" >
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(isset($supplier)) {
                                    $i = 1;
                                      foreach($supplier as $row){
                                      
                                ?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['mobile']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td><?php if($row['status'] == 1){
                                        echo '<button class="btn btn-primary btn-sm">Active</button>';
                                    }else{ 
                                        echo '<button class="btn btn-primary btn-sm">Disabled</button>';
                                    }?></td>
                                    <td><?php echo date('d-m-Y',strtotime($row['created_at']));?></td>
                                    <td class="text-center">
                                        <ul class="icons-list">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="#" id="<?php echo $row['id'] ?>" data-toggle="modal" data-target="#edit_modal" class="editSupplier"><i class="icon-file-pdf"></i> Edit</a></li>
                                                    <li><a href="#" id="<?php echo $row['id']?>" class="delete" data-url="<?php echo base_url()?>Supplier/deleteSupplier/<?php echo $row['id']?>"><i class="icon-file-excel"></i> Delete</a></li>
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
    <!-- /page container -->

</body>
</html>
<div id="add_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Supplier form</h5>
            </div>

            <form action="#" method="post" id="add">
              
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Name</label>
                                <input type="text" placeholder="Name" class="form-control" name="name" id="name">
                            </div>
                            <div class="col-sm-6">
                                <label>Email</label>
                                <input type="text" placeholder="Email" class="form-control" name="email" id="email">
                            </div>
                            

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Mobile</label>
                                <input type="number" placeholder="Mobile" class="form-control" name="mobile" id="mobile" maxlength="10" minlength="10">
                            </div>
                            <div class="col-sm-6">
                                <label>Address:</label>
                                <input type="text" placeholder="Address" class="form-control" name="address" id="address">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Status</label>
                                <select class="form-control select" name="status" id="status">
                                    <option value="">Please Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit form</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="edit_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Supplier form</h5>
            </div>

            <form action="#" method="post" id="update">
                <input type="hidden" name="id" value="" class="id">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Name</label>
                                <input type="text" placeholder="Name" class="form-control name" name="name">
                            </div>
                            <div class="col-sm-6">
                                <label>Email</label>
                                <input type="text" placeholder="Email" class="form-control email" name="email">
                            </div>
                            

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Mobile</label>
                                <input type="number" placeholder="Mobile" class="form-control mobile" name="mobile" maxlength="10" minlength="10">
                            </div>
                            <div class="col-sm-6">
                                <label>Address:</label>
                                <input type="text" placeholder="Address" class="form-control address" name="address">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Status</label>
                                <select class="form-control select status" name="status" >
                                    <option value="">Please Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit form</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        //add Accressories

        $('#add').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Supplier/addSupplier',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        alert(obj.message);
                        location.reload();
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {
                            var element = $('#' + key);
                            if(key == 'status'){
                                element.closest('.select').next('.select2').after(value);
                            }else{
                                element.closest('.form-control').after(value);
                            }
                            
                        });
                    }

                }

            });

        });

        $(document).on('click', '.editSupplier', function() {
            var base_url = $('#base_url').val();
            var id = $(this).attr('id');
            $.ajax({
                type: 'post',
                data: {
                    id: id
                },
                url: base_url + 'Supplier/editSupplier',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        $('.id').val(id);
                        $('.name').val(obj.data.name);
                        $('.email').val(obj.data.email);
                        $('.mobile').val(obj.data.mobile);
                        $('.address').val(obj.data.address);
                        $('.status').select2().select2('val',obj.data.status);
                    } else if (obj.errCode == 2) {
                        alert(obj.data);
                    } else if (obj.errCode == 3) {
                        alert('Inputs are not valid');
                    }

                }

            });
        });

        $('#update').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Supplier/updateSupplier',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        alert(obj.message);
                        location.reload();
                    } else if (obj.errCode == 2) {
                        alert(obj.message);
                    } else if (obj.errCode == 3) {
                        $('.error').remove();
                        $.each(obj.message, function(key, value) {

                            var element = $('.' + key);
                            if(key == 'status'){
                                element.closest('.select').next('.select2').after(value);
                            }else{
                                element.closest('.form-control').after(value);
                            }
                        });
                    }

                }

            });

        });

    });
</script>