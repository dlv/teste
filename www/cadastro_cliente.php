<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Cliente</title>
        <?php 
            include 'validacao.php';
        ?>
    </head>
    <body>
        <fieldset id="fdLogin">
            <legend>Cadastro de Cliente</legend><br />
            <form action="/clientes.php" id="formcliente" name="formcliente" method="POST" >
                <div>
                    <input type="hidden" id="idcliente" name="idcliente" value="0">
                    <label>Nome : </label><input type="text" name="nome" id="nome"  /><br/><br/>
                    <label>Data Nascimento : </label><input type="text" name="dt_nasc" id="dt_nasc" maxlength="10" /><br /><br/>
                    <label>CPF : </label><input type="text" name="cpf" id="cpf" maxlength="14" /><br /><br/>
                    <label>RG : </label><input type="text" name="rg" id="rg" maxlength="12" /><br /><br/>
                    <label>Telefone : </label><input type="text" name="telefone" id="telefone" maxlength="15" /><br /><br/>
                    <table id="tblEmail" name="tblEmail">
                        <tr>
                            <td>Email: </td>
                            <td><input type='text' name='email_1' size='40' maxlength='' /></td>
                        </tr>
                    </table>
                    <input type="hidden" id="qtdEmail" name="qtdEmail" value="1">
                    <br/><br/>
                </div>
            </form>
            <input type="hidden" name="email" id="email" /><a><button onclick="addEmail()">Adicionar Email</button></a><br/><br/>
            <button type="submit" form="formcliente" id="btnCliente" name="btnCliente" value="Cadastrar">Cadastrar </button>
        </fieldset>
        
        <script>
            function addEmail() {
                var table = document.getElementById("tblEmail");
                var row = table.insertRow(0);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);

                cell1.innerHTML = "Email: ";
                cell2.innerHTML = "<input type='text' name='email_"+table.rows.length+"' size='40' maxlength='' />";
                document.getElementById("qtdEmail").value = table.rows.length;
            }
        </script>
    </body>
</html>