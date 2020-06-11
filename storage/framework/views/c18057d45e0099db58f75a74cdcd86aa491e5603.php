<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="js-form_disc_fee">
                <?php echo e(csrf_field()); ?>

                <?php if($DiscountFee): ?>
                    <input type="hidden" name="id" value="<?php echo e($DiscountFee->id); ?>">
                <?php endif; ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <?php echo e($DiscountFee ? 'Edit Discount Fee' : 'Add Discount Fee'); ?>

                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Discount Name</label>
                        <input type="text" class="form-control" name="disc_type" value="<?php echo e($DiscountFee ? $DiscountFee->disc_type : ''); ?>">
                        <div class="help-block text-red text-center" id="js-disc_type">
                        </div>
                    </div>

                    <div class="form-group">
                            <label for="">Discount Fee Amount</label>
                            <input type="number" class="form-control" name="disc_fee" value="<?php echo e($DiscountFee ? $DiscountFee->disc_amt : ''); ?>">
                            <div class="help-block text-red text-center" id="js-disc_fee">
                            </div>
                    </div>

                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->