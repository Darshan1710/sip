<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <link href="<?php echo base_url()  ?>css/daterangepicker.css" rel="stylesheet">
    <script src="<?php echo base_url() ?>js/moment.min.js"></script>
    <script src="<?php echo base_url() ?>js/daterangepicker.js"></script>

    <!-- Theme JS files --> 
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/tables/datatables/extensions/responsive.min.js"></script>
    <script src="<?php echo base_url() ?>js/plugins/forms/selects/select2.min.js"></script>

    <script src="<?php echo base_url() ?>js/plugins/extensions/interactions.min.js"></script>

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
                            <h6 class="card-title">Product Name :<code><?php echo $products['product_name'] ?></code></h6>
                        </div>
                        

                        <table class="table" id="purchase_reports">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Rate</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Created At</th>
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
<input type="hidden" name="uri_segment_id" value="<?php echo $this->uri->segment(3); ?>" id="uri_segment_id">
<script type="text/javascript">
    $(document).ready(function() {


        $('#purchase_reports thead th').each(function() {
            var i = 0;
            var title = $(this).text();
            if (title == 'Sr. No.') {

            }else if(title == 'Created At'){
                $(this).html(title + '<input type="text" class="col-search-input" id="created_at_picker">');
            }
        });

        var uri_segment_id = $('#uri_segment_id').val();
        var base_url = $('#base_url').val();
        var url      = base_url+'Purchase/getPurchaseProductReportsList/'+uri_segment_id;
        var table = $('#purchase_reports').DataTable({
            "processing": true,
            "serverSide": true,
            "scrollY": '50vh',
            "order": [],
            "ajax": {
                "url": url,
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
                "name": "rate",
                "targets": 1
            },
            {
                "name": "qty",
                "targets": 2
            },
            {
                "name": "price",
                "targets": 3,
            },
            {
                "name": "created_at",
                "targets": 4,
                "orderable": false
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

        //created at picker
       $('#created_at_picker').daterangepicker({
          autoUpdateInput: false,
          locale: {
              cancelLabel: 'Clear'
          },
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')]
            }
      });

      $('#created_at_picker').on('apply.daterangepicker', function(ev, picker) {
          $('#created_at_picker').daterangepicker({
              startDate : picker.startDate.format('MM/DD/YYYY'),
              endDate : picker.endDate.format('MM/DD/YYYY'),
              locale: {
                  cancelLabel: 'Clear'
                },
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')]
                }
          });
      });

      $('#created_at_picker').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
      });

    });
</script>





