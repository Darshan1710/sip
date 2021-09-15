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
                            <li><a href="#.html">Purchase</a></li>
                            <li class="active">Purchase Details</li>
                        </ul>


                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                           <h5 class="panel-title">Supplier Name : <?php echo isset($suppliers[0]['name']) ? $suppliers[0]['name'] : '' ?></h5>
                        </div>
                        

                        <table class="table datatable-responsive" >
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Sell Price</th>
                                    <th>Total</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($suppliers)) {
                                    $i = 1;
                                      foreach($suppliers as $row){
                                ?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['qty']; ?></td>
                                    <td><?php echo $row['rate']; ?></td>
                                    <td><?php echo $row['sell_price']; ?></td>
                                    <td><?php echo $row['total']; ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($row['created_at']));?></td>
                                </tr>
                                <?php 
                                    $i++;
                                    } } ?>
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

