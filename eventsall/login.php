<?php 
include "../conn.php";

if(isset($_POST['login'])){
    $login = $_POST['login'];
}

if(isset($_POST['sair'])){
    $sair = $_POST['sair'];
}

if(isset($_POST['senha'])){
    $senha = $_POST['senha'];
}

if(isset($_POST['entrar'])){
    $entrar = $_POST['entrar'];
}

if (isset($entrar)) {
	$verifica = mysqli_query($conexao,"SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha' AND status = 1") or die("erro ao selecionar");
	if (mysqli_num_rows($verifica)<=0){
		echo"<script language='javascript' type='text/javascript'>alert('Login e/ou senha incorretos');window.location.href='login.html';</script>";
		die();
	}
	else{
		setcookie("login",$login);
		header("Location:index.php");
	}
}

if (isset($sair)) {
    if (isset($_COOKIE['login'])) {
        unsetcookie('login');
        header("Location:index.php");
    }
}
?>