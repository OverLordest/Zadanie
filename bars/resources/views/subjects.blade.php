@extends('shapka')
@section('title')
    Дисциплины
@endsection
@section('main_content')
    <!--Добавление дисциплин-->
    <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">Добавить дисциплину:</h1>
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
    <!--Форма для добавления дисциплин-->
    <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <form method="post" action="/subject/check" >
            @csrf
            <input type="subject_name" name="subject" id="subject" placeholder="введите название дисциплины" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>
    <!--Вывод-->
    <h1>Все дисциплины:</h1>
    <table border = "1">
        <tr>
            <td colspan="2">ID</td>
            <td>Имя</td>
            <td>Удаление</td>
        </tr>
        @foreach($new_sub as $el)
            <tr>
                <td colspan="2">{{ $el->id }}</td>
                <td>{{ $el->subject_name }}</td>
                <td><a href = 'deletesub/{{ $el->id }}'>удалить</a></td>
            </tr>
        @endforeach
    </table>
@endsection
