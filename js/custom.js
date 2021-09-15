$(document).ready(function(){
	$(document).on('click','.delete',function(){
        
		if(confirm('Are you sure?')){
			var id = $(this).attr('id');
			var tablename = $(this).data('table');
			var base_url = $('#base_url').val();
            $.ajax({
                    type: 'post',
                    data: {id:id,tablename:tablename},
                    url: base_url+'Admin/delete',
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        alert(obj.message);
                        window.location.reload();
                    }

                });
		}
		
	});

    $('.delete_address').on('click',function(){
            
            var base_url = $('#base_url').val();
            var id = $(this).attr('id');

            if(confirm('Are you sure?')){
                $.ajax({
                    type: 'post',
                    data: {id:id},
                    url: base_url + 'Customer/delete',
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        if (obj.errCode == -1) {
                            
                            alert(obj.message);
                            window.location.reload();
                        } else if (obj.errCode == 2) {
                            alert(obj.message);
                        } else if (obj.errCode == 3) {
                            $('.error').remove();
                            $.each(obj.message, function(key, value) {
                                var element = $('#' + key);
                                element.closest('.form-control').after(value);
                                
                                
                            });
                        }else if(obj.errCode == 5){
                          $('.error-div').empty();
                          $('.error-div').append(obj.message);
                        }

                    }

                });
            }

        });

        $(document).on('click','.delete_all',function(){
            
            var base_url = $('#base_url').val();
            var tablename = $(this).attr('data-table');
            var type = $(this).attr('data-type');

            
            var ids = [];
            $('input[type=checkbox]:checked').each(function () {
                ids.push($(this).val());
            });
            
            console.log(ids);
            if(ids.length > 0){
            if(confirm('Are you sure?')){
                $.ajax({
                    type: 'post',
                    data: {ids:ids.toString(),tablename:tablename,type:type},
                    url: base_url+'Admin/massDelete',
                    success: function(data) {
                        var obj = $.parseJSON(data);
                        if (obj.errCode == -1) {
                            
                            alert(obj.message);
                            window.location.reload();
                        } else if (obj.errCode == 2) {
                            alert(obj.message);
                        } else if (obj.errCode == 3) {
                            $('.error').remove();
                            $.each(obj.message, function(key, value) {
                                var element = $('#' + key);
                                element.closest('.form-control').after(value);
                                
                                
                            });
                        }else if(obj.errCode == 5){
                          $('.error-div').empty();
                          $('.error-div').append(obj.message);
                        }

                    }

                });
            }
            }else{
                alert('Please Select Atleast one record');
            }

        });

        $("#select-all").click(function(){
            $('.check').not(this).prop('checked', this.checked);
        });

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