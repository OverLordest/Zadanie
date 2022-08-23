@extends('shapka')
@section('title')
    Поиск по предмету:
@endsection
@section('main_content')
    <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0"> Поиск студентов по предмету:</h1>
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
        <form method="post" action="/sub/check" >
            @csrf
            <input type="sub_id" name="sub_id" id="sub_id" placeholder="введите название предмета" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>
    <table border = "1">
        <tr>
            <td >ID</td>
            <td>Имя студента</td>
        </tr>
        @foreach($content as $el)
            <tr>
                <td>{{ $el->id}}</td>
                <td>{{$el->student_name}}</td>

            </tr>
        @endforeach
    </table>


@endsection
