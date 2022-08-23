@extends('shapka')
@section('title')
    Оценки/привязка
@endsection
@section('main_content')

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>
                        {{$error}}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">Привязкак студентов:</h1>
    <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">

        <br>
        <form method="post" action="/mark/check" style="width: 400px; padding-left: 10px;">
            @csrf
            <input type="stud_id" name="stud_id" id="stud_id" placeholder="введите id студента" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <input type="sub_id" name="sub_id" id="sub_id" placeholder="введите название предмета" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>
    <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">Простановка оценок:</h1>
    <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">

        <br>
        <form method="post" action="/mark/grade_check" style="width: 400px; padding-left: 10px;">
            @csrf
            <input type="stud_id" name="stud_id" id="stud_id" placeholder="введите id студента" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <input type="sub_id" name="sub_id" id="sub_id" placeholder="введите название предмета" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <input type="grade" name="grade" id="grade" placeholder="введите оценку" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>
   <!-- <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0"> выставление оценки студенту:</h1>
        <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">

            <input type="stud_id" name="stud_id" id="stud_id" placeholder="введите id студента" class="form-control" style="width: 300px; padding-left: 10px;" ><br>
            <input type="sub_id" name="sub_id" id="sub_id" placeholder="введите id предмета" class="form-control" style="width: 300px; padding-left: 10px;" ><br>
            <input type="grade" name="grade" id="grade" placeholder="введите оценку" class="form-control" style="width: 300px; padding-left: 10px;" ><br>
        <button type="submit" class="btn btn-success">Принять</button><br>
        </div>-->
@endsection

