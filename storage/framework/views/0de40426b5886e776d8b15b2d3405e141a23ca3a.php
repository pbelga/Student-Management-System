                        <div class="pull-right">
                            <?php echo e($FacultyInformation ? $FacultyInformation->links() : ''); ?>

                        </div>
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($FacultyInformation): ?>
                                    <?php $__currentLoopData = $FacultyInformation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($data->last_name . ' ' .$data->first_name . ' ' . $data->middle_name); ?></td>
                                            <td><?php echo e($data->user->username); ?></td>
                                            <td><?php echo e((collect(\App\FacultyInformation::DEPARTMENTS)->firstWhere('id', $data->department_id)['department_name'])); ?></td>
                                            <td><?php echo e($data->status == 1 ? 'Active' : 'Inactive'); ?></td>
                                            <td>
                                                <div class="input-group-btn pull-left text-left">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action
                                                        <span class="fa fa-caret-down"></span></button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#" class="js-btn_update_sy" data-id="<?php echo e($data->id); ?>">Edit</a></li>
                                                        <li><a href="#" class="js-btn_deactivate" data-id="<?php echo e($data->id); ?>">Deactivate</a></li>
                                                        <li><a href="#" class="js-btn_view_additional_info" data-id="<?php echo e($data->id); ?>">View Information</a></li>
                                                    </ul>>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>