<?php

    function start(){
        $return='';
        $return.="<div class='navbar navbar-expand-lg navbar-default bg-dark text-white'>
    <!--    navbar-fixed-top-->
    <div class='container'>
        <div class='navbar-header col-lg-7'>
            <a href='index.php' class='text-white' style='text-decoration: none;'><h1>Защита информации ЛР№1</h1></a>
        </div>
        <div class='navbar-header col-lg-3'>";
        if($_SESSION['sign']==0) {
            $return .= "<h2>Вход не выполнен</h2>";
        }
        else{
            $return .= "<h2>Привет, $_SESSION[login]!</h2>";
        }
        $return.="</div>
        <div class='navbar-header'>";
        if($_SESSION['sign']==0) {
            $return .= "<form action='sign.php'>
                <button type='submit' class='btn btn-primary btn-lg'>Sign in</button>
            </form>";
        }
        else{
            $return .= "<form action='signout.php'>
                <button type='submit' class='btn btn-primary btn-lg'>Sign out</button>
            </form>";
        }
        $return .= "</div>
                </div>
            </div>
            <div class='container'>
                <div class='page-header' id='banner'>
                    <div class='row'>
                        <div class='col-lg-12'>";
        switch ($_SESSION['sign']) {
            case 0:
                $return .= "<h1>лр1</h1>";
                break;
            case 1:
                $return.="<form action='sign.php'>
                    <button type='submit' class='btn btn-primary btn-lg'>Сменить пароль</button>
                    </form>";
                $return .= users();

            break;

        }
        $return .= "</div>
                    </div>
        </div>";
        return $return;
    }

    function sign(){
        $return='';
        $return.="<div class='navbar navbar-expand-lg navbar-default bg-dark text-white'>
    <!--    navbar-fixed-top-->
    <div class='container'>
        <div class='navbar-header col-lg-7'>";
        if($_SESSION['chpass'] == 0){
            $return.="<a href='index.php' class='text-white' style='text-decoration: none;'><h1>Защита информации ЛР№1</h1></a>";
        }
        else{
            $return.="<a href='' class='text-white' style='text-decoration: none;'><h1>Защита информации ЛР№1</h1></a>";
        }

        $return.="</div>
        <div class='navbar-header col-lg-3'>";
        switch ($_SESSION['sign']){
            case 0:
                if($_SESSION['chpass'] == 1){
                    $return.="<h2>Смена пароля</h2>";
                }else{
                    $return.="<h2>Вход в систему</h2>";
                }

                break;
            case 1:
                $return.="<h2>Смена пароля</h2>";
                break;
        }
        $return.="</div>
                    <div class='navbar-header'>
                    <button type='submit' class='btn btn-primary btn-lg' disabled>Sign in</button></div>
                </div>
            </div>
            <div class='container'>
                <div class='page-header' id='banner'>
                    <div class='row'>
                        <div class='col-lg-12'>";
        switch ($_SESSION['sign']){
            case 0:
                if($_SESSION['chpass'] == 1){
                    $return.="<h2>Смена пароля</h2>";
                }else{
                    $return.="<h2>Вход в систему</h2>";
                }

                break;
            case 1:
                $return.="<h2>Смена пароля (при успешной смене произойдет выход из системы)</h2>";
                break;
        }
        $return.="</div>
                    </div>
                </div>
            <div class='container'>";
        if ($_SESSION['corr'] == 0 and $_SESSION['chpass'] == 0){
            $return.="<h1>Некорректный логин или пароль, попробуй ещё раз!</h1>";
        }
        if ($_SESSION['corr'] == 2){
            $return.="<h1>Учетная запись заблокирована, обратись к админу!</h1>";
        }
        if($_SESSION['sign'] == 0 and $_SESSION['chpass'] == 0) {
            $return .= sign_in();
        }
        elseif($_SESSION['sign'] == 1){
            $return.= change_pass();
        }
        elseif($_SESSION['chpass'] == 1 and $_SESSION['sign'] == 0){
            switch ($_SESSION['condition']){
                case 0:
                    $return.="<h1>Необходимо сменить, или установить пароль!</h1>";
                    break;
                case 1:
                    $return.="<h1>Необходимо сменить, или установить пароль!<br>
                    Чередование цифр, знаков арифметических операций и снова цифр</h1>";
                    break;
            }

            $return.= change_pass();
        }
        $return.="</div>";
        return $return;
    }

    function sign_in() {
        $return='';
        $return.="<form action='./checksign.php' id='sign' method='post'></form>
            <input type='text' class='form-control'
                placeholder='Username' 
                form='sign' 
                aria-label='Username' 
                name='login' required/>
            <span class='input-group-text'></span>
            <input type='password' class='form-control' 
                placeholder='Password' 
                form='sign' 
                aria-label='Password' 
                name='pass' />
            <input class='btn btn-primary' type='submit' value='войти' form='sign' name='sign'/>";
        return $return;
    }

    function change_pass(){
        $return='';
        $return.="<form action='./checksign.php' id='sign' method='post'></form>
            <input type='password' class='form-control' 
                placeholder='Old Password' 
                form='sign' 
                aria-label='Old Password' 
                name='oldpass'/>
            <span class='input-group-text'></span>";
        if($_SESSION['chpass'] == 1){
            $return.="<input type='password' class='form-control' 
                placeholder='New Password' 
                form='sign' 
                aria-label='New Password' 
                name='pass' title='0-9 +-*/% 0-9' required />";
        }else{
            $return.="<input type='password' class='form-control' 
                placeholder='New Password' 
                form='sign' 
                aria-label='New Password' 
                name='pass' required />";
        }

        $return.="<input class='btn btn-primary' type='submit' value='Подтвердить' form='sign' name='sign'/>";
        return $return;
    }

    function users(){
        $return='';
        $return .= "<h1>Пользователи:</h1>";
        $db = file_get_contents("db.txt");
        $_SESSION['db_info']=explode("\n",$db);
        $users_count = count($_SESSION['db_info']);
        $return .="<table class='table table-striped text-center'>
                    <tbody>
                    <tr>
                        <td>Логин:</td>";
        if($_SESSION['login'] == 'admin') {
            $return .="<td> Условие пароля: </td>
                    <td>Доступ к учетке:</td>
                    <td></td>
                </tr>
                <tr>
                    <form action='./adduser.php' id='adduser' method='post'></form>
                    <td>
                    <input type='text' class='form-control'
                    placeholder='Login' 
                    form='adduser' 
                    aria-label='Username' 
                    name='login' required/>
                    </td><td>
                        <select class='form-select-sm' form='adduser' name='condition'>
                            <option value='0'>нет</option>
                            <option value='1'>да</option> 
                        </select>
                    </td>
                    <td></td>
                    <td>
                        <input class='btn btn-primary w-100' 
                        type='submit' value='Добавить' 
                        form='adduser' 
                        name='adduser'/>
                    </td>";
        }
        $return .="</tr>";
        foreach ($_SESSION['db_info'] as $value){
            $user_login=explode(":",$value);
            $block = '';
            $unblock = '';
            $drop = '';
            $checkcondpass = '';
            $block .= "block" . $user_login[0];
            $unblock .= "unblock" . $user_login[0];
            $drop .= "drop" . $user_login[0];
            $checkcondpass .= "checkcondpass" . $user_login[0];
            $return .="<tr>
                <form action='./edit.php' id='edit' method='post'></form>
                    <form action='./block.php' id='$block' method='post'></form>
                    <form action='./unblock.php' id='$unblock' method='post'></form>
                    <form action='./droppassword.php' id='$drop' method='post'></form>
                    <form action='./checkcondpass.php' id='$checkcondpass' method='post'></form>
                    <td> $user_login[0] </td>";
            if($_SESSION['login'] == 'admin'){
//condition password
                $return .="<td>
                            ";
                if($user_login[2] == 1){
                    $return .="<input class='btn btn-light' type='submit' value='да' form='$checkcondpass' name='condition'/>";
                }
                else{
                    $return .="<input class='btn btn-light' type='submit' value='нет' form='$checkcondpass' name='condition'/>";
                }

                $return .="<input class='btn' value='$user_login[0]' form='$checkcondpass' name='login' hidden/></td>";
//user blocked
                $return .="<td>";
                if($user_login[3] == 1 and $user_login[0] != 'admin'){$return .="заблокирован</td><td>
                    <div class='btn-group w-100' role='group'>
                    <input class='btn btn-danger w-100' 
                    type='submit' value='Разблочить' 
                    form='$unblock' 
                    name='unblock'/>
                    <input class='btn' value='$user_login[0]' form='$unblock' name='login' hidden/>
                    <input class='btn btn-primary w-100' 
                    type='submit' value='Сбросить' 
                    form='$drop' 
                    name='drop'/>
                    <input class='btn' value='$user_login[0]' form='$drop' name='login' hidden/></div></td>";}
                elseif($user_login[3] == 0 and $user_login[0] != 'admin'){$return .="доступен</td><td>
                       <div class='btn-group w-100' role='group'>
                    <input class='btn btn-success w-100' 
                    type='submit' value='Забанить' 
                    form='$block' 
                    name='block'/>
                    <input class='btn' value='$user_login[0]' form='$block' name='login' hidden/>
                    <input class='btn btn-primary w-100' 
                    type='submit' value='Сбросить' 
                    form='$drop' 
                    name='drop'/>
                    <input class='btn' value='$user_login[0]' form='$drop' name='login' hidden/></div></td>";}
                else{
                    $return .="</td><td>
                    <input class='btn btn-dark w-100' 
                    type='submit' value=''
                    name='sign' disabled/></td>";
                }
                //$return .="</td><td></td>";
            }
            $return .="</tr>";
        }
        $return .="</tbody>
            </table>";
        return $return;
    }