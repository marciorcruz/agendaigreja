<?php
include "../conn.php";
if(isset($_COOKIE['login'])){
    $login_cookie = $_COOKIE['login'];
    if(isset($_POST['ZERAR'])){
        //$delete = "DELETE FROM inscricoes WHERE 1 = 1";
        //if (mysqli_query($conexao, $delete)) {
        header("Location:config.php");
        //} 
    }
    if(isset($_POST['PARAR'])){
        $update = "UPDATE eventos SET status = 0";
        if (mysqli_query($conexao, $update)) {
            header("Location:config.php");
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
            <form class="form-inline" method="POST" action="config.php">
            <input type="submit" class="btn btn-danger my-2 my-sm-0"  value="ZERAR INSCRIÇÕES" id="ZERAR" name="ZERAR"><br>
            </form>  
            <br>
            <form class="form-inline" method="POST" action="config.php">
            <input type="submit" class="btn btn-warning my-2 my-sm-0"  value="PARAR EVENTOS" id="PARAR" name="PARAR"><br>
            </form> 
        <?php
        }
        ?>
    </div>
</main>
 <?php
 include "bottom.php";
 ?>