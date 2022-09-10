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

    <div id="ShowStudents">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                    <v-row>
                        <v-col sm="4">
                            <v-text-field
                                solo
                                label="Введите название дисциплины"
                                v-model = "subject"
                                :rules="subject_rules"
                                :counter="40"
                                required>
                            </v-text-field>
                            <v-btn
                                @click="ShowTableMark">
                                Показать
                            </v-btn>
                        </v-col>
                    </v-row>
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
                    valid: false,
                    subject_rules: [
                        v => !!v || 'Дисциплина не должна быть пустой',
                        v => v.length <= 40 || 'Дисциплина не должна быть длиннее 40 символов',
                    ],
                }
            },
            methods:{
                Students_fill(){
                    let this_ = this
                    this.students=[]
                    let id_stud=this.students_[0].id
                    console.log(this.students_.id);
                    let row={id: '', student_name: '',subject_name:'', km1: '0' ,km2: '0' ,km3: '0', km4: '0'}
                    this.students_.forEach(function fun (curVal){
                        //console.log('curVal=',curVal)
                       // console.log('id_stud=',id_stud)
                        if(curVal.id===id_stud)
                        {
                           // console.log('зашли в if')
                        }
                        else{
                           // console.log('зашли в else')
                           // console.log('row =',row)
                            this_.students.push(row)
                           // console.log('students =', this_.students)
                            row={id: '', student_name: '',subject_name:'', km1: '0' ,km2: '0' ,km3: '0', km4: '0'}
                            id_stud=curVal.id
                           // console.log(id_stud)
                        }
                        row['id']=curVal.id
                        row['student_name']=curVal.student_name
                        row['subject_name']=curVal.subject_name
                       // console.log('id=',curVal.id,id_stud)
                     //   console.log('grade=',curVal.grade)
                      //  console.log('KM_num=',curVal.KM_Num)
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
                       // console.log('row в конце foreach =', row)
                    })
                    this_.students.push(row)
                    //console.log('students = ',this.students)
                },
                ShowTableMark(){
                    let data = new FormData()
                    data.append('subject',this.subject)
                   // console.log(this.subject);
                       // console.log(data);
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
                                    //console.log(array);
                                this.students_ = array
                          //  console.log(this.students_);
                                this.Students_fill()

                        })
                },

            }
        })
    </script>

@endsection
