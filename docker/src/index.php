<?php
exec('rm /tmp/php*');
include "init.php";
if(!isset($_COOKIE['ser_data'])){
    setcookie('ser_data',base64_encode(serialize('guest')));
    header('Location: /', true, 302);;
}
else {
    $name=unserialize(base64_decode($_COOKIE['ser_data']));
    if(!is_string($name)||!ctype_alnum($name)){
        $name='guest';
    }
    if(isset($_POST['num1'])&&isset($_POST['num2'])){
        $num1=$_POST['num1'];
        $num2=$_POST['num2'];
        if(is_numeric($num1)&&is_numeric($num2)){
            $res=gmp_strval(gmp_add($num1,$num2));
        }
        else{
            $res="correct_input_is_needed";
        }
    }
    else{
        $res="input_is_needed";
    }
    $template->name=$name;
    $template->res=$res;
    $template->display();
}