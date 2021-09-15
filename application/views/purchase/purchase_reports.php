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
                            <li><a href="#.html">Purchase</a></li>
                            <li class="active">Purchase List</li>
                        </ul>


                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <a class="btn btn-sm btn-success" href="<?php echo base_url() ?>Purchase/purchaseForm" ><i class="icon-home4"></i> Add Purchase</a>
                        </div>
                        

                        <table class="table" id="purchase_reports">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>
                            <tbody>

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
<script type="text/javascript">
    $(document).ready(function() {


    
        var table = $('#purchase_reports').DataTable({
            "processing": true,
            "serverSide": true,
            "scrollY": '50vh',
            "scrollX": true,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('Purchase/getPurchaseReportsList/'); ?>",
                "type": "POST",
            },
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
             "dom" : 'Blfrtip',
                         "buttons": [
                               {
                                   "extend": 'excelHtml5',
                                   "title" : 'Order',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'csv',
                                   "title" : 'Order',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                   "extend": 'pdfHtml5',
                                   "title" : 'Order',
                                   "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                 "extend"  : 'print',
                                 "title"   : 'Order',
                                 "exportOptions": {
                                        columns: [ 0, ':visible' ]
                                    }
                               },
                               {
                                "extend" : 'colvis'
                               }
                         ],
             "columnDefs": [
            {
                "name": "sr_no",
                "targets": 0
            },
            {
                "name": "image",
                "targets": 1
            },
            {
                "name": "product_name",
                "targets": 2
            },
            {
                "name": "qty",
                "targets": 3
            }

        ]
        });

        table.columns().search('');

        //draw table
        table.columns().every(function() {
            var table = this;

            $('input', this.header()).on('keyup change', function() {

                    if (table.search() !== this.value) {
                        table.search('')
                        table.columns().search('')
                        table.search(this.value).draw();  
                    }
                
            });

                 $('select', this.header()).on('change', function() {
                   if (table.search() !== this.value) {
                       table.search('')
                       table.columns().search('')
                       table.search(this.value).draw();
                   }
               });
        });



    });
</script>





