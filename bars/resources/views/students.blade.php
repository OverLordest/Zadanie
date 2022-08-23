@extends('shapka')
@section('title')
    Студенты
@endsection
@section('main_content')
    <!--Добавление студентов-->
    <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">Добавить студента:</h1>
    <!--Вывод ошибок-->
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
        <!--Форма для добавления студентов-->
        <form method="post" action="/students/check" >
            @csrf
            <input type="student_name" name="student" id="student" placeholder="введите имя студента" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>
    <!--Вывод-->
    <h1>Все студенты:</h1>
    <table border = "1">
        <tr>
            <td colspan="2">ID</td>
            <td>Имя</td>
            <td>Удаление</td>
        </tr>
    @foreach($new_stud as $el)
            <tr>
                <td colspan="2">{{ $el->id }}</td>
                <td>{{ $el->student_name }}</td>
                <td><a href = 'deletestud/{{ $el->id }}'>удалить</a></td>
            </tr>
@endforeach
    </table>
@endsection
