<?php

namespace App\Http\Controllers\Faculty;

use App\Models\Assessment;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use App\Traits\HasFacultyDetails;
use App\Models\ClassSubjectDetail;
use App\Models\FacultyInformation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    use HasFacultyDetails;

    private function schoolYear(){
        return $School_year_id = SchoolYear::whereStatus(1)->whereCurrent(1)->orderBy('school_year', 'DESC')->first()->id;
    }

    public function index(Request $request)
    {
        $faculty_id = $this->faculty()->id;
        $School_year_id = $this->schoolYear();

        $ClassSubjectDetail = ClassSubjectDetail::join('class_details', 'class_details.id', '=', 'class_subject_details.class_details_id')
            ->join('subject_details', 'subject_details.id', '=', 'class_subject_details.subject_id')
            ->join('section_details', 'section_details.id', '=', 'class_details.section_id')
            ->where('faculty_id', $faculty_id)
            ->where('class_details.school_year_id', $School_year_id)
            ->where('class_subject_details.status', '!=', 0)
            ->where('class_details.status', 1)
            ->select(\DB::raw('  
                class_subject_details.id,
                class_subject_details.class_schedule,
                class_subject_details.class_time_from,
                class_subject_details.class_time_to,
                class_subject_details.class_days,
                subject_details.subject_code,
                subject_details.subject,
                section_details.section,
                class_details.grade_level
            '))
            ->get();

        // return json_encode($ClassSubjectDetail);
        
        return view('control_panel_faculty.assessment.index', compact('ClassSubjectDetail'));
    }

    public function archive(Request $request)
    {
        try {
            
            $assessment = Assessment::find($request->id);
            $assessment->exam_status = 2;
            $assessment->save();
            
            return response()->json(['res_code' => 0, 'res_msg' => 'Assessment successfully moved to archive.', 'data' => $assessment ]);
        } catch (\Throwable $th) {
            return response()->json(['res_code' => 1, 'res_msg' => 'This action something went wrong.' ], 402);
        }
        
    }

    public function publish(Request $request)
    {
        try {
            
            $assessment = Assessment::find($request->id);
            $assessment->exam_status = ($request->type == 'publish' ? 1 : 0);
            $assessment->save();
            
            return response()->json(['res_code' => 0, 'res_msg' => 'Assessment successfully moved to '.$request->type == 'publish' ? 'unpublished' : 'published']);
        } catch (\Throwable $th) {
            return response()->json(['res_code' => 1, 'res_msg' => 'This action something went wrong.' ], 402);
        }
        
    }
}