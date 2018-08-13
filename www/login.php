<?php
    include 'db_connection.php';

    $login = $_POST['login'];
    $entrar = $_POST['entrar'];
    $senha = md5($_POST['senha']);

    $conn = openCon();
    
    if(isset($entrar)) {
        $verifica = $conn->query("SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'");
    
        if ($verifica->num_rows <= 0) {
            echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='index.html';</script>";
            die();
        } else {
            setcookie("login",$login);
            header("Location:home.php");
        }
    }

    closeCon($conn);
?>