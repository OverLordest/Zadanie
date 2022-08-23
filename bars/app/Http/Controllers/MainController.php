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
    public function index()
    {
        return view('index');
    }
    public function students()
    {
        $new_stud=new StudentModel();
        //dd($new_stud->all());
        //DB::delete('deletedelete from student_models where id = 6');
        return view('students',['new_stud'=>$new_stud->all()]);
    }
    public function students_check(Request $request)
    {
        $valid = $request->validate([
            'student' => 'required|min:2|max:40'//,
            // 'group'=>'required|min:2|max:40',
        ]);
        $new_stud = new StudentModel();
        $new_stud->student_name = $request->input('student');
        $new_stud->save();
        return redirect()->route('students');
    }
    public function subjects()
    {
        $new_sub=new SubjectModel();
        return view('subjects',['new_sub'=>$new_sub->all()]);
    }
    public function subject_check(Request $request_sub)
    {
        $valid = $request_sub->validate([
            'subject' => 'required|min:2|max:40'//,
            // 'group'=>'required|min:2|max:40',
        ]);
        $new_sub = new SubjectModel();
        $new_sub->subject_name = $request_sub->input('subject');
        $new_sub->save();
        return redirect()->route('subject');
    }
        public function delstud(){
        $users = DB::select('select * from student_models');
        return view('students',['users'=>$users]);
    }
        public function destroy($id) {
        DB::delete('delete from student_models where id = ?',[$id]);
        echo "запись успешно удалена.<br/>";
        echo '<a href="/students">нажмите для возвращения</a> ';
    }
    public function delsub(){
        $users = DB::select('select * from subject_models');
        return view('subjects',['users'=>$users]);
    }
    public function destroysub($id) {
        DB::delete('delete from subject_models where id = ?',[$id]);
        echo "запись успешно удалена.<br/>";
        echo '<a href="/subjects">нажмите для возвращения</a> ';
    }
    public function mark()
    {
        //$new_stud=new StudentModel();
        //$new_sub=new SubjectModel();
        //return view('mark',['new_sub'=>$new_sub->all()],['new_stud'=>$new_stud->all()]);
        return view('mark');
    }
    public function mark_check(Request $request_mark)
    {
        $valid = $request_mark->validate([
            'stud_id' => 'required|min:1|numeric',
            'sub_id' => 'required',
            //'grade'

        ]);
        $indexStud = $request_mark->input('stud_id');
        $indexSubj = $request_mark->input('sub_id');
      //  $grade = $request_mark->input('grade');
        $indSub = DB::table('subject_models')->where('subject_name',$indexSubj)->value('id');
        DB::table('connect_stud-sub')->insert(
            ['stud_id' => $indexStud,
                'sub_id' => $indSub,
              //  'grade'=>$grade
            ]);


        return redirect()->route('mark');
    }
    public function sub()
    {
        //$new_stud=new StudentModel();
        //$new_sub=new SubjectModel();
       // $new_sub_check = new SubjectSearchModel();
        //return view('sub',['new_sub'=>$new_sub->all()],['new_sub_check'=>$new_sub_check->all()]);
        return view('sub',['content' => []]);
    }
    public function sub_check(Request $request_sub_search)
    {
        $valid = $request_sub_search->validate([
           'sub_id' => 'required|min:1|max:40'//,
            // 'group'=>'required|min:2|max:40',
        ]);
       // $new_sub_check = new SubjectSearchModel();
       // $new_sub_check->subject_name = $request_sub_search->input('subject');
       // $new_sub_check->save();
      //  $new_sub_check=DB::table('connect_stud-sub')->select(

       //     'select * from stud_id where sub_id = $indexSubj', ['sub_id'=>$request_sub_search]);


        //return view('sub',['stud_id'=>$new_sub_check]);
        $indexSubj = $request_sub_search->input('sub_id');

        $idSubj = DB::table('subject_models')->where('subject_name',$indexSubj)->value('id');

        $idStud = DB::table('connect_stud-sub')->where('sub_id',$idSubj)->get();
        //dd($idStud);
        $StudT = $idStud->toArray();
        //dd($idStud->toArray()[0]->id);
        $Stud = array_column($StudT,'stud_id');
        $StudT = DB::table('student_models')->whereIn('id',$Stud)->get();

        //dd($Stud);
        return view('sub',['content' => $StudT]);
    }
    public function Grade_check(Request $request){
        $valid = $request->validate([
            'stud_id' => 'required|numeric',
            'sub_id' => 'required',
            'grade' => 'required|numeric|min:0|max:5'
        ]);

        $indexStudGrade = $request->input('stud_id');
        $indexSubjGrade = $request->input('sub_id');
        $indexGrade = $request->input('grade');



        $idSubj = DB::table('subject_models')->where('subject_name',$indexSubjGrade)->value('id');

        $idSubjCheck = DB::table('subject_models')->where('subject_name',$indexSubjGrade)->value('id');
        $idStudCheck = DB::table('subject_models')->where('subject_name',$indexSubjGrade)->value('id');

        if($idSubjCheck == NULL){
            return view('grades',['erro' => 'Такого предмета несуществует']);
        }

        if($idStudCheck == NULL){
            return view('grades',['erro' => 'Такого предмета несуществует']);
        }

        DB::table('connect_stud-sub')
            ->where('sub_id', $idSubj)
            ->where('stud_id', $indexStudGrade)
            ->update(['grade' => $indexGrade]);



        return redirect()->route('mark');
    }

}
