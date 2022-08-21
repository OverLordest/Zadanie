@extends('shapka')
@section('title')
    Дисциплины
@endsection
@section('main_content')
    <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">Добавить дисциплину:</h1>
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
        <form method="post" action="/subject/check" >
            @csrf
            <input type="subject_name" name="subject" id="subject" placeholder="введите название дисциплины" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <!-- <input type="group" name="group" id="group" placeholder="введите группу" class="form-control" style="width: 400px; padding-left: 10px;" ><br>-->
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>
    <h1>Все дисциплины:</h1>
    <table border = "1">
        <tr>
            <td colspan="2">ID</td>
            <td>Имя</td>
            <td>Удаление</td>
        </tr>
        @foreach($new_sub as $el)
            <!-- <div class="alert alert-warning"  style="width: 300px; padding-left: 10px; high: 100px">-->
            <!--<b>id: {{$el->id}}</b>
            <h3 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">{{$el->student_name}}</h3>-->
            <tr>
                <td colspan="2">{{ $el->id }}</td>
                <td>{{ $el->subject_name }}</td>
                <td><a href = 'delete/{{ $el->id }}'>удалить</a></td>
            </tr>
            <!--</div>-->
        @endforeach
    </table>
@endsection
