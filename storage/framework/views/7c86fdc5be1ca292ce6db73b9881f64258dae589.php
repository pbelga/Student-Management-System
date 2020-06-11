<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="box-body">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                            
                        <h4 style="margin-right: 5em;" class="modal-title">
                            Student Payment Account Information
                        </h4>
                </div>
            
                <div class="modal-body">                    
                    <div class="row">                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Student Name</label>
                                <p><?php echo e($Modal_data->student->last_name.', '.$Modal_data->student->first_name.' '.$Modal_data->student->middle_name); ?></p>
                            </div> 
        
                            <div class="form-group">
                                <label for="">Student level</label>
                                <p><?php echo e($Modal_data->payment_cat->stud_category->student_category.'-'.$Modal_data->payment_cat->grade_level_id); ?></p>
                            </div>  

                            <div class="form-group">
                                <label for="">Email address</label>
                                <p><?php echo e($Modal_data->monthly->email); ?></p>
                            </div>  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Status</label><br/>
                                <span class="label <?php echo e($Modal_data->status ? $Modal_data->status ==0 ? 'label-success' : 'label-danger' : 'label-success'); ?>">
                                    <?php echo e($Modal_data->status ? $Modal_data->status == 0 ? 'Paid' : 'Not yet paid' : 'Paid'); ?>

                                    
                                </span>
                            </div>
                            <div class="form-group">
                                <label for="">Payment option</label>
                                <p><?php echo e($Modal_data->monthly->payment_option); ?></p>
                            </div>  
                            <div class="form-group">
                                <label for="">Phone number</label>
                                <p><?php echo e($Modal_data->monthly->number); ?></p>
                            </div>  
                        </div>
                    </div>
                                        
                    <div class="box">
                        <div class="box-header ">
                            <p class="box-title">
                                Student Account
                            </p>
                        </div>
                        
                        <div class="box-body no-padding">
                            <table class="table table-bordered table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <th style="width: 50%">Description</th>
                                        <th>Amount</th>
                                        
                                    </tr>
                                    <tr>
                                        <td>Tuition Fee</td>
                                        <td>
                                            ₱ <?php echo e(number_format($Modal_data->payment_cat->tuition->tuition_amt, 2)); ?>

                                        </td>                                
                                    </tr>
                                    <tr>
                                        <td>Misc Fee</td>
                                        <td>
                                            ₱ <?php echo e(number_format($Modal_data->payment_cat->misc_fee->misc_amt, 2)); ?>

                                        </td>                                
                                    </tr>
                                    <tr>
                                        <td>Other Fee - <?php echo e($other_fee ? $other_fee->other_name : 'NA'); ?></td>
                                        <td>
                                            ₱ <?php echo e(number_format($other, 2)); ?>

                                        </td>
                                    </tr>
                                    <?php $__currentLoopData = $Discount_amt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>Discount Fee (<?php echo e($item->discount_type); ?>)</td>
                                        <td>
                                            ₱ <?php echo e(number_format($item->discount_amt,2)); ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    <tr>
                                        <td>Total Fees</td>
                                        <td>  ₱
                                            <?php if($Discount): ?>
                                                 <?php echo e(number_format($total, 2)); ?>

                                            <?php else: ?>
                                                <?php echo e(number_format($total, 2)); ?>

                                            <?php endif; ?>                                                
                                        </td>                                
                                    </tr>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                     
                    
                    <h4>Transaction History</h4>
                    <div class="box">
                        <?php $__currentLoopData = $Mo_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                        
                            <div class="box-header ">
                                <p class="box-title">
                                    Date and Time: <?php echo e($data ? date_format(date_create($data->created_at), 'F d, Y h:i A') : ''); ?>

                                </p>
                                <br>Status: 
                                <span class="label <?php echo e($data->approval ? $data->approval == 'Approved' ? 'label-success' : 'label-danger' : 'label-danger'); ?>">
                                    <?php echo e($data->approval ? $data->approval == 'Approved' ? 'Approved' : 'Not yet Approved' : 'Not yet Approved'); ?>

                                </span>
                            </div>
                                
                            <div class="box-body no-padding">
                                <table class="table table-bordered table-striped table-hover">
                                    <tbody>
                                        <tr>
                                            <th style="width: 50%">Description</th>
                                            <th>Amount</th>
                                            
                                        </tr>
                                        <tr>
                                            <td>Payment Option</td>
                                            <td>
                                                <?php echo e($data->payment_option); ?>

                                            </td>                                
                                        </tr>
                                            <td>Tuition Fee</td>
                                            <td>
                                                ₱ <?php echo e(number_format($data->payment, 2)); ?>

                                            </td>                                
                                        </tr>
                                        <tr>
                                            <td>Misc Fee</td>
                                            <td>
                                                ₱ <?php echo e(number_format($data->balance, 2)); ?>

                                            </td>                                
                                        </tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="lightbox-target" id="img_receipt<?php echo e($data->receipt_img); ?>">
                                <img src="<?php echo e($data->receipt_img ? \File::exists(public_path('/img/receipt/'.$data->receipt_img)) ?
                                    asset('/img/receipt/'.$data->receipt_img) : 
                                    asset('/img/receipt/blank-user.gif') :
                                    asset('/img/receipt/blank-user.gif')); ?>"/>
                                <a class="lightbox-close" href="#"></a>
                            </div>
                        
                            <?php if($data->payment_option != 'Credit Card/Debit Card'): ?>
                                <div class="form-group" style="margin-top: 10px">
                                    <label for="">Image Receipt <small>(Click to zoom)</small></label>
                                    <a class="lightbox" href="#img_receipt<?php echo e($data->receipt_img); ?>">
                                        <img class="img-responsive" 
                                        id="img-receipt"
                                        src="<?php echo e($data->receipt_img ? \File::exists(public_path('/img/receipt/'.$data->receipt_img)) ?
                                        asset('/img/receipt/'.$data->receipt_img) : 
                                        asset('/img/receipt/blank-user.gif') :
                                        asset('/img/receipt/blank-user.gif')); ?>" 
                                        alt="User profile picture">
                                    </a>
                                </div> 
                            <?php endif; ?>
                                                    
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                        <div class="modal-footer">
                        <button class="btn btn-flat  btn-<?php echo e($Modal_data->status ? $Modal_data->status == 0 ? 'danger btn-unpaid' : 'success btn-paid' : 'danger btn-unpaid'); ?> pull-right" data-id="<?php echo e($Modal_data->id); ?>">
                                <?php echo e($Modal_data->status ? $Modal_data->status == 0 ? 'Unpaid' : 'Paid' : 'Unpaid'); ?>

                            </button>
                        </div> 
                    </div> 
                                       
                </div>
                
            </div>   
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->