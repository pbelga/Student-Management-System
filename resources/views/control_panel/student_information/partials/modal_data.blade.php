<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="box-body">
                <div class="modal-header">                    
                    <h4 style="margin-right: 5em;" class="modal-title text-uppercase">
                        {{ $StudentInformation ? 'Edit Student Information' : 'Add Student Information' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                        
                </div>
                
                
                <div class="col-md-12 m-auto">
                    <div class="mt-5">
                        <div class="text-center">                        
                            @if ($Profile)
                                <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="{{ $Profile->photo ? \File::exists(public_path('/img/account/photo/'.$Profile->photo)) ? asset('/img/account/photo/'.$Profile->photo) : asset('/img/account/photo/blank-user.gif') : asset('/img/account/photo/blank-user.gif') }}" style="width:150px; height:150px;  border-radius:50%;">
                            @else
                                <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="{{  asset('/img/account/photo/blank-user.png') }}" style="width:150px; height:150px;  border-radius:50%;">
                            @endif    
                            <h2>{{ $Profile ? $Profile->first_name : 'User' }}'s Profile</h2>
                            <div class="box-body">
                                <button type="button" class="btn btn-success btn--update-photo" title="Change photo">
                                    browse
                                </button>
                        
                                <form class="d-none" id="form_user_photo_uploader">
                                    <input type="file" id="user--photo" name="user_photo">
                                    <input type="d-none" name="id" value="{{ $StudentInformation ? $StudentInformation->id : '' }}">
                                    <button type="submit">fsdfasd</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form id="js-form_subject_details">
                    {{ csrf_field() }}
                                    
                    @if ($StudentInformation)
                        <input type="hidden" name="id" value="{{ $StudentInformation->id }}">
                    @endif
                    
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" class="form-control form-control-sm" name="username" value="{{ $StudentInformation ? $StudentInformation->user->username : '' }}">
                            <div class="help-block text-red text-center" id="js-username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">First name</label>
                            <input type="text" class="form-control form-control-sm" name="first_name" value="{{ $StudentInformation ? $StudentInformation->first_name : '' }}">
                            <div class="help-block text-red text-center" id="js-first_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Middle name</label>
                            <input type="text" class="form-control form-control-sm" name="middle_name" value="{{ $StudentInformation ? $StudentInformation->middle_name : '' }}">
                            <div class="help-block text-red text-center" id="js-middle_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Last name</label>
                            <input type="text" class="form-control form-control-sm" name="last_name" value="{{ $StudentInformation ? $StudentInformation->last_name : '' }}">
                            <div class="help-block text-red text-center" id="js-last_name">
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="">Parent/Guardian</label>
                            <input type="text" class="form-control form-control-sm" name="guardian" value="{{ $StudentInformation ? $StudentInformation->guardian : '' }}">
                            <div class="help-block text-red text-center" id="js-guardian">
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label for="">Address <small class="text-red">Optional</small></label>
                            <input type="text" class="form-control form-control-sm" name="address" value="{{ $StudentInformation ? $StudentInformation->c_address : '' }}">
                            <div class="help-block text-red text-center" id="js-address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Age June</label>
                            <input type="text" class="form-control form-control-sm" name="age_june" value="{{ $StudentInformation ? $StudentInformation->age_june : '' }}">
                            <div class="help-block text-red text-center" id="js-age_june">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Age May</label>
                            <input type="text" class="form-control form-control-sm" name="age_may" value="{{ $StudentInformation ? $StudentInformation->age_may : '' }}">
                            <div class="help-block text-red text-center" id="js-age_may">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Date of Birth <small class="text-red">Optional</small></label>
                            {{--  <input type="text" class="form-control form-control-sm" name="birthdate" value="{{ $StudentInformation ? $StudentInformation->birthdate : '' }}">  --}}
                            <div class="input-group date">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="birthdate" class="form-control form-control-sm pull-right" id="datepicker"
                                value="{{ $StudentInformation ? date_format(date_create($StudentInformation->birthdate), 'F d, Y') : '' }}">
                            </div>
                            <div class="help-block text-red text-center" id="js-birthdate">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Gender </label>
                            <select name="gender" id="gender" class="form-control form-control-sm">
                                <option value="">Select gender</option>
                                <option value="1" {{ $StudentInformation ? $StudentInformation->gender == 1 ? 'selected' : '' : '' }}>Male</option>
                                <option value="2" {{ $StudentInformation ? $StudentInformation->gender == 2 ? 'selected' : '' : '' }}>Female</option>
                            </select>
                            <div class="help-block text-red text-center" id="js-gender">
                            </div>
                        </div>

                        @if ($StudentInformation)
                            @if ($StudentInformation->id)
                                <div class="form-group">
                                    <label for="">Email address</label>
                                    <input type="text" class="form-control form-control-sm" name="email" value="{{ $StudentInformation ? $StudentInformation->email : '' }}">
                                    <div class="help-block text-red text-center" id="js-email">
                                    </div>
                                </div>
                            @endif
                        @endif


                        <div class="col-md-12 mt-4 text-uppercase">
                                <h5>Educational Data</h5>
                                <hr>
                            </div>

                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Name of School: </label>
                                    {{$StudentInformation->admission_school_name}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">School Type: </label>
                                    {{$StudentInformation->admission_school_type}}
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">School Address: </label>
                                    {{$StudentInformation->admission_school_address}}
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Last School Year Attended: </label>
                                    {{ $StudentInformation->school_year ? : 'NA' }}
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Average (GWA): </label>
                                    {{$StudentInformation->admission_gwa}}
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">ESC grantee: </label>
                                    {{$StudentInformation->isEsc ? $StudentInformation->isEsc == 1 ? 'Yes' : 'No' : 'NA'}}
                                </div>  
                            </div>


                            <div class="col-md-12 mt-4 text-uppercase">
                                <h5>Family Information</h5>
                                <hr>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Father name: </label>
                                    {{$StudentInformation->father->name ? $StudentInformation->father->name : 'NA'}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Father Occupation: </label>
                                    {{$StudentInformation->father->occupation ? $StudentInformation->father->occupation: 'NA'}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Father FB/Messenger Acct: </label>
                                    {{$StudentInformation->father->fb_acct ? $StudentInformation->father->fb_acct : 'NA'}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Father FB/Messenger Acct: </label>
                                    {{$StudentInformation->father->number ? $StudentInformation->father->number : 'NA'}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Mother name: </label>
                                    {{$StudentInformation->mother->name ? $StudentInformation->mother->name : 'NA'}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Mother Occupation: </label>
                                    {{$StudentInformation->mother->occupation ? $StudentInformation->mother->occupation: 'NA'}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Mother FB/Messenger Acct: </label>
                                    {{$StudentInformation->mother->fb_acct ? $StudentInformation->mother->fb_acct : 'NA'}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Mother FB/Messenger Acct: </label>
                                    {{$StudentInformation->mother->number ? $StudentInformation->mother->number : 'NA'}}
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Guardian: </label>
                                    {{$StudentInformation->guardian->name ? $StudentInformation->guardian->name : 'NA'}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">Guardian FB/Messenger Acct: </label>
                                    {{$StudentInformation->guardian->fb_acct ? $StudentInformation->guardian->fb_acct : 'NA'}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <label for="">No. of your siblings: </label>
                                    {{$StudentInformation->no_siblings ? $StudentInformation->no_siblings : 'NA'}}
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 text-uppercase">
                                <h5>Student Scholar Type</h5>
                                <hr>
                            </div>

                            @foreach ($StudentInformation->scholarTypes as $scholar)
                                <div class="form-check form-check-inline">
                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-check-circle"></i> {{ $scholar->name }}
                                    </button>
                                </div>
                            @endforeach

                            <div class="col-md-12 mt-4 text-uppercase">
                                <h5>NAME OF BROTHER'S & SISTER(S) WHO ARE CURRENTLY ENROLLED</h5>
                                <hr>
                            </div>

                            <table class="table table-sm table-condensed table-hover">
                                <thead>
                                    <th>Name</th>
                                    <th class="text-center">Grade Level</th>
                                </thead>
                                <tbody>
                                    @forelse ($StudentInformation->siblings as $sibling)
                                        <tr>
                                            <td>{{ $sibling->name }}</td>
                                            <td class="text-center">{{ $sibling->grade_level_id }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th class="text-center" colspan="2">No Data</th class="text-center">
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->