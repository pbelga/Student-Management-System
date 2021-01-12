<?php

namespace App\Http\Controllers\Control_Panel_Student;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Models\OnlineAppointment;
use App\Models\StudentInformation;
use App\Http\Controllers\Controller;
use App\Models\TransactionMonthPaid;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentTimeAppointment;

class DashboardController extends Controller
{
    public function index (Request $request) 
    {
        $User = Auth::user();

        $StudentInformation = StudentInformation::where('user_id', $User->id)
            ->first();

        $SchoolYear = SchoolYear::where('current', 1)
            ->where('status', 1)
            ->first();  

        $AppointedCount = StudentTimeAppointment::with('appointment')
                ->whereStudentId($StudentInformation->id)
                ->whereStatus(1)
                ->count();

        $Appointed = StudentTimeAppointment::with('appointment')
            ->whereStudentId($StudentInformation->id)
            ->whereStatus(1)
            ->get();
        
        $OnlineAppointment = OnlineAppointment::where('status', 1)
            ->get();

        $hasAppointment =  StudentTimeAppointment::with('appointment')
            ->whereStudentId($StudentInformation->id)
            ->whereStatus(1)->whereApproval(1)
            ->first();
            

        $AlreadyEnrolled = TransactionMonthPaid::where('student_id', $StudentInformation->id)
                ->whereSchoolYearId($SchoolYear->id)
                ->where('isSuccess', 1)
                ->whereApproval('Approved')
                ->orderBy('id', 'Desc')
                ->first();

        
        return view('control_panel_student.dashboard.index',
            compact('StudentInformation','OnlineAppointment', 'Appointed','StudentInformation', 'SchoolYear',
            'hasAppointment','AppointedCount','AlreadyEnrolled'));
    }

    
}