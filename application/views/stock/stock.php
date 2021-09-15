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
                            <li><a href="#.html">Stock</a></li>
                            <li class="active">Stock List</li>
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
                            
                            </div>
                        </div>


                        <table class="table" id="list">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Action</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Packging Size</th>
                                    <th>Stock In</th>
                                    <th>Stock Out</th>
                                    <th>Remaning Stock</th>
                                    
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
<div id="edit_modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">Category form</h5>
            </div>

            <form action="#" method="post" id="update">
                
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Product Name</label>
                                <select class="form-control select product_id" name="product_id">
                                    <option value="">Please Select Product</option>
                                    <?php if(isset($products) && !empty($products)){
                                        foreach($products as $p){?>
                                        <option value="<?php echo $p['id'] ?>"><?php echo $p['product_name'] ?></option>
                                    <?php } }?>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                    <label>Stock</label>
                                    <input type="number" name="stock" class="form-control stock">
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


<script>
$(document).ready(function(){
        
        var table = $('#list').DataTable({
            "processing": true,
            "serverSide": true,
            "autoWidth": true,
            "scrollY": '50vh',
            "scrollX": true,
            // "stateSave": true,
            "stateDuration":-1,
            "paging" : true,
            "select": {
                 'style': 'multi'
            },
            "order": [],
            "ajax": {
                "url": "<?php echo base_url('Stock/getStockListDetails/'); ?>",
                "type": "POST",
            },
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
                         "columnDefs": [{
                "targets": 0,
                'searchable': false,
                'orderable': false,
                'checkboxes': {
                   'selectRow': true
                }
            },
            {
                "name": "sr_no",
                "orderable": false,
                'searchable': false,
                "targets": 1
            },
            {
                "name": "action",
                "orderable": false,
                'searchable': false,
                "targets": 2
            },
            {
                "name": "image",
                "targets": 3
            },
            {
                "name": "product_name",
                "targets": 4
            },
            {
                "name": "packaging_size",
                "targets": 4
            },
            {
                "name": "stock_in",
                "orderable" : false,
                "targets": 5
            },
            {
                "name": "stock_out",
                "targets": 6
            },
            {
                "name": "remaning_stock",
                "targets": 6
            },
            {
                "name": "created_at",
                "targets": 7
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

        var state = table.state.loaded();
            if (state) {
                table.columns().eq(0).each(function(colIdx) {
                    var colSearch = state.columns[colIdx].search;
                    
                    if (colSearch.search) {
                        $('input', table.column(colIdx).header()).val(colSearch.search);
                        $('select', table.column(colIdx).header()).val(colSearch.search.slice(1, -1));


                        table.search(colSearch.search).draw(); 
                    }
                });

                
            }

     

      

        $('#add').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            var ids = [];
            
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Stock/updateStock',
                success: function(data) {
                    window.location.reload();
                }

            });

        });

        $('#update').submit(function(e) {
            e.preventDefault();
            var form_data = new FormData($(this)[0]);
            var base_url = $('#base_url').val();
            var ids = [];
            
            $.ajax({
                type: 'post',
                data: form_data,
                processData: false,
                contentType: false,
                url: base_url + 'Stock/updateStock',
                success: function(data) {
                    alert('Update Stock Successfully');
                    window.location.reload();
                }

            });

        });


        $(document).on('click','.edit',function(){
            
                var id = $(this).attr('id');
                var base_url = $('#base_url').val();
                $.ajax({
                        type: 'post',
                        data: {id: id},
                        url: base_url + 'Stock/editStock/',
                        success: function(data) {
                            var obj = $.parseJSON(data);
                            if (obj.errCode == -1) {
                                
                            $(".stock").val(obj.message.remaning_stock);
                            $(".product_id").val(obj.message.product_id).trigger('change');
                            } else if (obj.errCode == 2) {
                                alert(obj.message);
                            } else if (obj.errCode == 3) {
                                alert('Inputs are not valid');
                            }

                        }

                    });
            
        });


    });
</script>

<!-- / -->