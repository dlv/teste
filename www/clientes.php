<?php
    include 'db_connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];
     
        switch($action) {
            case 'excluir':
                excluir($_POST['cliente']);
                break;
            default:       
                salvar();
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'];

        switch($action) {
            case 'editar':
                editar($_GET['cliente']);
                break;
        }
    }

    function getClientes() {
        $conn = openCon();
        $query_select = "SELECT id,nome,telefone FROM clientes limit 100;";

        $clientes = $conn->query($query_select);
        closeCon($conn);

        return $clientes;
    }

    function salvar() {
        $nome = $_POST['nome'];
        $email = $_POST['email_1'];
        $validacao = array();

        if($nome == "" || $nome == null) {
            array_push($validacao,"Nome");
        }

        if($email == "" || $email == null){
            array_push($validacao,"Email");
        }

        if (count($validacao) > 0) {
            echo "<script language='javascript' type='text/javascript'>alert('O(s) campo(s) ". implode(", ",$validacao)." deve ser preenchido.');window.location.href='cadastro_cliente.html';</script>";
        }

        gravar();
    }

    function gravar() {
        date_default_timezone_set('UTC');
        $id = $_POST['idcliente'];
        $nome = $_POST['nome'];
        // $dt_nasc = date("Y-m-d",strtotime($_POST['dt_nasc']));
        $dt_nasc = date("Y-m-d",strtotime(str_replace('/','-',$_POST['dt_nasc'])));
        $cpf = $_POST['cpf'];
        $rg = $_POST['rg'];
        $telefone = $_POST['telefone'];
        $emails = array();

        if ($id > 0) {
            $query_cliente = "UPDATE clientes SET nome = '$nome', data_nascimento = '$dt_nasc', CPF = '$cpf', RG = '$rg', telefone = '$telefone' WHERE id = $id;";
        } else {
            $query_cliente = "INSERT INTO clientes (nome,data_nascimento,CPF,RG,telefone) VALUES ('$nome','$dt_nasc','$cpf','$rg','$telefone');";
        }

        $conn = openCon();

        if ($conn->query($query_cliente) === TRUE) {
            $cliente_id = 0;
            if ($id > 0) {
                $cliente_id = $id;
            } else {
                $cliente_id = $conn->insert_id;
            }

            $count = (int) $_POST['qtdEmail'];
            $query_cliente_email = "DELETE FROM email_cliente WHERE idcliente = $cliente_id;";
            $conn->query($query_cliente_email);

            foreach($_POST as $key => $value) {
                if ("email_".$count == $key) {
                    $query_cliente_email = "INSERT INTO email_cliente (email,idcliente) VALUES ('$value','$cliente_id');";

                    if ($conn->query($query_cliente_email) === FALSE) {
                        if ($id > 0) {
                            echo "<script language='javascript' type='text/javascript'>alert('Não foi possível atualizar esse cliente');window.location.href='cadastro_cliente.html'</script>";
                        } else {
                            echo "<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse cliente');window.location.href='cadastro_cliente.html'</script>";
                        }
                    }
                    $count--;
                }
            }

            if ($id > 0)
                echo "<script language='javascript' type='text/javascript'>alert('Cliente atualizado com sucesso!');window.location.href='home.php'</script>";
            else
                echo "<script language='javascript' type='text/javascript'>alert('Cliente cadastrado com sucesso!');window.location.href='home.php'</script>";
        } else {
            if ($id > 0)
                echo "<script language='javascript' type='text/javascript'>alert('Não foi possível atualizar esse cliente');window.location.href='cadastro_cliente.html'</script>";
            else
                echo "<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse cliente');window.location.href='cadastro_cliente.html'</script>";
        }

        closeCon($conn);
    }

    function excluir($idcliente) {
        $query = "DELETE FROM clientes WHERE id = $idcliente";
        $conn = openCon();
        if ($conn->query($query) === TRUE) {
            echo "Cliente ".$idcliente." excluido com sucesso!";;
        } else {
            echo "Não foi possível excluir o Cliente ".$idcliente."! ". $conn->error;
        }
        closeCon($conn);        
    }

    function editar($idcliente) {
        $conn = openCon();
        $query = "SELECT c.id, c.nome, DATE_FORMAT(c.data_nascimento, '%d/%m/%Y') as data_nascimento, c.CPF, c.RG, c.telefone, GROUP_CONCAT(ec.email SEPARATOR ',') AS email"
                ." FROM clientes AS c "
                . " JOIN email_cliente AS ec ON ec.idcliente = c.id "
                . " WHERE c.id = $idcliente;";

        $cliente = $conn->query($query);
        $ret;
        $qtdEmail = $cliente->num_rows;
        
        foreach($cliente as $cli){
            $ret = $cli;
        }
        closeCon($conn);
        echo implode('~',$ret) . "~$qtdEmail";        
    }
?>