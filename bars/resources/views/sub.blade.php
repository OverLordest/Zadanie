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
        <v-app id="inspire">
            <v-main>
                <v-form v-model="valid">
                <h4>Выбор предмета</h4>
                <v-autocomplete
                    label="Предметы"
                    :items="subjs"
                    item-text="subject_name"
                    item-value="subjectID"
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
                    :items="original_students"
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
                    class="elevation-1">
                    <template
                        v-slot:item._actions="{ item }"
                    >
                        <v-btn
                            dark
                            @click="openChangeDilog(item)"
                        >
                            <v-icon>
                                mdi-pencil
                            </v-icon>
                        </v-btn>
                        <v-btn
                            color="red"
                            dark
                            @click="Open_dialog_del(item)"
                        >
                            <v-icon
                            >
                                mdi-delete
                            </v-icon>
                        </v-btn>

                    </template>

                </v-data-table>
            </v-main>
            <v-dialog
                v-model="ChangeDialog"
                width="800"
            >
                <v-card>
                    <v-card-title class="text-h5 grey lighten-2">
                        Изменение оценок за КМ
                    </v-card-title>

                    <v-divider></v-divider>

                    <v-card-actions>


                            <v-spacer></v-spacer>
                            <v-column>
                            <v-text-field
                                v-model="KM[0]"
                                label="KM 1"
                                class="mx-4"
                            ></v-text-field>

                            <v-text-field
                                v-model="KM[1]"
                                label="КМ 2"
                                class="mx-4"
                            ></v-text-field>
                            </v-column>
                        <v-column>
                            <v-text-field
                                v-model="KM[2]"
                                label="КМ 3"
                                class="mx-4"
                            ></v-text-field>

                            <v-text-field
                                v-model="KM[3]"
                                label="КМ 4"
                                class="mx-4"
                            ></v-text-field>
                        </v-column>
                        <v-divider></v-divider>

                        <v-spacer></v-spacer>
                        <v-row>
                        <v-btn
                            color="primary"
                            text
                           @click="ChangeMark"
                        >
                            Изменение
                        </v-btn>

                        <v-btn
                            color="primary"
                            text
                            @click="ChangeDialog = false"
                        >
                            Выйти
                        </v-btn>
                        </v-row>

                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-dialog
                v-model="dialog_del"
                width="400"
            >

                <v-card>
                    <v-card-title class="text-h5 grey lighten-2">
                        Удаление привязки студента
                    </v-card-title>

                    <v-divider></v-divider>
                    <v-card-text>
                        Вы точно уверены?
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-divider></v-divider>

                        <v-btn
                            color="primary"
                            text
                            icon @click="Priv_del"
                        >
                            удалить
                        </v-btn>

                        <v-spacer></v-spacer>


                        <v-btn
                            color="primary"
                            text
                            @click="dialog_del = false"
                        >
                            Отмена
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
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
                        {text:'Изменить/удадлить',value:'_actions'},
                    ],
                    students_: [],
                    students: [],
                    subject:'',
                    original_students: [],
                    selectedSubj:[],
                    names:[],
                    ids:[],
                    subjs:[],
                    search: '',
                    searchSubj: '',
                    valid: false,
                    ChangeDialog: false,
                    dialog_del:false,
                    //KM:{'KM1':null,'KM2':null,'KM3':null,'KM4':null},
                    KM:[null,null,null,null],
                    sub_id:'',
                    stud_id:'',
                    //selectKM4:'',
                    //selectKM3:'',
                    //selectKM2:'',
                    //selectKM1:'',
                    //selectKM:'',
                    //selectGrade:'',
                }
            },
            methods:{
                openChangeDilog(item){
                    /*this.KM.KM1=item.km1
                    this.KM.KM2=item.km2
                    this.KM.KM3=item.km3
                    this.KM.KM4=item.km4*/
                    this.KM[0] = item.km1
                    this.KM[1] = item.km2
                    this.KM[2] = item.km3
                    this.KM[3] = item.km4
                    this.sub_id=item.subject_name
                    this.stud_id=item.id
                    this.ChangeDialog=true
                    this.item=item
                    console.log(' openChangeDilog item: ',item)
                    console.log(' openChangeDilog KM: ',this.KM)
                },
                Open_dialog_del(item){
                    this.sub_id=item.subject_name
                    this.stud_id=item.id
                    this.dialog_del=true
                },
                ChangeMark(){//Функция простановки оценок
                    let data = new FormData()
                    data.append('sub_id',this.sub_id)
                    data.append('stud_id',this.stud_id)
                    //data.append('KM',this.KM)
                    for (var i = 0; i < this.KM.length; i++) {
                        data.append('KM[]', this.KM[i]);
                        console.log(this.KM[i])
                    }
                    console.log(this.sub_id)
                    console.log(this.stud_id)
                    console.log(this.KM)
                    //console.log(data.KM)
                    fetch('ChangeMark',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body:data
                    })
                   // this.ShowTableMark()
                },
                Priv_del(){
                    let data = new FormData()
                    //console.log(this.sub_id)
                    //console.log(this.stud_id)
                    data.append('sub_id',this.sub_id)
                    data.append('stud_id',this.stud_id)
                    fetch('Priv_del',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body:data
                    })
                },
                //Функция для выбора студентов в дисциплине
                FUNC(){
                    console.log('1')
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
                   // console.log(this.students_.id);
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
                    //console.log('234')
                    if(this.selectedSubj){
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
                    }

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
              //  this.showTableUsersBySubj();
            }
        })
    </script>

@endsection
