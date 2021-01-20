<div class="pull-right">
    {{ $ClassDetail ? $ClassDetail->links() : '' }}
</div>
<table class="table no-margin">
    <thead>
        <tr>
            <th>School Year</th>
            <th>Room</th>
            <th>Grade Level</th>
            <th>Section</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($ClassDetail)
            @foreach ($ClassDetail as $data)
                <tr>
                    <td>{{ $data->schoolYear->school_year }} </td>
                    <td>{{ $data->room->room_code }}</td>
                    <td>{{ $data->grade_level }}</td>
                    <td>{{ $data->section->section }}</td>
                    <td>{{ $data->status == 0 ? 'Inactive' : 'Active' }}</td>
                    <td>
                        <div class="input-group-btn pull-left text-left">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Action
                                <span class="fa fa-caret-down"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('faculty.advisory_class.view') }}?c={{ encrypt($data->id) }}" 
                                        class="js-btn_view" data-id="{{ encrypt($data->id) }}">
                                        Student List
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('faculty.my_advisory_class.index') }}?c={{ encrypt($data->id) }}" class="js-btn_gradesheet" data-id="{{ encrypt($data->id) }}">
                                        Grade Sheet
                                    </a>
                                </li> --}}
                                 <li>
                                    <a href="{{ route('faculty.student_gradesheet.index') }}?c={{ encrypt($data->id) }}" 
                                        class="js-btn_gradesheet1" data-id="{{ encrypt($data->id) }}">
                                        Grade Sheet
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>