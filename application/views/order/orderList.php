<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo TITLE; ?></title>

    <!-- Global stylesheets -->
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

    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
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
                            <li><a href="#.html">Order</a></li>
                            <li class="active">Order List</li>
                        </ul>
                    </div>
                </div>
                <!-- /page header -->


                <!-- Content area -->
                <div class="content">

                    <!-- Basic responsive configuration -->
                    <div class="panel panel-flat">
                        <div class="panel-heading">
                            <!-- <a class="btn btn-sm btn-success" href="<?php echo base_url()?>Order/orderForm"><i class="icon-home4"></i> Add Order</a> -->
                            <div class="col-md-2" style="margin-bottom: 10px">
                             <a>
                                <select class="form-control select" name="status" id="status">
                                    <option value="">Please Select Section</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Delivered</option>
                                        <option value="3">Cancelled</option>
                                        <option value="4">Damaged</option>
                                        <option value="5">Out</option>
                                </select>
                            </a>

                            </div>
                        </div>
                        

                        <table class="table" id="order_list">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot align="right">
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
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

        $(document).on('click','.cancel_order',function(){
            if(confirm('Are you sure you want to cancel ?')){
                id = $(this).attr('id');
                href = $(this).data('url');
                window.location.href = href;
            }
            
        });

        
        // $(document).on('click','.deliver_order',function(){
        //     if(confirm('Are you sure you want to cancel ?')){
        //         id = $(this).attr('id');
        //         href = $(this).data('url');
        //         window.location.href = href;
        //     }
            
        // });


        $('#order_list thead th').each(function() {
            var i = 0;
            var title = $(this).text();
            if (title == 'Sr. No.' || title == 'Order' || title == 'Action') {

            }else if(title == 'Status'){
                               $(this).html(title+'<select class="col-search-input">'+
                                '<option value="">All</option>'+
                                '<option value="1">Pending</option>'+
                                '<option value="2">Delivered</option>'+
                                '<option value="3">Damaged</option>'+
                                '<option value="4">Canceled</option>'+
                                '<option value="5">Out</option>'+
                                '</select>');
            }else if(title == 'Payment Status'){
                $(this).html(title+'<select class="col-search-input">'+
                                

                                '<option value="">All</option>'+
                                '<option value="1">No Payment</option>'+
                                '<option value="2">Partial</option>'+
                                '<option value="3">Done</option>'+
                                '</select>');
            }else if(title == 'Created At'){
                $(this).html(title + '<input type="text" class="col-search-input" id="created_at_picker">');
            } else {
                $(this).html(title + '<input type="text" class="col-search-input" />');
            }
        });

    
        var table = $('#order_list').DataTable({
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var monTotal = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                
                
            // Update footer by showing the total with the reference of the column index 
            $( api.column( 0 ).footer() ).html('Total');
            $( api.column( 4 ).footer() ).html(monTotal);
            },
            "processing": true,
            "serverSide": true,
            "autoWidth": true,
            "scrollY": '50vh',
            "scrollX": true,
            "order": [],
            "select": {
                 'style': 'multi'
            },
            "ajax": {
                "url": "<?php echo base_url('Order/getOrderList/'); ?>",
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
                "targets": 0,
                'searchable': false,
                'orderable': false,
                'checkboxes': {
                   'selectRow': true
                }
            },
            {
                "name": "sr_no",
                "targets": 1
            },
            {
                "name": "c.name",
                "targets": 2
            },
            {
                "name": "c.mobile",
                "targets": 3
            },
            {
                "name": "c.email",
                "targets": 4
            },
            {
                "name": "order_id",
                "targets": 5
            },
            {
                "name": "order_status",
                "targets": 6,
                "orderable": false
            },
            {
                "name": "payment_status",
                "targets": 7,
                "orderable": false
            },
            {  "name": "o.created_at",
               "targets": 8,
               "orderable": false }

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

      //form
        $('#add').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Package/addPackageEnquiry',
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
                            if(key == 'package'){
                                element.closest('.select').next('.select2').after(value);
                            }else{
                                element.closest('.form-control').after(value);
                            }
                            
                        });
                    }

                }

            });

        });

        $(document).on('click', '.editPackageEnquiry', function() {
            var base_url = $('#base_url').val();
            var id = $(this).attr('id');
            $.ajax({
                type: 'post',
                data: {
                    id: id
                },
                url: base_url + 'Package/editPackageEnquiry',
                success: function(data) {
                    var obj = $.parseJSON(data);
                    if (obj.errCode == -1) {
                        $('.id').val(id);
                        $('.name').val(obj.data.name);
                        $('.email').val(obj.data.email);
                        $('.mobile').val(obj.data.mobile);
                        $('.no_of_adults').val(obj.data.no_of_adults);
                        $('.no_of_childrens').val(obj.data.no_of_childrens  );
                        $('.package_id').select2().select2('val',obj.data.package_id);
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
                url: base_url + 'Package/updatePackageEnquiry',
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
                            if(key == 'package'){
                                element.closest('.select').next('.select2').after(value);
                            }else{
                                element.closest('.form-control').after(value);
                            }
                        });
                    }

                }

            });

        });

        $(document).on('click','.deliver_order',function(){

            if(confirm('Are you sure want to change the status?')){
                var id = $(this).data('id');
                var base_url = $('#base_url').val();
                $.ajax({
                        type: 'post',
                        data: {id: id},
                        url: base_url + 'Order/deliveredOrder/',
                        success: function(data) {
                            var obj = $.parseJSON(data);
                            if (obj.errCode == -1) {
                                window.location.reload();
                            } else if (obj.errCode == 2) {
                                alert(obj.message);
                            } else if (obj.errCode == 3) {
                                alert('Inputs are not valid');
                            }

                        }

                    });
            }
        });

        $('#status').on('change', function(e) {
        if(confirm('Are you sure you want to change the status?')){
            e.preventDefault();
            var base_url = $('#base_url').val();
            var selectedIds = table.columns().checkboxes.selected()[0];
            var ids = selectedIds.toString();
            var status = $('#status').val();

            $.ajax({
                type: 'post',
                data: {
                    ids: ids,
                    status: status
                },
                url: base_url + 'Order/changeDeliveryStatus',
                success: function(data) {
                    //alert('success');
                    $("input[type=checkbox]").prop("checked", false);
                    table.state.clear();
                    window.location.reload();
                }

            });    
        }
        

    });

    });
</script>

