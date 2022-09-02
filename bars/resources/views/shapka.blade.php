<!doctype html>
<!--Шапка и основной блок для всех страниц-->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body class="bg-dark text-white">
<!--Шапка-->
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img class="bi me-2" width="40" height="32" role="png" aria-label="B" src="http://nachalo4ka.ru/wp-content/uploads/2014/06/B-v-starorusskom-stile.png">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-left mb-md-0">
            <li><a href="http://bars" class="nav-link px-2 link-secondary">На главную</a></li>
            <li><a href="http://bars/students" class="nav-link px-2 link-secondary">Студены</a></li>
            <li><a href="http://bars/subjects" class="nav-link px-2 link-secondary">Предметы</a></li>
            <li><a href="http://bars/mark" class="nav-link px-2 link-secondary">Привязка предметов и оценки</a></li>
            <li><a href="http://bars/sub" class="nav-link px-2 link-secondary">Поиск по предметам</a></li>
        </ul>

        <div class=" text-end">
            <button type="button" class="btn btn-outline-primary me-2" onclick="window.location.href = 'http://bars/login';">Вход</button>
            <button type="button" class="btn btn-primary" onclick="window.location.href = 'http://bars/register';">Регистрация</button>
        </div>
    </header>
</div>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@yield('main_content')
</body>
</html>
