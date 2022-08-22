<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
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
        $new_stud=new StudentModel();
        $new_sub=new SubjectModel();
        return view('mark',['new_sub'=>$new_sub->all()],['new_stud'=>$new_stud->all()]);
    }
    public function mark_check(Request $request_mark)
    {
        $valid = $request_mark->validate([
            'stud_id' => 'required|min:1|numeric',
            'sub_id' => 'required|min:1|numeric'

        ]);
        $indexStud = $request_mark->input('stud_id');
        $indexSubj = $request_mark->input('sub_id');
        //$indexGrade = $request->input('Grade');
        DB::table('connect_stud-sub')->insert(
            ['stud_id' => $indexStud,
                'sub_id' => $indexSubj
            ]);


        return redirect()->route('mark');
    }


}
