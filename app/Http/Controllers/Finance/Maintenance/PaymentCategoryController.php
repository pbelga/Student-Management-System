<?php

namespace App\Http\Controllers\Finance\Maintenance;

use App\Models\MiscFee;
use App\Models\OtherFee;
use App\Models\GradeLevel;
use App\Models\TuitionFee;
use App\Models\PaymentCategory;
use App\Models\StudentCategory;
use Illuminate\Http\Request;
use App\Traits\hasNotYetApproved;
use App\Http\Controllers\Controller;

class PaymentCategoryController extends Controller
{
    use hasNotYetApproved;
    
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $NotyetApprovedCount = $this->notYetApproved();
            $PaymentCategory = PaymentCategory::with('stud_category','tuition','misc_fee')
                ->where('status', 1)->orderBY('grade_level_id', 'ASC')->paginate(10);
            // $PaymentCategory = PaymentCategory::where('status', 1)->where('disc_type', 'like', '%'.$request->search.'%')->paginate(10);
            // return view('control_panel_finance.maintenance.payment_category.partials.data_list', compact('PaymentCategory'))->render();
            return view('control_panel_finance.maintenance.payment_category.partials.data_list', compact('PaymentCategory','NotyetApprovedCount'));
        }
        
        $NotyetApprovedCount = $this->notYetApproved();
        $PaymentCategory = PaymentCategory::with('stud_category','tuition','misc_fee')
            ->where('status', 1)->orderBY('grade_level_id', 'ASC')->paginate(10);
        // return view('control_panel_finance.maintenance.discount_fee.index', compact('PaymentCategory'));
        return view('control_panel_finance.maintenance.payment_category.index', compact('PaymentCategory','NotyetApprovedCount'));
    }

    public function modal_data (Request $request) 
    {
        $PaymentCategory = NULL;
        
        if ($request->id)
        {
            $PaymentCategory = PaymentCategory::where('id', $request->id)
                ->where('status', 1)
                ->first();            
        }

        $TuitionFee = TuitionFee::where('current', 1)->where('status', 1)->get();
        $MiscFee = MiscFee::where('current', 1)->where('status', 1)->get();
        $Gradelvl = GradeLevel::where('current', 1)->where('status', 1)->get();
        $StudentCategory = StudentCategory::where('status', 1)->get();
        $OtherFee = OtherFee::where('status', 1)->get();
        // return view('control_panel_finance.maintenance.discount_fee.partials.modal_data', compact('PaymentCategory'))->render();
        return view('control_panel_finance.maintenance.payment_category.partials.modal_data', 
            compact('StudentCategory','TuitionFee','MiscFee','Gradelvl','PaymentCategory','OtherFee'))->render();
    }

    public function save_data (Request $request) 
    {
        $rules = [
            'stud_cat' => 'required',
            'gradelvl' => 'required',
            'tuitionfee' => 'required',     
            'misc_fee' => 'required'
        ];

        $Validator = \Validator($request->all(), $rules);

        if ($Validator->fails())
        {
            return response()->json(['res_code' => 1, 'res_msg' 
                => 'Please fill all required fields.', 'res_error_msg' 
                => $Validator->getMessageBag()]);
        }   
        // update
        if ($request->id)
        {
            $PaymentCategory = PaymentCategory::where('id', $request->id)->first();
            $PaymentCategory->student_category_id = $request->stud_cat;
            $PaymentCategory->grade_level_id = $request->gradelvl;
            $PaymentCategory->tuition_fee_id = $request->tuitionfee;
            $PaymentCategory->misc_fee_id = $request->misc_fee;
            $PaymentCategory->other_fee_id = $request->other_fee;
            // $PaymentCategory->months = $request->total_months;
            $PaymentCategory->save();
            return response()->json(['res_code' => 0, 'res_msg' => 'Data successfully saved.']);
        }
        // save
        $PaymentCategory = new PaymentCategory();
        $PaymentCategory->student_category_id = $request->stud_cat;
        $PaymentCategory->grade_level_id = $request->gradelvl;
        $PaymentCategory->tuition_fee_id = $request->tuitionfee;
        $PaymentCategory->misc_fee_id = $request->misc_fee;
        $PaymentCategory->other_fee_id = $request->other_fee;
        $PaymentCategory->save();
        return response()->json(['res_code' => 0, 'res_msg' => 'Data successfully saved.']);
    }

    public function toggle_current_sy (Request $request)
    {
        $PaymentCategory = PaymentCategory::where('id', $request->id)->first();
        if ($PaymentCategory) 
        {
            if ($PaymentCategory->current == 0) 
            {
                $PaymentCategory->current = 1; 
                $PaymentCategory->save(); 
                return response()->json(['res_code' => 0, 'res_msg' => 'Data successfully added to current active Discount Fee.']);
            }
            else 
            {
                $PaymentCategory->current = 0; 
                $PaymentCategory->save(); 
                return response()->json(['res_code' => 0, 'res_msg' => 'Data successfully removed from current active Discount Fee.']);
            }
        }
    }

    public function deactivate_data (Request $request) 
    {
        $PaymentCategory = PaymentCategory::where('id', $request->id)->first();

        if ($PaymentCategory)
        {
            $PaymentCategory->status = 0;
            $PaymentCategory->save();
            return response()->json(['res_code' => 0, 'res_msg' => 'Data successfully deactivated.']);
        }
        return response()->json(['res_code' => 1, 'res_msg' => 'Invalid request.']);
    }
}