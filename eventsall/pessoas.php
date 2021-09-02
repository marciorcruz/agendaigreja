<?php
include "../conn.php";
if(isset($_COOKIE['login'])){
    $login_cookie = $_COOKIE['login'];
    if(isset($_POST['DELETAR'])){
        $id = $_POST['inscricao'];
        $update = "DELETE FROM inscricoes WHERE id=" .  $id ;
        if (mysqli_query($conexao, $update)) {
            header("Location:pessoas.php");
        } 
    }
}else{
    header("Location:../eventsall/login.html");
}
include "top.php";
?>
<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
    <div class="container">

    <form class="form-inline my-2 my-lg-0" method="POST" action="pessoas.php">
      <select class="form-control" id="eventodata" name="eventodata" required>
        <option value="">TODAS AS INSCRIÇÕES</option>
        <?php
        $queryadd = " ";
        $eventodata = "";
        if(isset($_POST["eventodata"])){
            $eventodata = $_POST["eventodata"];
            $queryadd = " AND eventos.id = '$eventodata' ";
        }

        $search = "";
           
        if(isset($_POST["search"])){
            $search = $_POST["search"];
        }

        $sql = mysqli_query($conexao,"select * from eventos order by data desc") or die("Erro");
        while($dados=mysqli_fetch_assoc($sql))
        {
            
        $selected = "";
        if ($eventodata == $dados['id']){
        $selected = "selected";
        }
        echo '<option value="'.$dados['id'].'" ' . $selected . '>'.$dados['evento'].'</option>';
        }
        ?>
        </select>
      <input class="form-control mr-sm-2" type="search" id="search" name="search" placeholder="Search" aria-label="Search" value="<?php echo $search;?>">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">PROCURAR</button>
    </form>


    <?php
        if(isset($login_cookie)){
        ?>
            <table class="table table-striped">
            <thead>
            <tr>
            <th scope="col">Evento</th>
            <th scope="col">Nome</th>
            <th scope="col">Pessoas</th>
            <th scope="col">CPF</th>
            <th scope="col">Telefone</th>
            <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total_reg = "50";

            $pagina="1";
            $pc = "1";
            if(isset($_GET['pagina'])){
                $pagina=$_GET['pagina'];
                if (!$pagina) {
                    $pc = "1";
                } else {
                    $pc = $pagina;
                }
            }
            

            $inicio = $pc - 1;
            $inicio = $inicio * $total_reg;

            $busca = "select inscricoes.*, eventos.data, eventos.evento from inscricoes inner join eventos on eventos.id = inscricoes.idevento WHERE (eventos.evento like '%$search%' OR inscricoes.nome like '%$search%') $queryadd order by inscricoes.nome, eventos.data desc";

            $perguntas = mysqli_query($conexao, "$busca LIMIT $inicio,$total_reg");
            $todos = mysqli_query($conexao,"$busca");
            
            $tr = mysqli_num_rows($todos); // verifica o número total de registros
            $tp = $tr / $total_reg; // verifica o número total de páginas

            while($dadosr=mysqli_fetch_assoc($perguntas))
            {
            ?>
                <tr>
                    <td><?php echo $dadosr['evento'];?></td>
                    <td><?php echo $dadosr['nome'];?></td>
                    <td><?php echo $dadosr['pessoas'];?></td>
                    <td><?php echo $dadosr['cpf'];?></td>
                    <td><?php echo $dadosr['telefone'];?></td>
                    <td>
                    <form class="form-inline" method="POST" action="pessoas.php">
                    <input type="hidden" name="inscricao" id="inscricao" value="<?php echo $dadosr['id'];?>">
                    <input type="submit" class="btn btn-danger"  value="DELETAR" id="DELETAR" name="DELETAR"><br>
                    </form> 
                    </td>
                </tr>
            <?php
            }
            ?>
                <tr>
                    <td colspan="6">
                    <?php
                    // agora vamos criar os botões "Anterior e próximo"
                    $anterior = $pc -1;
                    $proximo = $pc +1;
                    if ($pc>1) {
                    echo " <a href='?pagina=$anterior'><- Anterior</a> ";
                    }
                    echo " &bull; ";
                    if ($pc<$tp) {
                    echo " <a href='?pagina=$proximo'>Próxima -></a>";
                    }
                    ?>
                    </td>
                </tr>
            </tbody>
            </table>

        <?php
        }
        ?>
    </div>
</main>
 <?php
 include "bottom.php";
 ?>