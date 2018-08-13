<?php
    $logado = $_COOKIE['login'];
    
    if(!isset($logado)){
        echo"<script language='javascript' type='text/javascript'>alert('Por Favor, realize o login no sistema.');window.location.href='index.html';</script>";
        die();
    }
    $logado = ucfirst($logado);
?>