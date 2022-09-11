@extends('shapka')
@section('title')
    Дисциплины
@endsection
@section('main_content')
    <!--Добавление дисциплин-->

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
 <!--   <div class="paded nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <form method="post" action="/subject/check" >
            @csrf
            <input type="subject_name" name="subject" id="subject" placeholder="введите название дисциплины" class="form-control" style="width: 400px; padding-left: 10px;" ><br>
            <button type="submit" class="btn btn-success">Принять</button><br>
        </form>
    </div>-->
    <!--Вывод-->
   <!-- <h1>Все дисциплины:</h1>
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
    </table>-->
    <div class="flex-center position-ref full-height" id="MainVue">
        <v-app>
            <v-main>
                <v-form v-model="valid">
                    <h3>Введите название дисциплины для добавления::</h3>
                    <v-text-field
                        v-model="Subject"
                        label="название предмета"
                    >
                    </v-text-field>
                    <v-btn
                        @click="sendSubject">
                        Добавить
                    </v-btn>
                    <br>
                    <br>
                    <h3>Предметы:</h3>
                    <v-data-table
                        v-model="selected"
                        :headers="headers"
                        :items="subj"
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
                                @click="deleteBySubject">
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
                    Subject:'',
                    subjectID: 'ID предмета',
                    vis: true,
                    subj: [],
                    search: '',
                    selected: [],
                    headers: [
                        {
                            align: 'start',
                            sortable: false,
                        },
                        { text: 'ID', value: 'id' },
                        { text: 'Предмет:', value: 'subject_name' },
                    ],
                })},

            methods:{
                sendSubject(){
                    let data = new FormData()
                    data.append('Subject',this.Subject)
                    fetch('sendSubject',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body:data
                    })
                    fetch('showTableSub',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    })
                        .then((response)=>{
                            return response.json()
                        })
                        .then((data)=>{
                            this.subj = data.subj
                        })
                },
                deleteBySubject(){
                    let data = new FormData()
                    let result = this.selected.map(({ id }) => id);
                    subjectID = result[0]
                    data.append('deleteID',subjectID)
                    fetch('deleteSubject',{
                        method:'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        body:data
                    })
                    fetch('showTableSub',{
                        method:'post',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    })
                        .then((response)=>{
                            return response.json()
                        })
                        .then((data)=>{
                            this.subj = data.subj
                            //console.log(data.users)
                        })

                },
            },
            mounted: function (){
                console.log("SCP")
                fetch('showTableSub',{
                    method:'post',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                })
                    .then((response)=>{
                        return response.json()
                    })
                    .then((data)=>{
                        this.subj = data.subj
                        console.log(data.subj)
                    })
            }

        })
    </script>
@endsection
