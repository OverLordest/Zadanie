@extends('shapka')
@section('title')
    Оценки/привязка
@endsection
@section('main_content')
    <!--Здесь привязка и проставление оценок-->
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
    <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">Привязкак студентов:</h1>
    <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">

        <br>
        <!--Форма для привязки-->
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
        <!--Форма для проставления оценок-->
        <form method="post" action="/mark/grade_check" style="width: 400px; padding-left: 10px;">
            @csrf
            <input type="stud_id" name="stud_id" id="stud_id" placeholder="введите id студента" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <input type="sub_id" name="sub_id" id="sub_id" placeholder="введите название предмета" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <input type="grade" name="grade" id="grade" placeholder="введите оценку" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>
    <div class="flex-center position-ref full-height" id="MainVue">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                    <h3>Простановка оценок:</h3>
                    <v-text-field
                        v-model="stud_id"
                        label="id студента"
                    >
                    </v-text-field>
                    <v-text-field
                        v-model="sub_id"
                        label="Название предмета"
                    >
                    </v-text-field>
                    <v-text-field
                        v-model="KM_Num"
                        label="Номер КМа"
                    >
                    </v-text-field>
                    <v-text-field
                        v-model="grade"
                        label="Оценка"
                    >
                    </v-text-field>
                    <v-btn
                        @click="Grade_check">
                        Добавить
                    </v-btn>
                    <br>
                    <br>
                    <!--   <h3>Студенты:</h3>
                        <v-data-table
                            v-model="selected"
                            :headers="headers"
                            :items="Marks"
                            :single-select=true
                            show-select
                            class="elevation-1"
                            :search="search">
                            <template v-slot:top>
                                <v-text-field
                                    v-model="search"
                                    label="Поиск"
                                    class="mx-4"
                                ></v-text-field>

                            <   <v-btn
                                    @click="deleteByName">
                                    Удалить по выбраному
                                </v-btn>
                            </template>
                        </v-data-table>-->
                </v-form>
            </v-main>
        </v-app>
    </div>


    <script>
        var r = new Vue({
            el: '#MainVue',

            vuetify: new Vuetify(),

            data(){

                return({
                    stud_id:'',
                    sub_id: '',
                    KM_Num:'',
                    grade:'',
                    vis: true,
                    Marks: [],
                 //   search: '',
                   // selected: [],
               /*     headers: [
                        {
                            align: 'start',
                            sortable: false,
                        },
                        { text: 'ID', value: 'id' },
                        { text: 'ФИО', value: 'student_name' },
                    ],*/
                })},

            methods:{

                Grade_check(){
                    let data = new FormData()
                    data.append('stud_id',this.stud_id)
                    data.append('sub_id',this.sub_id)
                    data.append('KM_Num',this.KM_Num)
                    data.append('grade',this.grade)
                    fetch('Grade_check',{
                        method:'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body:data
                    })
                    fetch('showTable',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    })
                        .then((response)=>{
                            return response.json()
                        })
                        .then((data)=>{
                            this.Marks = data.Marks
                            //console.log(data.users)
                        })
                },
            },
            mounted: function (){

                fetch('showTable',{
                    method:'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                })
                    .then((response)=>{
                        return response.json()
                    })
                    .then((data)=>{
                        this.Marks = data.Marks
                        //console.log(data.users)
                    })
            }

        })
    </script>
@endsection

