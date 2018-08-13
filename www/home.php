
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php 
            include 'validacao.php';
            include 'clientes.php';
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>SISTEMA WEB</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <style>
            body {font-family: Arial;}

            /* Style the tab */
            .tab {
                overflow: hidden;
                border: 1px solid #ccc;
                background-color: #f1f1f1;
            }

            /* Style the buttons inside the tab */
            .tab button {
                background-color: inherit;
                float: left;
                border: none;
                outline: none;
                cursor: pointer;
                padding: 14px 16px;
                transition: 0.3s;
                font-size: 17px;
            }

            /* Change background color of buttons on hover */
            .tab button:hover {
                background-color: #ddd;
            }

            /* Create an active/current tablink class */
            .tab button.active {
                background-color: #ccc;
            }

            /* Style the tab content */
            .tabcontent {
                display: none;
                padding: 6px 12px;
                border: 1px solid #ccc;
                border-top: none;
            }

            table {
                border-collapse: collapse;
                border-spacing: 0;
                width: 100%;
                border: 1px solid #ddd;
            }

            th, td {
                text-align: left;
                padding: 16px;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2
            }

            .btn-group button {
                background-color: #4CAF50; /* Green background */
                border: 1px solid green; /* Green border */
                color: white; /* White text */
                padding: 10px 24px; /* Some padding */
                cursor: pointer; /* Pointer/hand icon */
                float: left; /* Float the buttons side by side */
            }

            /* Clear floats (clearfix hack) */
            .btn-group:after {
                content: "";
                clear: both;
                display: table;
            }

            .btn-group button:not(:last-child) {
                border-right: none; /* Prevent double borders */
            }

            /* Add a background color on hover */
            .btn-group button:hover {
                background-color: #3e8e41;
            }

            .btn {
                background-color: DodgerBlue;
                border: none;
                color: white;
                padding: 12px 16px;
                font-size: 16px;
                cursor: pointer;
            }
        </style>
    </head>
 
    <body>
        <div class="tab">
            <button class="tablinks" onclick="openPage(event, 'Clientes')">Clientes</button>
            <button class="tablinks" onclick="openPage(event, 'Produtos')">Produtos</button>
        </div>

        <div id="Clientes" class="tabcontent">
            <div class="btn-group">
                <a href="cadastro_cliente.php">
                    <button>Cadastar</button>
                </a>
            </div>
            <?php $clientes = getClientes(); ?>
            <table name="tblClientes">
                <tr>
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                </tr>
                <?php foreach($clientes as $cliente) { ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo $cliente['nome']; ?></td>
                    <td><?php echo $cliente['telefone']; ?></td>
                    <td>
                        <button class="btn" name="btn_edit" id="<?php echo $cliente['id']; ?>" onclick="editar(this.id)">
                            <i class="fa fa-edit"></i>
                        </button> 
                        <button class="btn" name="btn_delete" id="<?php echo $cliente['id']; ?>" onclick="excluir(this.id)">
                            <i class="fa fa-trash"/></i>
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        
        <div id="Produtos" class="tabcontent">
            <h3>Produtos</h3>
            <p>Informações.</p>
        </div>

        <script>
            function openPage(evt, page) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(page).style.display = "block";
                evt.currentTarget.className += " active";
            }

            function editar(idcliente) {
                jQuery.ajax({
                    type: "GET",
                    url: 'clientes.php',
                    data: {action: 'editar', cliente: idcliente}, 
                    success:function(data) {
                        var result = data.split('~');
                        var page;
                        page = window.open();
                        // a.parent;
                        page.location.href="cadastro_cliente.php";
                        
                        $(page).ready(function() {
                            page.document.getElementById("idcliente").value = result[0];
                            page.document.getElementById("nome").value = result[1];
                            // page.document.getElementById("nome").innerHTML = result[1];
                            page.document.getElementById("dt_nasc").value = result[2];
                            // page.document.getElementById("dt_nasc").innerHTML = result[2];
                            page.document.getElementById("cpf").value = result[3];
                            // page.document.getElementById("cpf").innerHTML = result[3];
                            page.document.getElementById("rg").value = result[4];
                            // page.document.getElementById("rg").innerHTML = result[4];
                            page.document.getElementById("telefone").value = result[5];
                            // page.document.getElementById("telefone").innerHTML = result[5];

                            var emails = result[6].split(',');
                            var table = page.document.getElementById("tblEmail");
                            var cells = table.rows[0].cells;
                           
                            var qtdEmail = result[result.length - 1];
                            var i;
                            for (i = 0; i < emails.length; i++) {
                                if (i == 0) {
                                    cells[1].innerHTML = "<input type='text' name='email_"+(i + 1)+"' size='40' maxlength='' value='"+emails[i]+"' />"
                                }

                                if (i > 0) {
                                    var row = table.insertRow(0);
                                    var cell1 = row.insertCell(0);
                                    var cell2 = row.insertCell(1);
                                    
                                    cell1.innerHTML = "Email: ";
                                    cell2.innerHTML = "<input type='text' name='email_"+ (i + 1) +"' size='40' maxlength='' value='"+emails[i]+"' />";
                                }
                            }

                            page.document.getElementById("btnCliente").value = "Atualizar";
                            page.document.getElementById("btnCliente").innerHTML = "Atualizar";
                        });
                    }
                });
            }

            function excluir(idcliente) {
                jQuery.ajax({
                    type: "POST",
                    url: 'clientes.php',
                    data: {action: 'excluir', cliente: idcliente}, 
                    success:function(data) {
                        alert(data);
                        window.location.href='home.php';
                    }
                });
            }
        </script>
    </body>
</html>
