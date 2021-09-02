<?php
include "../conn.php";
if(isset($_COOKIE['login'])){
    $login_cookie = $_COOKIE['login'];
    if(isset($_POST['INICIAR'])){
        $id = $_POST['evento'];
        $update = "UPDATE eventos SET status = 1 where id=" .  $id ;
        if (mysqli_query($conexao, $update)) {
            header("Location:index.php");
        } 
    }
    if(isset($_POST['FECHAR'])){
        $id = $_POST['evento'];
        $update = "UPDATE eventos SET status = 0 where id=" .  $id ;
        if (mysqli_query($conexao, $update)) {
            header("Location:index.php");
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
    <?php
        if(isset($login_cookie)){
        ?>
            <table class="table table-striped">
            <thead>
            <tr>
            <th scope="col">Eventos</th>
            <th scope="col">Inscritos</th>
            <th scope="col">Limite</th>
            <th scope="col"></th>
            <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $perguntas = mysqli_query($conexao,"select *, (SELECT SUM(pessoas) FROM inscricoes WHERE inscricoes.idevento = eventos.id) as countinsc from eventos order by eventos.data, eventos.evento") or die("Erro");
            while($dadosr=mysqli_fetch_assoc($perguntas))
            {
            ?>
                <tr>
                    <td><b><?php echo $dadosr['evento'];?></b></td>
                    <td><b><?php echo $dadosr['countinsc'];?></b></td>
                    <td><b><?php echo $dadosr['qtde'];?></b></td>
                    <td>
                    <?php
                    if($dadosr['status'] == 0){
                    ?>
                        <form class="form-inline" method="POST" action="index.php">
                        <input type="hidden" name="evento" id="evento" value="<?php echo $dadosr['id'];?>">
                        <input type="submit" class="btn btn-success my-2 my-sm-0"  value="ABRIR INSCRIÇÕES" id="INICIAR" name="INICIAR"><br>
                        </form>  
                    <?php
                    }else if($dadosr['status'] == 1){
                    ?>
                        <form class="form-inline" method="POST" action="index.php">
                        <input type="hidden" name="evento" id="evento" value="<?php echo $dadosr['id'];?>">
                        <input type="submit" class="btn btn-danger my-2 my-sm-0"  value="FECHAR INSCRIÇÕES" id="FECHAR" name="FECHAR"><br>
                        </form> 
                    <?php 
                    }
                    ?>
                    </td>
                    <td>
                    <a class="btn btn-info my-2 my-sm-0" href="inscricao.php?evento=<?php echo $dadosr['id'];?>">IMPRIMIR LISTA</a>
                    </td>
                </tr>
            <?php
            }
            ?>
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