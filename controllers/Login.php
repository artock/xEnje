<?php

if(isset($_POST['login']) && isset($_POST['psword'])){

    $user = R::findOne('users', 'user = ?', [$_POST['login']]);

    if(isset($user) && !empty($user)){
        $pass = hash("sha512", $_POST['psword']);
        UTL::_signin($user, $_POST['login'], $pass);
    }else{
        UTL::_console("Неверно введен логин или пароль");
    }
}

?>
