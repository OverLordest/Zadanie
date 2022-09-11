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

    <div id="ShowStudents">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                <h4>Выбор предмета</h4>
                <v-autocomplete
                    label="Предметы"
                    :items="subjs"
                    item-text="subject_name"
                    v-model="selectedSubj"
                    @change="ShowTableMark()"
                    clearable
                    filled
                    rounded
                    solo
                ></v-autocomplete>

                <h3>Просмотр студентов изучающих дисциплину</h3>

                <v-autocomplete
                    label="Студенты"
                    :items="names"
                    item-text="student_name"
                    item-value="id"
                    v-model="ids"
                    @change="FUNC()"
                    clearable
                    filled
                    rounded
                    solo
                ></v-autocomplete>

                </v-form>
                <br>
                <v-data-table
                    :headers="headers"
                    :items="students"
                    :single-select= true
                    item-key="name"
                    show-select
                    class="elevation-1">
                    <template v-slot:top>
                    </template>
                </v-data-table>
            </v-main>
        </v-app>
    </div>
    <script>
        new Vue({
            el: '#ShowStudents',
            vuetify: new Vuetify(),
            data(){
                return{
                    selected: [],
                    headers: [
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
                    ],
                    students_: [],
                    students: [],
                    subject:'',
                    original_students: [],
                    names:[],
                    ids:[],
                    subjs:[],
                    search: '',
                    searchSubj: '',
                    valid: false,
                }
            },
            methods:{
                FUNC(){
                    if ((this.ids == '') || (this.ids == null)){
                        this.students = this.original_students
                    }
                    else{
                        this.students = this.original_students.filter(ides => ides.id == this.ids);
                    }

                },
                Students_fill(){
                    let this_ = this
                    this.students=[]
                    let id_stud=this.students_[0].id
                    console.log(this.students_.id);
                    let row={id: '', student_name: '',subject_name:'', km1: '0' ,km2: '0' ,km3: '0', km4: '0'}
                    this.students_.forEach(function fun (curVal){
                        if(curVal.id!==id_stud)
                        {
                            this_.students.push(row)
                            row={id: '', student_name: '',subject_name:'', km1: '0' ,km2: '0' ,km3: '0', km4: '0'}
                            id_stud=curVal.id
                        }
                        row['id']=curVal.id
                        row['student_name']=curVal.student_name
                        row['subject_name']=curVal.subject_name
                        if(curVal.KM_Num == 1){
                            row['km1']=curVal.grade
                        }
                        else if(curVal.KM_Num == 2){
                            row['km2']=curVal.grade
                        }
                        else if(curVal.KM_Num == 3){
                            row['km3']=curVal.grade
                        }
                        else if(curVal.KM_Num == 4){
                            row['km4']=curVal.grade
                        }
                    })
                    this_.students.push(row)
                    this.original_students = this_.students;
                },
                ShowTableMark(){
                    let data = new FormData()
                    let result = this.selectedSubj
                    data.append('subject',result)
                    fetch('ShowTableMark',{
                        method: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body: data
                    })
                        .then((response)=>{
                            return response.json()
                        })
                        .then((data)=>{
                                array = Object.values(data[0])
                                this.students_ = array
                                this.Students_fill()

                        })
                },
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
