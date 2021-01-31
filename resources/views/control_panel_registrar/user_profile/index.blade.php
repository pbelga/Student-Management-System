@extends('control_panel.layouts.master')

@section ('content_title')
    My Account
@endsection
@section ('styles')
    <link rel="stylesheet" href="{{ asset('cms/plugins/datepicker/datepicker3.css')}}">
@endsection
@section ('content')
    <div class="row">
        @include('control_panel_registrar.user_profile.partials.data_list')
        @include('control_panel_registrar.user_profile.partials.modal_data')
    </div>  

@endsection

@section ('scripts')
    <script src="{{ asset('cms/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script>
        

        $('#birthday').datepicker({
            autoclose: true
        })
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
                    url : "{{ route('registrar.my_account.change_my_password') }}",
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
                $.ajax({
                    url : "{{ route('registrar.my_account.fetch_profile') }}",
                    type : 'POST',
                    data        : {_token: '{{ csrf_token() }}'},
                    success     : function (res) {
                        $('.help-block').html('');
                        $('.modal-update-profile').modal({ backdrop : 'static' });
                        $('#first_name').val(res.Profile.first_name);
                        $('#middle_name').val(res.Profile.middle_name);
                        $('#last_name').val(res.Profile.last_name);
                        $('#contact_number').val(res.Profile.contact_number);
                        $('#email').val(res.Profile.email);
                        $('#address').val(res.Profile.address);
                        $('#birthday').val(res.Profile.birthday);
                        
                    }
                })
            })
            $('body').on('submit', '#form--update-profile', function (e) {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                $.ajax({
                    url : "{{ route('registrar.my_account.update_profile') }}",
                    type : 'POST',
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
                            $.ajax({
                                url : "{{ route('registrar.my_account.fetch_profile') }}",
                                type : 'POST',
                                dataType : 'JSON',
                                data        : {_token: '{{ csrf_token() }}'},
                                success     : function (res) {
                                    console.log(res)
                                    $('#display__full_name').text((res.Profile.first_name != null ? res.Profile.first_name : '') + ' ' + (res.Profile.middle_name != null ? res.Profile.middle_name : '') + ' '  + (res.Profile.last_name != null ? res.Profile.last_name : ''));
                                    $('#display__contact_number').text((res.Profile.contact_number != null ? res.Profile.contact_number : ''));
                                    $('#display__email').text((res.Profile.email != null ? res.Profile.email : ''));
                                    $('#display__address').text((res.Profile.address != null ? res.Profile.address : ''));
                                    $('#display__birthday').text((res.Profile.birthday != null ? res.Profile.birthday : ''));
                                }
                            })
                            $('.modal-update-profile').modal('hide');
                        }
                        
                        show_toast_alert({
                            heading : res.res_code == 1 ? 'Error' : 'Success',
                            message : res.res_msg,
                            type    : res.res_code == 1 ? 'error' : 'success'
                        });
                    }
                });
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

            
            $('body').on('click', '.btn--update-photo', function (e) {
                $('#user--photo').click()
            })
            $('body').on('change', '#user--photo', function (e) {
                readURL($(this))
                

                {{--  $('body').on('submit', '#form_user_photo_uploader', function (frm) {
                    frm.preventDefault();  --}}
                {{--  })  --}}
            })

            function readURL(input) {
                var url = input[0].value;
                var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                if (input[0].files && input[0].files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img--user_photo').attr('src', e.target.result);
                        
                        var formData = new FormData($('#form_user_photo_uploader')[0]);
                        {{--  formData.append('user_photo', $('#user--photo'));  --}}
                        formData.append('_token', '{{ csrf_token() }}');
                        console.log(formData)
                        $.ajax({
                            url : "{{ route('registrar.my_account.change_my_photo') }}",
                            type : 'POST',
                            data : formData,
                            processData : false,
                            contentType : false,
                            success     : function (res) {
                                console.log(res)
                            }
                        })
                    }

                    reader.readAsDataURL(input[0].files[0]);
                }else{
                    $('#img--user_photo').attr('src', '/assets/no_preview.png');
                }
            }
        });
    </script>
@endsection