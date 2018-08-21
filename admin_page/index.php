<?php
    session_start();
    include_once("../function/func_login.php");

    var_dump(cekStatusLogin());
    var_dump(($_SESSION["uid"]));

    if(cekStatusLogin()){
        header("location:./home/");
    }else{
        header("location:../");
    }
?>