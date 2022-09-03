@extends('shapka')
@section('title')
    Поиск по предмету:
@endsection
@section('main_content')
    <!--Здесь выполняется поиск студентов по предметам-->
    <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0"> Поиск студентов по предмету:</h1>
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
    <!--Форма поиска студента-->
    <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <form method="post" action="/sub/check" ><!--Форма добавления предмета-->
            @csrf
            <input type="sub_id" name="sub_id" id="sub_id" placeholder="введите название предмета" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>
    <!--Вывод-->
    <div id="app" >
        <v-app id="inspire" >
            <v-card >
                <v-card-title >
                    Студенты по данной дисциплине:
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="mdi-magnify"
                        label="Поиск студента"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table
                    :headers="headers"
                    :items="desserts"
                    :search="search"
                ></v-data-table>
            </v-card>
        </v-app>

    </div>
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data () {
                return {
                    search: '',
                    headers: [
                        { text: 'ID', value: 'id' },
                        { text: 'имя стдента', value: 'StudName' },
                        { text: 'Оценка', value: 'grade',sortable: false },
                    ],
                    desserts: [
                            @foreach($content as $el)
                        {
                            id: {{ $el->id }},
                            StudName: '{{$el->student_name}}',
                            grade: '{{$el->grade}}',
                            //DelStud: <button></button>,

                        },

                        @endforeach

                    ],
                        }
                    },
        })
    </script>

@endsection
