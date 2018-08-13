<?php
    include 'db_connection.php';

    $login = $_POST['login'];
    $senha = MD5($_POST['senha']);

    $conn = openCon();
    $query_select = "SELECT login FROM usuarios WHERE login like ('$login');";

    $select = $conn->query($query_select);
    $array = $select->fetch_assoc();
    $logarray = $array['login'];
 
    if($login == "" || $login == null){
        echo"<script language='javascript' type='text/javascript'>alert('O campo login deve ser preenchido');window.location.href='cadastro_usuario.html';</script>";
    } else {
      if($logarray == $login){
         echo"<script language='javascript' type='text/javascript'>alert('Esse login já existe');window.location.href='cadastro_usuario.html';</script>";
         die();
        } else {
            $query = "INSERT INTO usuarios (login,senha) VALUES ('$login','$senha');";

            if ($conn->query($query) === TRUE) {
                echo"<script language='javascript' type='text/javascript'>alert('Usuário cadastrado com sucesso!');window.location.href='index.html'</script>";
            } else {
                echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse usuário');window.location.href='cadastro_usuario.html'</script>";
            }
        }
    }

    closeCon($conn);
?>