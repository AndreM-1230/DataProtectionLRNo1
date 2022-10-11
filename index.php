<?php
session_start();
include('functions.php');
if($_SESSION['sign'] == null){
    $_SESSION['sign'] = 0;
    $_SESSION['login'] = '';
    $_SESSION['pass'] = '';
    $_SESSION['chpass'] = 0;
}

$_SESSION['corr'] = 1;
//$user_login[0] - login
//$user_login[1] - password
//$user_login[2] - condition password
//$user_login[3] - user blocked
//$_SESSION['condition'] = 0 - нет условия пароля
//$_SESSION['condition'] = 1 - есть условие пароля
//$_SESSION['corr'] = 0 - введен некорректный пароль
//$_SESSION['corr'] = 1 - учетка доступна
//$_SESSION['corr'] = 2 - учетка заблокирована
//$_SESSION['chpass'] = 0 - не нужна смена пароля
//$_SESSION['chpass'] = 1 - нужна смена пароля
//25. Чередование цифр, знаков арифметических операций и снова цифр.
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Защита информации</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script src="./js/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
        });
    </script>
</head>
<body>
<?php
echo start();
?>
    <div class="container">
    <footer style="padding-top: 60px;" class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">2022</p>
        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="https://github.com/AndreM-1230/Data_Protection_LRNo1" class="nav-link px-2 text-muted">GitHub</a></li>
        </ul>
    </footer>
</div>
    <div class="clearfix"></div>
</div>
</body>
</html>
