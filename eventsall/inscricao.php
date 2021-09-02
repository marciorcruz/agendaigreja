<?php
include "../conn.php";
if(isset($_COOKIE['login']) && isset($_REQUEST["evento"])){
    $login_cookie = $_COOKIE['login'];
    $evento = $_REQUEST["evento"];

include "top.php";
?>
<table class="table table-striped">
            <thead>
            <tr>
            <th scope="col">Evento</th>
            <th scope="col">Nome</th>
            <th scope="col">Pessoas</th>
            <th scope="col">CPF</th>
            <th scope="col">Telefone</th>
            
            </tr>
            </thead>
            <tbody>
            <?php
            $sqlquery = "select inscricoes.*, eventos.data, eventos.evento from inscricoes inner join eventos on  eventos.id = inscricoes.idevento where inscricoes.idevento = '$evento' order by inscricoes.nome";
            $perguntas = mysqli_query($conexao,$sqlquery) or die("Erro");
            while($dadosr=mysqli_fetch_assoc($perguntas))
            {
            ?>
                <tr>
                    <td><?php echo $dadosr['evento'];?></td>
                    <td><?php echo $dadosr['nome'];?></td>
                    <td><?php echo $dadosr['pessoas'];?></td>
                    <td><?php echo $dadosr['cpf'];?></td>
                    <td><?php echo $dadosr['telefone'];?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
            </table>
<?php
include "bottom.php";
?>
<script>
	window.onload = function() {
		window.print();
	}
</script>
<?php
}else{
    header("Location:../eventsall/login.html");
}
?>