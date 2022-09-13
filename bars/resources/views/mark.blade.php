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
    <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">

        <!--Форма для привязки-->
    </div>
    <h1 class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">Простановка оценок:</h1>
    <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <br>
        <!--Форма для проставления оценок-->
     <!--   <form method="post" action="/mark/grade_check" style="width: 400px; padding-left: 10px;">
            @csrf
            <input type="stud_id" name="stud_id" id="stud_id" placeholder="введите id студента" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <input type="sub_id" name="sub_id" id="sub_id" placeholder="введите название предмета" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <input type="grade" name="grade" id="grade" placeholder="введите оценку" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>-->
    </div>
    <div class="flex-center position-ref full-height" id="app">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                    <h3>Выбор предмета</h3>
                    <v-autocomplete
                        label="Предметы"
                        :items="subjs"
                        item-text="subject_name"
                        v-model="sub_id"

                        clearable
                        filled
                        rounded
                        solo
                    ></v-autocomplete>

                    <h3>Выбор студента</h3>

                    <v-autocomplete
                        v-model="stud_id"
                        label="Студенты"
                        :items="names"
                        item-text="student_name"
                        item-value="id"

                        clearable
                        filled
                        rounded
                        solo
                    ></v-autocomplete>
                    <v-btn
                        @click="sendPriv">
                        Привязать
                    </v-btn>
                    <!--<v-text-field
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
                        @click="sendMark">
                        Проставить оценку
                    </v-btn>-->
                </v-form>
                <br>
              <!--  <v-data-table
                    :headers="headers"
                    :items="students"
                    :single-select= true
                    item-key="name"
                    show-select
                    class="elevation-1">
                    <template v-slot:top>
                    </template>
                </v-data-table>-->

            </v-main>
        </v-app>
    </div>


    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data(){
                return{
                    selected: [],
                    /*headers: [
                        {
                            text: 'ID Студента',
                            align: 'start',
                            value: 'id',
                        },
                        { text: 'ФИО студента', value: 'student_name' },
                        { text: 'Предмет', value: 'subject_name' },
                        { text: 'КМ1', value: 'km1' },
                        { text: 'КМ2', value: 'km2' },
                        { text: 'КМ3', value: 'km3' },
                        { text: 'КМ4', value: 'km4' },
                        { text: 'Оценка', value: 'grade' },
                    ],*/
                    students_: [],
                    students: [],
                    subject:'',
                   // original_students: [],
                    names:[],
                    ids:[],
                    subjs:[],
                    search: '',
                    searchSubj: '',
                    valid: false,
                    stud_id:[],
                    sub_id:[],
                   // KM_Num:[],
                   // grade:[],
                }
            },
            methods:{
                sendPriv(){
                    /*let data = new FormData()
                    data.append('sub_id',this.sub_id)
                    data.append('stud_id',this.stud_id)
                    console.log(this.sub_id)
                    console.log(this.stud_id)
                    console.log(data)*/
                    var step;
                    for(step=1;step<2;step++){
                        let data = new FormData()
                        data.append('sub_id',this.sub_id)
                        data.append('stud_id',this.stud_id)
                        data.append('step',step)
                        //console.log(this.sub_id)
                        //console.log(this.stud_id)
                        //console.log(step)
                        //console.log(data)
                    fetch('/mark/check',{
                        method:'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body:data
                    });}
                    /*fetch('/mark/check',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    })*/

                },/*
                sendMark(){
                    let data = new FormData()
                    data.append('sub_id',this.sub_id)
                    data.append('stud_id',this.stud_id)
                    data.append('KM_Num',this.KM_Num)
                    console.log(this.sub_id)
                    console.log(this.stud_id)
                    console.log(this.KM_Num)
                    data.append('grade',this.grade)
                    console.log(this.grade)
                    //console.log(data)
                    fetch('Grade_check',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    })

                },*/
                showTableUsersBySubj(){

                    let data = new FormData()
                    fetch('showTable',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    })
                        .then((response)=>{
                            return response.json()
                        })
                        .then((data)=>{
                            this.names = data.users
                            console.log(data.users)
                        })


                },
                showTableSubj(){
                    let data = new FormData()
                    fetch('showTableSub',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    })
                        .then((response)=>{
                            return response.json()
                        })
                        .then((data)=>{
                            this.subjs = data.subj
                        })
                },


            },
            mounted: function (){
                console.log("Mounted start")
                this.showTableSubj();
                this.showTableUsersBySubj();
            }
        })
    </script>
@endsection

