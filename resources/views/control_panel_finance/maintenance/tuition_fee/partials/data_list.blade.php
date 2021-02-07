                        <div class="float-right">
                            {{ $TuitionFee ? $TuitionFee->links() : '' }}
                        </div>
                        <table class="table no-margin table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Tuition Fee Amount</th>
                                    {{-- <th>Student Category</th> --}}
                                    <th>Current</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($TuitionFee)
                                    @foreach ($TuitionFee as $data)
                                        <tr>
                                            <td>{{ number_format($data->tuition_amt, 2) }}</td>
                                            {{-- <td>{{$data->student_category->student_category}}</td> --}}
                                            <td>{{ $data->current == 1 ? 'Yes' : 'No' }}</td>
                                            <td>
                                                <span class="badge badge-{{ $data->status == 1 ? 'success' : 'danger' }}">
                                                    {{ $data->status == 1 ? 'Active' : 'Inactive' }}
                                                </span>    
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-danger">Action</button>
                                                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a href="#" class="dropdown-item js-btn_update_sy" data-id="{{ $data->id }}">Edit</a>
                                                        <a href="#" class="dropdown-item js-btn_deactivate" data-id="{{ $data->id }}">Deactivate</a>
                                                        <a href="#" class="dropdown-item js-btn_toggle_current" data-id="{{ $data->id }}" data-toggle_title="{{ ( $data->current ? 'Remove from current active' : 'Add to current active' ) }}">
                                                            {{ ( $data->current ? 'Remove from current Active' : 'Add to current Active' ) }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>