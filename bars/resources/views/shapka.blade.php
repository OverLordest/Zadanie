<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>
<body class="bg-dark text-white">

<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img class="bi me-2" width="40" height="32" role="png" aria-label="B" src="http://nachalo4ka.ru/wp-content/uploads/2014/06/B-v-starorusskom-stile.png">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="http://127.0.0.1:8000/" class="nav-link px-2 link-secondary">На главную</a></li>
            <li><a href="http://127.0.0.1:8000/students" class="nav-link px-2 link-secondary">Студены</a></li>
            <li><a href="http://127.0.0.1:8000/subjects" class="nav-link px-2 link-secondary">Предметы</a></li>
            <li><a href="http://127.0.0.1:8000/mark" class="nav-link px-2 link-secondary">Привязка предметов и оценки</a></li>
            <li><a href="http://127.0.0.1:8000/sub" class="nav-link px-2 link-secondary">Поиск по предметам</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-outline-primary me-2" onclick="window.location.href = 'http://127.0.0.1:8000/login';">Вход</button>
            <button type="button" class="btn btn-primary" onclick="window.location.href = 'http://127.0.0.1:8000/register';">Регистрация</button>
        </div>
    </header>
</div>
@yield('main_content')
</body>
</html>
