@extends('control_panel.layouts.master')

@section ('styles') 
@endsection

@section ('content_title')
    Subject Class Details
@endsection

@section ('content')
    <div class="box">
        {{--  <div class="box-header with-border">
            <h3 class="box-title">Search</h3>
            <form id="js-form_search">
                {{ csrf_field() }}  --}}
                {{--  <div id="js-form_search" class="form-group col-sm-12 col-md-3" style="padding-right:0">
                    <input type="text" class="form-control" name="search">
                </div>  --}}
                
                {{--  <div id="js-form_search" class="form-group col-sm-12 col-md-3" style="padding-right:0">
                    <select name="search_sy" id="search_sy" class="form-control">
                        <option value="">Select SY</option>
                        @foreach ($SchoolYear as $data)
                            <option value="{{ $data->id }}">{{ $data->school_year }}</option>
                        @endforeach
                    </select>
                </div> 
                &nbsp;
                <div id="js-form_search" class="form-group col-sm-12 col-md-5" style="padding-right:0">
                    <select name="search_class_subject" id="search_class_subject" class="form-control">
                        <option value="">Select Class Subject</option>
                    </select>
                </div>
                &nbsp;
                <button type="submit" class="pull-right btn btn-flat btn-success">Search</button>  --}}
                {{--  <button type="button" class="pull-right btn btn-flat btn-danger btn-sm" id="js-button-add"><i class="fa fa-plus"></i> Add</button>  --}}
            {{--  </form>
        </div>  --}}
        <div class="overlay hidden" id="js-loader-overlay"><i class="fa fa-refresh fa-spin"></i></div>
        <div class="box-body">
            <div class="js-data-container">
                {{--  @include('control_panel_faculty.subject_class_details.partials.data_list')  --}}
                

                <table class="table no-margin">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Days</th>
                            <th>Subject</th>
                            <th>Room</th>
                            <th>Grade & Section</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($ClassSubjectDetail)
                            @foreach ($ClassSubjectDetail as $key => $data)
                                <tr>
                                    <td>{{ $data->class_time_from . ' -  ' . $data->class_time_to }}</td>
                                    <td>{{ $data->class_days }}</td>
                                    <td>{{ $data->subject_code . ' ' . $data->subject }}</td>
                                    <td>{{ 'Room' . $data->room_code }}</td>
                                    <td>{{ $data->grade_level . ' ' . $data->section }}</td>
                                </tr>
                            @endforeach
                        @else
                            
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
@endsection

@section ('scripts')
    <script src="{{ asset('cms/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script>
        var page = 1;
        function fetch_data () {
            var formData = new FormData($('#js-form_search')[0]);
            formData.append('page', page);
            loader_overlay();
            $.ajax({
                url : "{{ route('faculty.subject_class.list_students_by_class') }}",
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

            $('body').on('submit', '#js-form_search', function (e) {
                e.preventDefault();
                if (!$('#search_class_subject').val()) {
                    alert('Please select a subject');
                    return;
                }
                fetch_data();
            });
            $('body').on('change', '#search_sy', function () {
                $.ajax({
                    url : "{{ route('faculty.subject_class.list_class_subject_details') }}",
                    type : 'POST',
                    {{--  dataType    : 'JSON',  --}}
                    data        : {_token: '{{ csrf_token() }}', search_sy: $('#search_sy').val()},
                    success     : function (res) {

                        $('#search_class_subject').html(res);
                    }
                })
            })
        });
    </script>
@endsection