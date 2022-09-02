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
    public function students_check(Request $request)
    {
        $valid = $request->validate([
            'student' => 'required|min:2|max:40'
        ]);
        $new_stud = new StudentModel();
        $new_stud->student_name = $request->input('student');
        $new_stud->save();
        return redirect()->route('students');
    }
//предметы
    public function subjects()
    {
        $new_sub=new SubjectModel();
        return view('subjects',['new_sub'=>$new_sub->all()]);
    }
    public function subject_check(Request $request_sub)
    {
        $valid = $request_sub->validate([
            'subject' => 'required|min:2|max:40'
        ]);
        $new_sub = new SubjectModel();
        $new_sub->subject_name = $request_sub->input('subject');
        $new_sub->save();
        return redirect()->route('subject');
    }
//оценки и привязка
    public function mark()
    {
        return view('mark');
    }
    public function mark_check(Request $request_mark)
    {
        $valid = $request_mark->validate([
            'stud_id' => 'required|min:1|numeric',
            'sub_id' => 'required',
        ]);
        $indexStud = $request_mark->input('stud_id');
        $indexSubj = $request_mark->input('sub_id');
        $indSub = DB::table('subject_models')->where('subject_name',$indexSubj)->value('id');
        DB::table('connect_stud-sub')->insert(
            ['stud_id' => $indexStud,
                'sub_id' => $indSub
            ]);


        return redirect()->route('mark');
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
//поиск по предметам
    public function sub()
    {
        return view('sub',['content' => []]);
    }
    public function sub_check(Request $request)
    {
        $valid = $request->validate([
            'sub_id' => 'required|min:1',
        ]);


        $indexSubj = $request->input('sub_id');

        $sel = DB::select('SELECT
            student_models.student_name,
            subject_models.subject_name,
            [connect_stud-sub].grade,
            [connect_stud-sub].id
        FROM student_models
        JOIN [connect_stud-sub]
        ON student_models.id = [connect_stud-sub].stud_id
        JOIN subject_models
        ON subject_models.id = [connect_stud-sub].sub_id;');

        $tempSel = collect($sel);
        $TSel = $tempSel ->whereIn('subject_name',$indexSubj);

        return view('sub',['content' => $TSel]);
    }
 //удаление студетов
        public function destroy($id) {
        DB::delete('delete from student_models where id = ?',[$id]);
        DB::delete('delete from [connect_stud-sub] where stud_id = ?',[$id]);
        echo "запись успешно удалена.<br/>";
        echo '<a href="/students">нажмите для возвращения</a> ';
    }
 //удаление предметов
    public function destroysub($id) {
        DB::delete('delete from subject_models where id = ?',[$id]);
        DB::delete('delete from [connect_stud-sub] where sub_id = ?',[$id]);
        echo "запись успешно удалена.<br/>";
        echo '<a href="/subjects">нажмите для возвращения</a> ';
    }
}
