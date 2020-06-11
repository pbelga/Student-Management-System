<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
                <div class="box-body">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        
                        <h4 style="margin-right: 5em;" class="modal-title">
                            <?php echo e($StudentInformation ? 'Edit Student Information' : 'Add Student Information'); ?>

                        </h4>

                        <div style="margin-top: 3em; margin-bottom: 3em" class="col-md-10 col-md-offset-1">
                                <center>
                                <?php if($Profile): ?>
                                    <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="<?php echo e($Profile->photo ? \File::exists(public_path('/img/account/photo/'.$Profile->photo)) ? asset('/img/account/photo/'.$Profile->photo) : asset('/img/account/photo/blank-user.gif') : asset('/img/account/photo/blank-user.gif')); ?>" style="width:150px; height:150px;  border-radius:50%;">
                                <?php else: ?>
                                    <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="<?php echo e(asset('/img/account/photo/blank-user.png')); ?>" style="width:150px; height:150px;  border-radius:50%;">
                                <?php endif; ?>    
                                <h2><?php echo e($Profile ? $Profile->first_name : 'User'); ?>'s Profile</h2>
                                <div class="box-body">
                                    
                    
                                    
                                        <button type="button" class="btn btn-flat btn-success btn--update-photo" title="Change photo">
                                            browse
                                        </button>
                                    </center>
                                        <form class="hidden" id="form_user_photo_uploader">
                                            <input type="file" id="user--photo" name="user_photo">
                                            <input type="hidden" name="id" value="<?php echo e($StudentInformation ? $StudentInformation->id : ''); ?>">
                                            <button type="submit">fsdfasd</button>
                                        </form>
                                </div>
                        </div>
                </div>

           
                
           
            <form id="js-form_subject_details">
                <?php echo e(csrf_field()); ?>

                                
                <?php if($StudentInformation): ?>
                    <input type="hidden" name="id" value="<?php echo e($StudentInformation->id); ?>">
                <?php endif; ?>
                
                <div class="modal-body">
                       
                        
                        
                            
                    <div class="form-group">
                        <label for="">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo e($StudentInformation ? $StudentInformation->user->username : ''); ?>">
                        <div class="help-block text-red text-center" id="js-username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">First name</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo e($StudentInformation ? $StudentInformation->first_name : ''); ?>">
                        <div class="help-block text-red text-center" id="js-first_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Middle name</label>
                        <input type="text" class="form-control" name="middle_name" value="<?php echo e($StudentInformation ? $StudentInformation->middle_name : ''); ?>">
                        <div class="help-block text-red text-center" id="js-middle_name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Last name</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo e($StudentInformation ? $StudentInformation->last_name : ''); ?>">
                        <div class="help-block text-red text-center" id="js-last_name">
                        </div>
                    </div>
                    <div class="form-group">
                            <label for="">Parent/Guardian</label>
                            <input type="text" class="form-control" name="guardian" value="<?php echo e($StudentInformation ? $StudentInformation->guardian : ''); ?>">
                            <div class="help-block text-red text-center" id="js-guardian">
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="">Address <small class="text-red">Optional</small></label>
                        <input type="text" class="form-control" name="address" value="<?php echo e($StudentInformation ? $StudentInformation->c_address : ''); ?>">
                        <div class="help-block text-red text-center" id="js-address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Age June</label>
                        <input type="text" class="form-control" name="age_june" value="<?php echo e($StudentInformation ? $StudentInformation->age_june : ''); ?>">
                        <div class="help-block text-red text-center" id="js-age_june">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Age May</label>
                        <input type="text" class="form-control" name="age_may" value="<?php echo e($StudentInformation ? $StudentInformation->age_may : ''); ?>">
                        <div class="help-block text-red text-center" id="js-age_may">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Date of Birth <small class="text-red">Optional</small></label>
                        
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="birthdate" class="form-control pull-right" id="datepicker"
                             value="<?php echo e($StudentInformation ? date_format(date_create($StudentInformation->birthdate), 'F d, Y') : ''); ?>">
                        </div>
                        <div class="help-block text-red text-center" id="js-birthdate">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Gender </label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">Select gender</option>
                            <option value="1" <?php echo e($StudentInformation ? $StudentInformation->gender == 1 ? 'selected' : '' : ''); ?>>Male</option>
                            <option value="2" <?php echo e($StudentInformation ? $StudentInformation->gender == 2 ? 'selected' : '' : ''); ?>>Female</option>
                        </select>
                        <div class="help-block text-red text-center" id="js-gender">
                        </div>
                    </div>

                    <?php if($StudentInformation): ?>
                        <?php if($StudentInformation->id): ?>
                            <div class="form-group">
                                <label for="">Email address</label>
                                <input type="text" class="form-control" name="email" value="<?php echo e($StudentInformation ? $StudentInformation->user->email : ''); ?>">
                                <div class="help-block text-red text-center" id="js-email">
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-flat">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->