<table class="table no-margin less-m-top">
    <thead>
        <tr>
            <th>Subject</th>
            <th style="width: 100px">First Quarter</th>
            <th style="width: 100px">Second Quarter</th>
            <th style="width: 100px">Final Grade</th>
            <th style="width: 100px">Remarks</th>
            
        </tr>
    </thead>
    <tbody>
        @forelse ($GradeSheetData as $key => $data)
            <tr>
                <td>{{ $data->subject }}</td>
                @if ($data->grade_status === -1)
                    <td colspan="{{$ClassDetail ? $ClassDetail->section_grade_level <= 10 ? '6' : '4' : '6'}}" class="text-center text-red">
                        Grade not yet finalized
                    </td>
                @else 
                    <td style="text-align: center !important">{{ $data->fir_g ? $data->fir_g > 0  ? round($data->fir_g) : '' : '' }}</td>
                    <td style="text-align: center !important">{{ $data->sec_g ? $data->sec_g > 0  ? round($data->sec_g) : '' : '' }}</td>
                    @if ($data->sec_g > 0)
                        <td style="text-align: center !important">{{ round($data->final_g) }}</td>
                        <td style="text-align: center !important"><strong>{{ $data->final_g >= 75 ? 'Passed' : 'Failed' }}</strong></td>
                    @else
                        @if ($data->fir_g == 0 && $data->sec_g == 0 || $data->thi_g == 0 && $data->fou_g == 0)
                            <td></td>
                        @else
                            <td></td>
                        @endif                            
                        <td></td>
                    @endif
                @endif
            </tr>
        @empty
            <tr>
                <th colspan="5 style="text-align: center !important"">No Data Found</th>
            </tr>
        @endforelse
            <tr class="text-center">
                <td style="text-align: right; padding-right: 1em" colspan="3"><b>General Average</b></td>
                <td>
                    <b>
                        @if($data->fir_g == 0 && $data->sec_g == 0)
                            
                        @else
                            {{ $general_avg && $general_avg >= 0 ? round($general_avg) : '' }}
                        @endif
                    </b>
                </td>
                @if($data->fir_g == 0 && $data->sec_g == 0)                    
                    <td></td>
                @else
                    @if($general_avg < 75 && $general_avg > 74) 
                        <td style="color:'green';"><strong>Passed</strong></td>
                        @elseif($general_avg < 75) 
                        <td style="color:'red';"><strong>Failed</strong></td>
                    @else 
                        <td><center><strong>{{ $data->final_g >= 75 ? 'Passed' : 'Failed' }}</strong></center></td>
                    @endif
                @endif                                    
            </tr>
    </tbody>
</table>



<p class="report-progress-left m0"  style="margin-top: .5em"><b>ATTENDANCE RECORD</b></p>
<table style="width:100%; margin-bottom: 1em">
    <tr>
        <th></th>
        @foreach ($student_attendance['table_header'] as $data)
                <th>{{ $data['key'] }}</th>
        @endforeach
    </tr>
    <tr>
        <th>
            Days of School
        </th>
        @foreach ($student_attendance['attendance_data']->days_of_school as $key => $data)
            <th style="width:7%">{{ $data }}
            </th>
        @endforeach
        <th class="days_of_school_total">
            {{ $student_attendance['days_of_school_total'] }}
        </th>
    </tr>
    <tr>
        <th>
            Days Present
        </th>
        @foreach ($student_attendance['attendance_data']->days_present as $key => $data)
            <th style="width:7%">{{ $data == '' ? 0 : $data}} 
            </th>
        @endforeach
        <th class="days_present_total">
            {{ $student_attendance['days_present_total'] }}
        </th>
    </tr>
    <tr>
        <th>
            Days Absent
        </th>
        @foreach ($student_attendance['attendance_data']->days_absent as $key => $data)
            <th style="width:7%">{{ $data == '' ? 0 : $data}} 
            </th>
        @endforeach
        <th class="days_absent_total">
            {{ $student_attendance['days_absent_total'] }}
        </th>
    </tr>
    <tr>
        <th>
            Times Tardy
        </th>
        @foreach ($student_attendance['attendance_data']->times_tardy as $key => $data)
            <th style="width:7%">{{ $data == '' ? 0 : $data}} 
            </th>
        @endforeach
        <th class="times_tardy_total">
            {{ $student_attendance['times_tardy_total'] }}
        </th>
    </tr>
    </table>

