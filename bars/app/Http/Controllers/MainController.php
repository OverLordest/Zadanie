<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\SubjectSearchModel;
use Illuminate\Http\Request;
use App\StudentModel;
use App\SubjectModel;
use Illuminate\Support\Facades\DB;
class MainController extends Controller
{
//сновная страница
    public function index()
    {
        return view('index');
    }
//студенты
    public function students()
    {
        $new_stud=new StudentModel();
        return view('students',['new_stud'=>$new_stud->all()]);
    }

    public function showTable(){
        $users = DB::table('student_models')->get();
        return response()->json(['users' => $users]);
    }
    public function sendName(request $request){
        $index = $request->input('FIO');
        DB::table('student_models')->insert(
            ['student_name' => $index]
        );
        return view('students');
    }
    public function deleteName(request $request){

        $index = $request->input('deleteID');
        DB::delete('delete from student_models where id = ?',[$index]);
        DB::delete('delete from [connect_stud-sub] where stud_id = ?',[$index]);

    }
//предметы
    public function subjects()
    {
        $new_sub=new SubjectModel();
        return view('subjects',['new_sub'=>$new_sub->all()]);
    }
   /* public function subject_check(Request $request_sub)
    {
        $valid = $request_sub->validate([
            'subject' => 'required|min:2|max:40'
        ]);
        $new_sub = new SubjectModel();
        $new_sub->subject_name = $request_sub->input('subject');
        $new_sub->save();
        return redirect()->route('subject');
    }*/
    public function showTableSub(){
        $subj = DB::table('subject_models')->get();
        return response()->json(['subj' => $subj]);
    }
    public function sendSubject(request $request){
        $index = $request->input('Subject');
        DB::table('subject_models')->insert(
            ['subject_name' => $index]
        );
        return view('subjects');
    }
    public function deleteSubject(request $request){

        $index = $request->input('deleteID');
        DB::delete('delete from subject_models where id = ?',[$index]);
        DB::delete('delete from [connect_stud-sub] where sub_id = ?',[$index]);

    }
//оценки и привязка
    public function mark()
    {
        return view('mark');
    }
    public function mark_check(Request $request_mark)//Привяка
    {
        $valid = $request_mark->validate([
            'stud_id' => 'required',
            'sub_id' => 'required',
         //   'step' => 'required',
        ]);
        $indexStud = $request_mark->input('stud_id');
        $indexSubj = $request_mark->input('sub_id');
        //$step = $request_mark->input('step');
        $indSub = DB::table('subject_models')->where('subject_name',$indexSubj)->value('id');
        //$indStud = DB::table('student_models')->where('student_name',$indexStud)->value('id');
        //$step=1;
        for($step=1;$step<5;$step++){
            DB::table('connect_stud-sub')->insert(
                ['stud_id' => $indexStud,
                    'sub_id' => $indSub,
                    'KM_Num' =>$step,
                ]);
            //echo $step;
        }
       /* DB::table('connect_stud-sub')->insert(
            ['stud_id' => $indexStud,
                'sub_id' => $indSub,
                'KM_Num' =>$step,
            ]);*/


        return redirect()->route('mark');
    }
    public function Grade_check(Request $request){
        /*$valid = $request->validate([
            'stud_id' => 'required',
            'sub_id' => 'required',
            'KM_Num'=>'required|numeric|min:0',
            'grade' => 'required|numeric|min:0|max:5'
        ]);*/
        //dd($request)
        $indexStud = $request->input('stud_id');
        $indexSubj = $request->input('sub_id');
        $indexKM_num=$request->input('KM_Num');
        $indexGrade = $request->input('grade');

        $indSub = DB::table('subject_models')->where('subject_name',$indexSubj)->value('id');
        //$idSubjCheck = DB::table('subject_models')->where('subject_name',$indexSubjGrade)->value('id');
        //$idStudCheck = DB::table('subject_models')->where('subject_name',$indexSubjGrade)->value('id');

        /*if($idSubjCheck == NULL){
            return view('grades',['erro' => 'Такого предмета несуществует']);
        }

        if($idStudCheck == NULL){
            return view('grades',['erro' => 'Такого предмета несуществует']);
        }*/
        DB::table('connect_stud-sub')
            ->where('sub_id', $indSub )
            ->where('stud_id', $indexStud)
            ->where('KM_Num', $indexKM_num)
            ->update(['grade' => $indexGrade]);
       // ->insert(['grade'=>$indexGrade]);
         return redirect()->route('mark');
    }
//поиск по предметам
    public function sub()
    {
        return view('sub',['content' => []]);
    }
    public function ShowTableMark(Request $show_request)
    {
        $show_subj = $show_request->input('subject');
        $selection = DB::select("SELECT
            student_models.student_name,
            [connect_stud-sub].grade,
            [connect_stud-sub].KM_Num,
            subject_models.subject_name,
            [connect_stud-sub].sub_id,
            student_models.id
        FROM student_models
        JOIN [connect_stud-sub]
        ON student_models.id = [connect_stud-sub].stud_id
        JOIN subject_models
        ON subject_models.id = [connect_stud-sub].sub_id WHERE subject_name = '".$show_subj ."'
        ORDER BY student_models.id,[connect_stud-sub].KM_Num;");
        return json_encode([$selection/*$stud*/]);

    }

}
