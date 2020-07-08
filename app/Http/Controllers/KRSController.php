<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class KRSController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    function krsresponse($code, $message, $data){
        $response=[
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        return $response;
    }

    function index(){
        $krs_table = DB::select("SELECT krs_table.krs_id, krs_table.student_nim, student_table.student_name, 
        krs_table.course_code, courses_table.courses_name, krs_table.lecturer_nidn, lecturer_table.lecturer_name, 
        krs_table.amount_sks, krs_table.semester_code, semester_table.year, semester_table.information FROM krs_table 
        JOIN student_table ON krs_table.student_nim=student_table.student_nim 
        JOIN courses_table ON krs_table.course_code=courses_table.courses_code 
        JOIN lecturer_table ON krs_table.lecturer_nidn=lecturer_table.lecturer_nidn
        JOIN semester_table ON krs_table.semester_code=semester_table.semester_code");
        return json_encode(
            $this->krsresponse(2200, 'success', $krs_table)
        );
    }
    function krs_print(Request $request){
        $student_nim = $request->input('student_nim');
        $semester_code = $request->input('semester_code');

        $krs_table = DB::select("SELECT krs_table.krs_id, krs_table.student_nim, student_table.student_name, 
        krs_table.course_code, courses_table.courses_name, krs_table.lecturer_nidn, lecturer_table.lecturer_name, 
        krs_table.amount_sks, krs_table.semester_code, major_table.major_name, major_table.major_code, semester_table.year, semester_table.information FROM krs_table 
        JOIN student_table ON krs_table.student_nim=student_table.student_nim 
        JOIN courses_table ON krs_table.course_code=courses_table.courses_code 
        JOIN lecturer_table ON krs_table.lecturer_nidn=lecturer_table.lecturer_nidn
        JOIN semester_table ON krs_table.semester_code=semester_table.semester_code
        JOIN major_table ON student_table.major_code=major_table.major_code
        WHERE student_table.student_nim='$student_nim'
        AND semester_table.semester_code='$semester_code'");

        $krs = array();

        foreach ($krs_table as $item){
            $data_krs=[
                'course_code' => $item->course_code,
                'courses_name' => $item->courses_name,
                'semester' => $item->semester_code,
                'lecturer_name' => $item->lecturer_name,
                'amount_sks' => $item->amount_sks
            ];

            array_push($krs, $data_krs);
        }
        $data =array (
            'student_nim' => $krs_table[0]->student_nim,
            'student_name' => $krs_table[0]->student_name,
            'major_code' => $krs_table[0]->major_code,
            'major_name' => $krs_table[0]->major_name,
            'krs' => $krs
        );

        return json_encode(
            $this->krsresponse(2200,'success', $data)
        );
    }
}