<center>
<table border="0" style="width: 80%" class="less-m-top2">

    <tr style="margin-top: .5em">
        <td style="border: 0">Description</td>
        <td style="border: 0">Grading Scale</td>
        <td style="border: 0">Remarks</td>                
    </tr>

    <tr style="margin-top: .5em">
        <td style="border: 0">With Highest Honors</td>
        <td style="border: 0">98-100</td>
        <td style="border: 0">Passed</td>                
    </tr>

    <tr style="margin-top: .5em">
        <td style="border: 0">With High Honors</td>
        <td style="border: 0">95-97</td>
        <td style="border: 0">Passed</td>                
    </tr>

    <tr style="margin-top: .5em">
        <td style="border: 0">With Honors</td>
        <td style="border: 0">90-94</td>
        <td style="border: 0">Passed</td>                
    </tr>

    <tr style="margin-top: .5em">
        <td style="border: 0">Passed</td>
        <td style="border: 0">75-79</td>
        <td style="border: 0">Passed</td>                
    </tr>

    <tr style="margin-top: .5em">
        <td style="border: 0">Failed</td>
        <td style="border: 0">Below 75</td>
        <td style="border: 0">Failed</td>                
    </tr>
    <tr style="margin-top: .5em">
        <td style="border: 0"></td>
        <td style="border: 0"></td>
        <td style="border: 0"></td>   
    </tr>

    <tr style="margin-top: .5em">
        <td colspan="3" style="border: 0">Eligible to transfer and admission to:
        
            @if(round($GradeSheetData[0]->fir_g) != 0)
                @if(round($general_avg) > 74)                     
                 <strong><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @php
                            try {
                                echo $GradeSheetData[0]->eligible_transfer ? $GradeSheetData[0]->eligible_transfer : '____________';
                            } catch (\Throwable $th) {
                                echo '____________';
                            }
                        @endphp
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></strong>                                      
                @elseif(round($general_avg) < 75)                     
                   <strong>Failed</strong>
                @else 
                _______________________
                @endif
            @else
            _________________________
            @endif        
       
        </td>                
    </tr>

    <tr style="margin-top: .5em">
        <td colspan="3" style="border: 0">
            Lacking units in:______<u>
                    @php
                        try {
                            echo $GradeSheetData[0]->lacking_unit;
                        } catch (\Throwable $th) {
                            echo '_______________';
                        }
                    @endphp
                ______</u>
        </td>
        
    </tr>
    
    <tr style="margin-top: .5em">
        <td colspan="3" style="border: 0">
            Date:_______<u>
                @php
                    try {
                       echo date_format(date_create($DateRemarks->s_date1), 'F d, Y');
                    } catch (\Throwable $th) {
                        echo '';
                    }    
                @endphp
                </u>_______
        </td>      
    </tr>
    <tr style="margin-top: .5em">
        <td colspan="3" style="border: 0">&nbsp;</td>   
    </tr>    
    <tr style="margin-top: 0em">
            <table border="0" style="width: 100%; margin-top: 1.5em" class="pb-1">                
                    <tr>
                        <td style="border: 0; width: 50%;">
                            <center>
                                @if($Signatory->adviser->id == 46 )
                                    <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="{{ $Signatory->adviser->e_signature ? \File::exists(public_path('/img/signature/'.$Signatory->adviser->e_signature)) ? asset('/img/signature/'.$Signatory->adviser->e_signature) : asset('/img/account/photo/blank-user.png') : asset('/img/account/photo/blank-user.png') }}" 
                                    style="width:100px; margin-top: -5em">
                                @elseif($Signatory->adviser->id == 71 || $Signatory->adviser->id == 79)
                                    <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="{{ $Signatory->adviser->e_signature ? \File::exists(public_path('/img/signature/'.$Signatory->adviser->e_signature)) ? asset('/img/signature/'.$Signatory->adviser->e_signature) : asset('/img/account/photo/blank-user.png') : asset('/img/account/photo/blank-user.png') }}" 
                                    style="width:100px; margin-top: -1em">
                                @elseif($Signatory->adviser->id == 52 || $Signatory->adviser->id == 76 || $Signatory->adviser->id == 73)
                                    <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="{{ $Signatory->adviser->e_signature ? \File::exists(public_path('/img/signature/'.$Signatory->adviser->e_signature)) ? asset('/img/signature/'.$Signatory->adviser->e_signature) : asset('/img/account/photo/blank-user.png') : asset('/img/account/photo/blank-user.png') }}" 
                                    style="width:170px; margin-top: -1em">
                                @elseif($Signatory->adviser->id == 36)
                                    <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="{{ $Signatory->adviser->e_signature ? \File::exists(public_path('/img/signature/'.$Signatory->adviser->e_signature)) ? asset('/img/signature/'.$Signatory->adviser->e_signature) : asset('/img/account/photo/blank-user.png') : asset('/img/account/photo/blank-user.png') }}" 
                                    style="width:170px; margin-top: -1.5em">
                                @elseif($Signatory->adviser->id == 50)
                                    <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="{{ $Signatory->adviser->e_signature ? \File::exists(public_path('/img/signature/'.$Signatory->adviser->e_signature)) ? asset('/img/signature/'.$Signatory->adviser->e_signature) : asset('/img/account/photo/blank-user.png') : asset('/img/account/photo/blank-user.png') }}" 
                                    style="width:120px; margin-top: -2em !important">
                                @else
                                    <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="{{ $Signatory->adviser->e_signature ? \File::exists(public_path('/img/signature/'.$Signatory->adviser->e_signature)) ? asset('/img/signature/'.$Signatory->adviser->e_signature) : asset('/img/account/photo/blank-user.png') : asset('/img/account/photo/blank-user.png') }}"
                                    style="width:100px">
                                @endif
                            </center>
                        </td>
                        <td style="border: 0; width: 50%;">
                            <center>
                                <img class="profile-user-img img-responsive img-circle" id="img--user_photo" src="{{ asset('/img/signature/principal_signature.png') }}"
                                style="width:170px">
                            </center>
                        </td>
                    </tr>
            </table>
            @if($Signatory->adviser->id == 46 || $Signatory->adviser->id == 52 )
                <table border="0" style="width: 100%; margin-top: -85px; margin-bottom: 0em"> 
            @elseif($Signatory->adviser->id == 71 || $Signatory->adviser->id == 70 || $Signatory->adviser->id == 79)
                <table border="0" style="width: 100%; margin-top: -90px; margin-bottom: 0em">
            @elseif($Signatory->adviser->id == 76 || $Signatory->adviser->id == 73 || $Signatory->adviser->id == 36)
                <table border="0" style="width: 100%; margin-top: -87px; margin-bottom: 0em">     
            @else
                <table border="0" style="width: 100%; margin-top: -85px; margin-bottom: 0em">
            @endif                              
                <tr>
                    <td style="border: 0; width: 50%; height: 100px">
                        <span style="margin-left: 2em; text-transform: uppercase">
                            <center>
                                {{ $Signatory->adviser->adviser_signature }}
                            </center>
                            </br>
                            <center style="margin-top: -1em">
                                Adviser
                            </center>
                        </span>
                    </td>
                    <td style="border: 0; width: 50%; height: 100px">
                        <span style="margin-left: 23em;">
                            <center>Gemma R. Yao, Ph.D.</center>
                            </br>
                            <center style="margin-top: -1em">PRINCIPAL</center>
                        </span>
                    </td>
                </tr>
            </table>        
    </tr>
</table>
<div class="page-break"></div>

