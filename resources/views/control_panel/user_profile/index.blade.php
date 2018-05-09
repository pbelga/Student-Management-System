@extends('control_panel.layouts.master')

@section ('content_title')
    My Account
@endsection

@section ('content')
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">User Profile</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-flat btn-box-tool btn--update-profile">
                            <i class="fa fa-wrench"></i>
                        </button>
                    </div>
                </div>
                <div class="overlay hidden" id="js-loader-overlay"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="box-body">
                    <img class="profile-user-img img-responsive img-circle" src="https://adminlte.io/themes/AdminLTE/dist/img/user4-128x128.jpg" alt="User profile picture">
                    <h3 class="profile-username text-center">{{ $Profile->first_name . ' ' . $Profile->middle_name . ' ' .  $Profile->last_name }}</h3>
                    <p class="text-muted text-center">Faculty Member</p>
                    <div class="form-group">
                        <label for="">Department</label>
                        <div class="form-control">{{ collect(\App\FacultyInformation::DEPARTMENTS)->firstWhere('id', $Profile->department_id)['department_name'] }}</div>
                    </div>
                    <div class="form-group">
                        <label for="">Contact Number</label>
                        <div class="form-control">{{ $Profile->contact_number }}</div>
                    </div>
                    <div class="form-group">
                        <label for="">E-mail</label>
                        <div class="form-control">{{ $Profile->email }}</div>
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <div class="form-control">{{ $Profile->address }}</div>
                    </div>
                    <div class="form-group">
                        <label for="">Birthday</label>
                        <div class="form-control">{{ $Profile->birthday }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title">User Account</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-flat btn-box-tool btn-change-password" title="change password">
                            <i class="fa fa-wrench"></i>
                        </button>
                    </div>
                </div>
                

                <div class="overlay hidden" id="js-loader-overlay"><i class="fa fa-refresh fa-spin"></i></div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="">Username</label>
                        <div class="form-control">{{ $User->username }}</div>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <div class="form-control">******</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-change-pw-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form--change-password">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            Change Password
                        </h4>
                    </div>
                    <div class="modal-body">   
                                
                        <div class="form-group">
                            <label for="">Old Password</label>
                            <input type="password" class="form-control" name="old_password">
                        </div>
                        <div class="form-group">
                            <label for="">New Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
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
    
    <div class="modal fade modal-update-profile" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="form--update-profile">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">
                            Update Profile
                        </h4>
                    </div>
                    <div class="modal-body">   
                                
                        <div class="form-group">
                            <label for="">First name</label>
                            <input type="text" class="form-control" name="first_name">
                        </div>
                        <div class="form-group">
                            <label for="">Middle name</label>
                            <input type="text" class="form-control" name="middle_name">
                        </div>
                        <div class="form-group">
                            <label for="">Last name</label>
                            <input type="text" class="form-control" name="last_name">
                        </div>
                        <div class="form-group">
                            <label for="">Last name</label>
                            <input type="text" class="form-control" name="contact_number">
                        </div>
                        <div class="form-group">
                            <label for="">Last name</label>
                            <input type="text" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="">Last name</label>
                            <input type="text" class="form-control" name="address">
                        </div>
                        <div class="form-group">
                            <label for="">Last name</label>
                            <input type="text" class="form-control" name="birthday">
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
@endsection

@section ('scripts')
    <script>
        
        var page = 1;
        function fetch_data () {
            var formData = new FormData($('#js-form_search')[0]);
            formData.append('page', page);
            loader_overlay();
            $.ajax({
                url : "{{ route('admin.registrar_information') }}",
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
            $('body').on('click', '.btn-change-password', function (e) {
                e.preventDefault();
                $('.modal-change-pw-modal').modal({ backdrop : 'static' });
            });

            $('body').on('submit', '#form--change-password', function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url : "{{ route('my_account.change_my_password') }}",
                    type : 'POST',
                    data : formData,
                    processData : false,
                    contentType : false,
                    success : function (res) {
                        if (res.res_code == 0)  
                        {
                            $('.modal-change-pw-modal').modal('hide');
                        }
                        
                        show_toast_alert({
                            heading : res.res_code == 1 ? 'Error' : 'Success',
                            message : res.res_msg,
                            type    : res.res_code == 1 ? 'error' : 'success'
                        });
                    }
                });
            });

            $('body').on('click', '.btn--update-profile', function (e) {
                e.preventDefault();
                $('.modal-update-profile').modal({ backdrop : 'static' });
            })

            $('body').on('submit', '#js-form_subject_details', function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url         : "{{ route('admin.registrar_information.save_data') }}",
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

            
            $('body').on('click', '.js-btn_deactivate', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                alertify.defaults.transition = "slide";
                alertify.defaults.theme.ok = "btn btn-primary btn-flat";
                alertify.defaults.theme.cancel = "btn btn-danger btn-flat";
                alertify.confirm('Confirmation', 'Are you sure you want to deactivate?', function(){  
                    $.ajax({
                        url         : "{{ route('admin.registrar_information.deactivate_data') }}",
                        type        : 'POST',
                        data        : { _token : '{{ csrf_token() }}', id : id },
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
@endsection