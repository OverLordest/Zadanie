@extends('shapka')
@section('title')
    Студенты
@endsection
@section('main_content')
    <!--Добавление студентов-->
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
  <!-- <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">-->
        <!--Форма для добавления студентов-->
       <!--  <form method="post" action="/students/check" >
            @csrf
            <input type="student_name" name="student" id="student" placeholder="введите имя студента" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>-->
    <!--Вывод-->

    <!--  <table border = "1">
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
    </table>-->
    <div class="flex-center position-ref full-height" id="MainVue">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                <h3>Введите имя студента для добавления::</h3>
                <v-text-field
                    v-model="FIO"
                    label="ФИО студента"
                >
                </v-text-field>
                <v-btn
                    @click="sendName">
                    Добавить
                </v-btn>
                <br>
                <br>
                <h3>Студенты:</h3>
                <v-data-table
                    v-model="selected"
                    :headers="headers"
                    :items="users"
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

                        <v-btn
                            @click="deleteByName">
                            Удалить по выбраному
                        </v-btn>
                    </template>
                </v-data-table>
                </v-form>
            </v-main>
        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
        var r = new Vue({
            el: '#MainVue',
            vuetify: new Vuetify(),
            data(){
                return({
                    FIO:'',
                    nameID: 'ID студента',
                    vis: true,
                    users: [],
                    search: '',
                    selected: [],
                    headers: [
                        {
                            align: 'start',
                            sortable: false,
                        },
                        { text: 'ID', value: 'id' },
                        { text: 'ФИО', value: 'student_name' },
                    ],
                })},

            methods:{
                sendName(){
                    let data = new FormData()
                    data.append('FIO',this.FIO)
                    fetch('sendName',{
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
                            this.users = data.users
                            //console.log(data.users)
                        })
                },
                deleteByName(){
                    let data = new FormData()
                    let result = this.selected.map(({ id }) => id);
                    nameID = result[0]
                    data.append('deleteID',nameID)
                    //this.vis = (this.vis == true) ? false : true
                    fetch('deleteName',{
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
                            this.users = data.users
                            //console.log(data.users)
                        })

                },
            },
            mounted: function (){
                console.log("SCP")
                fetch('showTable',{
                    method:'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                })
                    .then((response)=>{
                        return response.json()
                    })
                    .then((data)=>{
                        this.users = data.users
                        //console.log(data.users)
                    })
            }

        })
    </script>
@endsection
