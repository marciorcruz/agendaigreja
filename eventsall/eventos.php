<?php
include "../conn.php";
if(isset($_COOKIE['login'])){
    $login_cookie = $_COOKIE['login'];
    $eventodata = "";
    $datadata = "";
    $qtdedata = "";

    if(isset($_POST['ADDDATA'])){
        if(isset($_POST['eventodata'])){
            if(isset($_POST['datadata'])){
                if(isset($_POST['qtdedata'])){
                    $eventodata = $_POST['eventodata'];
                    $datadata = $_POST['datadata'];
                    $qtdedata = $_POST['qtdedata'];
                    $addnew = "INSERT INTO `eventos` (`id`, `evento`, `qtde`, `descricao`, `data`, `status`) VALUES (NULL, '$eventodata', '$qtdedata', '', '$datadata', '0');";
                    if (mysqli_query($conexao, $addnew)) {
                        header("Location:eventos.php");
                    } 
                }
            }
        }
    }

    if(isset($_POST['APAGAR'])){
        $id = $_POST['evento'];
        $clear1 = "DELETE FROM eventos where id=" .  $id ;
        if (mysqli_query($conexao, $clear1)) {
            $clear2 = "DELETE FROM inscricoes where idevento=" .  $id ;
            if (mysqli_query($conexao, $clear2)) {
                header("Location:eventos.php");
            } 
        } 
    }

    if(isset($_POST['ALTERAR'])){
        $id = $_POST['evento'];
        $qtdedata = $_POST['qtdedata'];
        $clear1 = "UPDATE eventos SET qtde='$qtdedata' where id=" .  $id ;
        if (mysqli_query($conexao, $clear1)) {
            header("Location:eventos.php");
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
        <div class="card">
        <div class="card-header">
            Adicionar novo evento
        </div>
        <div class="card-body">
        <form method="POST" action="eventos.php">
            <div class="form-row align-items-center">
                <div class="col-sm-3 my-1">
                    <label class="sr-only" for="eventodata">Evento</label>
                    <input type="text" class="form-control" id="eventodata" name="eventodata" placeholder="Evento">
                </div>
                <div class="col-sm-3 my-1">
                    <label class="sr-only" for="datadata">Data</label>
                    <input type="date" class="form-control" id="datadata" name="datadata" placeholder="Data">
                </div>
                <div class="col-sm-3 my-1">
                <label class="sr-only" for="qtdedata">Limite</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                    <div class="input-group-text">Limite</div>
                    </div>
                    <input type="number" class="form-control" id="qtdedata" name="qtdedata" placeholder="Limite">
                </div>
                </div>
                <div class="col-auto my-1">
                    <input type="hidden" class="btn btn-danger"  value="ADDDATA" id="ADDDATA" name="ADDDATA">
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </div>
            </form>
        </div>
        <br>
        </div>
        
            <table class="table table-striped">
            <thead>
            <tr>
            <th scope="col">Eventos</th>
            <th scope="col">Data</th>
            <th scope="col">Limite</th>
            <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $perguntas = mysqli_query($conexao,"select * from eventos order by data, evento") or die("Erro");
            while($dadosr=mysqli_fetch_assoc($perguntas))
            {
            ?>
                <tr>
                    <td><?php echo $dadosr['evento'];?></td>
                    <td><?php echo $dadosr['data'];?></td>
                    <td>
                        <form class="form-inline" method="POST" action="eventos.php">
                            <div class="input-group">
                            <div class="custom-file">
                            <input type="number" class="form-control" id="qtdedata" name="qtdedata" placeholder="Limite" value="<?php echo $dadosr['qtde'];?>">
                            </div>
                            <div class="input-group-append">
                                <input type="hidden" name="evento" id="evento" value="<?php echo $dadosr['id'];?>">
                                <input class="btn btn-outline-secondary" type="submit" id="ALTERAR" name="ALTERAR" value="ALTERAR">
                            </div>
                            </div>
                        </form>  
                    </td>
                    <td>
                        <form class="form-inline" method="POST" action="eventos.php">
                            <input type="hidden" name="evento" id="evento" value="<?php echo $dadosr['id'];?>">
                            <input type="submit" class="btn btn-danger"  value="APAGAR" id="APAGAR" name="APAGAR"><br>
                        </form>  
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