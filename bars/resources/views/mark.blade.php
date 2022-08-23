@extends('shapka')
@section('title')
    Оценки
@endsection
@section('main_content')
        <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0"> Привязка студента:</h1>
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
    <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <form method="post" action="/mark/check" >
            @csrf
            <input type="stud_id" name="stud_id" id="stud_id" placeholder="введите id студента" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <input type="sub_id" name="sub_id" id="sub_id" placeholder="введите название предмета" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
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

