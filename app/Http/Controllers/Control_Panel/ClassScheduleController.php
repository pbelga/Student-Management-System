<?php

namespace App\Http\Controllers\Control_Panel;

use Barryvdh\DomPDF\PDF;
use App\Models\SchoolYear;
use App\Models\ClassSubjectDetail;
use App\Models\FacultyInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ClassScheduleController extends Controller
{
    public function index (Request $request) 
    {
        $SchoolYear = SchoolYear::where('current', 1)->first();
        $FacultyInformation = FacultyInformation::where('status', 1)
        ->select(\DB::raw(
            "
                faculty_informations.id, 
                faculty_informations.last_name, 
                faculty_informations.first_name, 
                faculty_informations.middle_name,
                department_id,
                (   SELECT 
                        COUNT(*) 
                    FROM 
                        class_subject_details 
                    WHERE  
                        class_subject_details.faculty_id = faculty_informations.id 
                    AND 
                        class_subject_details.status = 1 
                    AND class_details_id IN 
                    
                    (SELECT id FROM class_details where school_year_id IN 
                    (SELECT id FROM school_years WHERE current = 1 and status = 1)
                     AND status = 1)
                ) 
                    AS subjects_count
            "
        ))->orderBy('last_name', 'ASC');

        if ($request->ajax()) 
        {
            $FacultyInformation = $FacultyInformation->where(function ($query) use ($request) {
                if ($request->search)
                {
                    $query->where('faculty_informations.first_name', 'LIKE', '%'. $request->search . '%');
                    $query->orWhere('faculty_informations.middle_name', 'LIKE', '%'. $request->search . '%');
                    $query->orWhere('faculty_informations.last_name', 'LIKE', '%'. $request->search . '%');
                }
            })
            ->paginate(10);
            
            return view('control_panel.faculty_schedule.partials.data_list', compact('FacultyInformation'))->render();
            return response()->json(['res_code' => 0, 'res_msg' => '', 'FacultyInformation' => $FacultyInformation]);
        }
        
        $FacultyInformation = $FacultyInformation->paginate(10);

        // return response()->json(['res_code' => 0, 'res_msg' => '', 'FacultyInformation' => $FacultyInformation]);
        return view('control_panel.faculty_schedule.index', compact('FacultyInformation'));
    }
    public function get_faculty_class_schedule (Request $request)
    {
        $SchoolYear = SchoolYear::where('current', 1)->first();
        $ClassSubjectDetail = ClassSubjectDetail::join('subject_details', 'subject_details.id', '=', 'class_subject_details.subject_id')
        ->join('class_details', 'class_details.id', '=', 'class_subject_details.class_details_id')
        ->join('section_details', 'section_details.id', '=', 'class_details.section_id')
        ->join('rooms', 'rooms.id', '=', 'class_details.room_id')
        ->join('school_years', 'school_years.id', '=', 'class_details.school_year_id')
        ->where('faculty_id', $request->id)
        ->whereRaw('
            class_details_id IN ( SELECT id from class_details WHERE school_year_id IN ( SELECT id FROM school_years WHERE status = 1 AND current = 1 ) )
        ')
        ->where('class_subject_details.status', 1)
        // ->orderByRaw('SUBSTRING(class_subject_details.class_days, 0, 1) DESC')
        ->orderBy('class_subject_details.class_time_from', 'ASC')
        ->get();
        // $ClassSubjectDetailTmp = $ClassSubjectDetail;
        // $ClassSubjectDetail = [];
        // while (count($ClassSubjectDetailTmp) > 0) {
        //     foreach ($ClassSubjectDetailTmp as $k => $d) 
        //     {
        //         $dTmp = substr($d->class_days, 0, 1);
        //         if ($dTmp == 't') 
        //         {
        //             echo $dTmp;
        //             $ClassSubjectDetail[] = [$dTmp];
        //             $ClassSubjectDetailTmp->forget($k);
        //         }
        //     }
        // }
        // return json_encode(['x' => $ClassSubjectDetail]);
        // return response()->json(['res_code' => 0, 'res_msg' => '', 'FacultyInformation' => $ClassSubjectDetail, 'ClassSubjectDetailTmp' => count($ClassSubjectDetailTmp), 'ClassSubjectDetailTmp' => $ClassSubjectDetailTmp]);
        return view('control_panel.faculty_schedule.partials.modal_data_class_schedule', compact('ClassSubjectDetail'))->render();
    }

    public function print_handled_subject (Request $request) 
    {
        $FacultyInformation = FacultyInformation::where('status', 1)
            ->where('id', $request->id)
            ->first();
        $SchoolYear = SchoolYear::where('current', 1)->first();
        $ClassSubjectDetail = ClassSubjectDetail::join('subject_details', 'subject_details.id', '=', 'class_subject_details.subject_id')
        ->join('class_details', 'class_details.id', '=', 'class_subject_details.class_details_id')
        ->join('section_details', 'section_details.id', '=', 'class_details.section_id')
        ->join('rooms', 'rooms.id', '=', 'class_details.room_id')
        ->join('school_years', 'school_years.id', '=', 'class_details.school_year_id')
        ->where('faculty_id', $request->id)
        ->whereRaw('
            class_details_id IN ( SELECT id from class_details WHERE school_year_id IN ( SELECT id FROM school_years WHERE status = 1 AND current = 1 ) )
        ')
        ->where('class_subject_details.status', 1)
        ->get();

        $pdf = \PDF::loadView('control_panel.faculty_schedule.partials.report', compact('FacultyInformation', 'ClassSubjectDetail'));
        return $pdf->stream();
        return $pdf->download('invoice.pdf');   
    }

    public function print_handled_subject_all (Request $request) 
    {
        $FacultyInformation = FacultyInformation::where('status', 1)->get();
        $SchoolYear = SchoolYear::where('current', 1)->first();

        $faculty_subjects = [];

        foreach ($FacultyInformation as $fa) 
        {
            $ClassSubjectDetail = ClassSubjectDetail::join('subject_details', 'subject_details.id', '=', 'class_subject_details.subject_id')
            ->join('class_details', 'class_details.id', '=', 'class_subject_details.class_details_id')
            ->join('section_details', 'section_details.id', '=', 'class_details.section_id')
            ->join('rooms', 'rooms.id', '=', 'class_details.room_id')
            ->join('school_years', 'school_years.id', '=', 'class_details.school_year_id')
            ->where('faculty_id', $fa->id)
            ->whereRaw('
                class_details_id IN ( SELECT id from class_details WHERE school_year_id IN ( SELECT id FROM school_years WHERE status = 1 AND current = 1 ) )
            ')
            ->where('class_subject_details.status', 1)
            ->get();
            if (count($ClassSubjectDetail) > 0) 
            {
                $faculty_subjects[] = ['faculty' => $fa, 'subjects' => $ClassSubjectDetail];
            }
        }
        $faculty_subjects = json_decode(json_encode($faculty_subjects));

        // return json_encode($faculty_subjects);
        $pdf = \PDF::loadView('control_panel.faculty_schedule.partials.report_all', compact('faculty_subjects'));
        return $pdf->stream();
        return $pdf->download('invoice.pdf');   
    }
}