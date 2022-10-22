<?php
session_start();
if($_SESSION['crypt'] == null){
    $_SESSION['crypt'] = 0;
}
// $_SESSION['crypt'] == 0 - нет файла бд, первый вход в систему
// $_SESSION['crypt'] == 1 - есть файл бд, необходимо ввести ключ
// $_SESSION['crypt'] == 2 - ключ введен, бд расшифрована
include('functions.php');
if($_SESSION['crypt'] != 2){
    switch(file_exists($_SESSION['db'])){
        case 0:
            //если нет файла бд
        $_SESSION['crypt'] = 0;
        //file_put_contents('db.txt', 'admin::0:0');
        header("Location: crypt.php");
        break;
        case 1:
            //если есть файл бд
        $_SESSION['crypt'] = 1;
        break;
    }
}

switch($_SESSION['sign']){
    case 0:
        //если вход не выполнен
        switch($_SESSION['crypt']){
            case 1:
                //если бд не расшифрована
                header("Location: crypt.php");
                break;
           case 2:
               break;
        }
        break;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign in</title>

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
    echo sign();
    echo footer();
?>
<div class="clearfix"></div>
</div>
</body>
</html>
