<?php

namespace App\Http\Controllers\Control_Panel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacultyController extends Controller
{
    public function index (Request $request) 
    {
        if ($request->ajax())
        {
            $FacultyInformation = \App\FacultyInformation::with(['user'])->where('status', 1)
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%'.$request->search.'%');
                $query->orWhere('middle_name', 'like', '%'.$request->search.'%');
                $query->orWhere('last_name', 'like', '%'.$request->search.'%');
            })
            // ->orWhere('first_name', 'like', '%'.$request->search.'%')
            ->paginate(10);
            return view('control_panel.faculty_information.partials.data_list', compact('FacultyInformation'))->render();
        }
        $FacultyInformation = \App\FacultyInformation::with(['user'])->where('status', 1)->paginate(10);
        return view('control_panel.faculty_information.index', compact('FacultyInformation'));
    }
    public function modal_data (Request $request) 
    {
        $FacultyInformation = NULL;
        if ($request->id)
        {
            $FacultyInformation = \App\FacultyInformation::with(['user'])->where('id', $request->id)->first();
        }
        return view('control_panel.faculty_information.partials.modal_data', compact('FacultyInformation'))->render();
    }

    public function save_data (Request $request) 
    {
        $rules = [
            'username' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'department' => 'required',
            'email' => 'required|unique:users,username',
        ];
        
        
        $Validator = \Validator($request->all(), $rules);

        if ($Validator->fails())
        {
            return response()->json(['res_code' => 1, 'res_msg' => 'Please fill all required fields.', 'res_error_msg' => $Validator->getMessageBag()]);
        }

        if ($request->id)
        {
            $FacultyInformation = \App\FacultyInformation::where('id', $request->id)->first();
            $FacultyInformation->first_name = $request->first_name;
            $FacultyInformation->middle_name = $request->middle_name;
            $FacultyInformation->last_name = $request->last_name;
            $FacultyInformation->department_id = $request->department;
            $FacultyInformation->save();
            return response()->json(['res_code' => 0, 'res_msg' => 'Data successfully saved.']);
        }

        $User = new \App\User();
        $User->username = $request->username;
        $User->password = bcrypt($request->first_name . '.' . $request->last_name);
        $User->role     = 4;
        $User->save();

        $FacultyInformation = new \App\FacultyInformation();
        $FacultyInformation->first_name = $request->first_name;
        $FacultyInformation->middle_name = $request->middle_name;
        $FacultyInformation->last_name = $request->last_name;
        $FacultyInformation->department_id = $request->department;
        $FacultyInformation->user_id = $User->id;
        $FacultyInformation->save();
        
        return response()->json(['res_code' => 0, 'res_msg' => 'Data successfully saved.']);
    }
    public function deactivate_data (Request $request) 
    {
        $FacultyInformation = \App\FacultyInformation::where('id', $request->id)->first();

        if ($FacultyInformation)
        {
            $FacultyInformation->status = 0;
            $FacultyInformation->save();

            $User = \App\User::where('id', $FacultyInformation->user_id)->first();
            if ($User)
            {
                $User->status = 0;
                $User->save();
            }
            return response()->json(['res_code' => 0, 'res_msg' => 'Data successfully deactivated.']);
        }
        return response()->json(['res_code' => 1, 'res_msg' => 'Invalid request.']);
    }
}

