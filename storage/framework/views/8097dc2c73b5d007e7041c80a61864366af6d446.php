<?php $__env->startSection('content_title'); ?>
    Payment Category
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="box">
        <div class="box-header with-border">
            
            <form id="js-form_search">
                <?php echo e(csrf_field()); ?>

                
                
                <button type="button" class="pull-right btn btn-flat btn-danger btn-sm" id="js-button-add"><i class="fa fa-plus"></i> Add</button>
            </form>
        </div>
        <div class="overlay hidden" id="js-loader-overlay"><i class="fa fa-refresh fa-spin"></i></div>
        <div class="box-body">
            <div class="js-data-container">
                <?php echo $__env->make('control_panel_finance.maintenance.payment_category.partials.data_list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        
        var page = 1;
        function fetch_data () {
            var formData = new FormData($('#js-form_search')[0]);
            formData.append('page', page);
            loader_overlay();
            $.ajax({
                url : "<?php echo e(route('finance.maintenance.payment_category')); ?>",
                type : 'POST',
                data : formData,
                processData : false,
                contentType : false,
                success     : function (res) {
                    loader_overlay();
                    $('.js-data-container').html(res);
                }
            });
        }
        $(function () {
            $('body').on('click', '#js-button-add, .js-btn_update', function (e) {
                e.preventDefault();
                
                var id = $(this).data('id');
                $.ajax({
                    url : "<?php echo e(route('finance.maintenance.payment_category.modal_data')); ?>",
                    type : 'POST',
                    data : { _token : '<?php echo e(csrf_token()); ?>', id : id },
                    success : function (res) {
                        $('.js-modal_holder').html(res);
                        $('.js-modal_holder .modal').modal({ backdrop : 'static' });
                    }
                });
            });

            $('body').on('submit', '#js-form_payment_category', function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url         : "<?php echo e(route('finance.maintenance.payment_category.save_data')); ?>",
                    type        : 'POST',
                    data        : formData,
                    processData : false,
                    contentType : false,
                    success     : function (res) {
                        $('.help-block').html('');
                        if (res.res_code == 1)
                        {
                            for (var err in res.res_error_msg)
                            {
                                $('#js-' + err).html('<code> '+ res.res_error_msg[err] +' </code>');
                            }
                        }
                        else
                        {
                            $('.js-modal_holder .modal').modal('hide');
                            fetch_data();
                        }
                    }
                });
            });

            $('body').on('submit', '#js-form_search', function (e) {
                e.preventDefault();
                fetch_data();
            });
            $('body').on('click', '.pagination a', function (e) {
                e.preventDefault();
                page = $(this).attr('href').split('=')[1];
                fetch_data();
            });
            $('body').on('click', '.js-btn_deactivate', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                alertify.defaults.transition = "slide";
                alertify.defaults.theme.ok = "btn btn-primary btn-flat";
                alertify.defaults.theme.cancel = "btn btn-danger btn-flat";
                alertify.confirm('Confirmation', 'Are you sure you want to deactivate?', function(){  
                    $.ajax({
                        url         : "<?php echo e(route('finance.maintenance.payment_category.deactivate_data')); ?>",
                        type        : 'POST',
                        data        : { _token : '<?php echo e(csrf_token()); ?>', id : id },
                        success     : function (res) {
                            $('.help-block').html('');
                            if (res.res_code == 1)
                            {
                                show_toast_alert({
                                    heading : 'Error',
                                    message : res.res_msg,
                                    type    : 'error'
                                });
                            }
                            else
                            {
                                show_toast_alert({
                                    heading : 'Success',
                                    message : res.res_msg,
                                    type    : 'success'
                                });
                                $('.js-modal_holder .modal').modal('hide');
                                fetch_data();
                            }
                        }
                    });
                }, function(){  

                });
            });
            
            $('body').on('click', '.js-btn_toggle_current', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var toggle_title = $(this).data('toggle_title');
                alertify.defaults.transition = "slide";
                alertify.defaults.theme.ok = "btn btn-primary btn-flat";
                alertify.defaults.theme.cancel = "btn btn-danger btn-flat";
                alertify.confirm('Confirmation', 'Are you sure you want to '+toggle_title+' ?', function(){  
                    $.ajax({
                        url         : "<?php echo e(route('finance.maintenance.payment_category.toggle_current_sy')); ?>",
                        type        : 'POST',
                        data        : { _token : '<?php echo e(csrf_token()); ?>', id : id },
                        success     : function (res) {
                            $('.help-block').html('');
                            if (res.res_code == 1)
                            {
                                show_toast_alert({
                                    heading : 'Error',
                                    message : res.res_msg,
                                    type    : 'error'
                                });
                            }
                            else
                            {
                                show_toast_alert({
                                    heading : 'Success',
                                    message : res.res_msg,
                                    type    : 'success'
                                });
                                $('.js-modal_holder .modal').modal('hide');
                                fetch_data();
                            }
                        }
                    });
                }, function(){  

                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('control_panel.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>