<?php

namespace App\Http\Controllers\Finance;

use App\Models\Payroll;
use App\Models\Document;
use App\Traits\HasDocuments;
use Illuminate\Http\Request;
use App\Traits\hasNotYetApproved;
use App\Models\FacultyInformation;
use App\Models\FinanceInformation;
use App\Http\Controllers\Controller;
use App\Models\AdmissionInformation;
use App\Models\RegistrarInformation;

class PayrollController extends Controller
{
    use hasNotYetApproved, HasDocuments;
    
    public function index(Request $request)
    {
        $NotyetApprovedCount = $this->notYetApproved();
        $payroll_dates = Payroll::whereStatus(1)->distinct(['payroll_date'])->get(['payroll_date']);
        $payroll = Payroll::where('status', 1)->where('payroll_date', 'like', '%'.$request->search.'%')->paginate(10);
        if($request->ajax())
        {
            return view('control_panel_finance.payroll.partials.data_list', 
                compact('payroll','NotyetApprovedCount','payroll_dates'))->render();
        }

        return view('control_panel_finance.payroll.index', 
            compact('payroll','NotyetApprovedCount','payroll_dates'));
    }

    public function modal_data (Request $request) 
    {
        $payroll = NULL;
        $emp_data = FacultyInformation::whereStatus(1)->whereCurrent(1)->get();
        if ($request->id)
        {
            $payroll = Payroll::where('id', $request->id)->first();
        }
        return view('control_panel_finance.payroll.partials.modal_data', 
            compact('payroll','emp_data'))->render();
    }

    public function employee_list(Request $request)
    {
        $emp_type = $request->emp_category;

        if($emp_type==1)
        {
            // faculty
            $emp_data = FacultyInformation::whereStatus(1)->whereCurrent(1)->get();
        }

        if($emp_type==2)
        {
            // admission
            $emp_data = AdmissionInformation::whereStatus(1)->whereCurrent(1)->get();
        }

        if($emp_type==3)
        {
            // finance
            $emp_data = FinanceInformation::whereStatus(1)->whereCurrent(1)->get();
        }

        if($emp_type==4)
        {
            // registrar
            $emp_data = RegistrarInformation::whereStatus(1)->whereCurrent(1)->get();
        }
        
        $employee_list = '<option value="">Select Employee</option>';
        if ($emp_data) 
        {
            foreach ($emp_data as $data) 
            {
                $employee_list .= '<option value="'. $data->id .'">'. $data->full_name . '</option>';
            }

            return $employee_list;
        }

        return $employee_list;
    }

    public function save(Request $request){
        if ($request->id){
            $rules = [
                'payroll_date'   => 'required',
                'emp_category'   => 'required',
                'employee_name'  => 'required'
            ];
        }
        if (!$request->id){
            $rules = [
                'payroll_date'   => 'required',
                'emp_category'   => 'required',
                'employee_name'  => 'required',
                'payroll'        => 'required'
            ];
         }

        $Validator = \Validator($request->all(), $rules);

        if ($Validator->fails())
        {
            return response()->json([ 
                'res_code'      => 1,
                'res_msg'       => 'Please fill all required fields.',
                'res_error_msg' => $Validator->getMessageBag()
            ]);
        }

        $emp_type = $request->emp_category;
        $emp_id = $request->employee_name;

        if($emp_type==1)
        {
            // faculty
            $emp_data = FacultyInformation::find($emp_id);
        }

        if($emp_type==2)
        {
            // admission
            $emp_data = AdmissionInformation::find($emp_id);
        }

        if($emp_type==3)
        {
            // finance
            $emp_data = FinanceInformation::find($emp_id);
        }

        if($emp_type==4)
        {
            // registrar
            $emp_data = RegistrarInformation::find($emp_id);
        }

        // return json_encode($emp_data->full_name);

        if(!$request->id)
        {
            $fileName = $emp_data->full_path_name.'.'.time().'.'.$request->payroll->getClientOriginalExtension();
            $request->payroll->move(public_path('/data/payroll/'), $fileName);
            
            $path = public_path('data/payroll/'. $fileName);
            if (\File::exists($path))
            {
                \File::delete($path);
            }
        }
        
        // update
        if ($request->id)
        {
            $Payroll = Payroll::where('id', $request->id)->first();
            $Payroll->employee_id = $request->employee_name;
            $Payroll->employee_type = $request->emp_category;
            $Payroll->payroll_date = $request->payroll_date;
            $Payroll->status = $request->active;
            $Payroll->save();

            if($request->payroll){
                $Payroll->documents()->create([
                    'path_name' => encrypt($fileName),
                    'type'      => 'excel'
                ]);
            }
            
            return response()->json(['res_code' => 0, 'res_msg' => 'Data successfully updated.']);
        }
        // save
        $Payroll = new Payroll();
        $Payroll->employee_id = $request->employee_name;
        $Payroll->employee_type = $request->emp_category;
        $Payroll->payroll_date = $request->payroll_date;
        $Payroll->status = $request->active;
        $Payroll->save();
        
        $Payroll->documents()->create([
            'path_name' => encrypt($fileName),
            'type'      => 'excel'
        ]);

        return response()->json([
            'res_code'  => 0, 
            'res_msg'   => 'Data successfully saved.'
        ], 200);
    }

    public function download_payroll (Request $request)
    {
        if (!$request->id || !$request->file_name) 
        {
            return response()->json(['res_code' => 1, 'res_msg' => 'Invalid request'], 402);
        }

        $payrollArchieve = Document::whereDocumentableId($request->id)->first();

        if (!$payrollArchieve) 
        {
            return response()->json(['res_code' => 1, 'res_msg' => 'Invalid reques2t']);
        }
        $file_name = \decrypt($request->file_name);
        
        return response()->json([
            'res_code'  => 0,
            'res_msg'   => 
            'Download will proceed immidiately',
            'file_path' => public_path('data/payroll/'.$file_name)
        ]);
    }

    public function deactivate_data (Request $request)
    {
        if (!$request->id) 
        {
            return response()->json(['res_code' => 1, 'res_msg' => 'Invalid request1']);
        }

        $payrollArchieve = Payroll::where('id', $request->id)->first();

        if (!$payrollArchieve) 
        {
            return response()->json(['res_code' => 1, 'res_msg' => 'Invalid reques2t']);
        }
        $payrollArchieve->status = 0;
        $payrollArchieve->save();
        
        return response()->json(['res_code' => 0, 'res_msg' => 'Data deactivated!']);
    }
}