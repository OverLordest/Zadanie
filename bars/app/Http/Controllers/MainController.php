<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StudentModel;
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
        //DB::delete('deletedelete from student_models where id = 5');
        return view('students',['new_stud'=>$new_stud->all()]);
    }
    public function subjects()
    {
        return view('subjects');
    }
    public function students_check(Request $request)
    {
        $valid = $request->validate([
            'student'=>'required|min:2|max:40'//,
           // 'group'=>'required|min:2|max:40',
        ]);
        $new_stud = new StudentModel();
        $new_stud->student_name=$request->input('student');
        $new_stud->save();
        return redirect()->route('students');
    }



}
