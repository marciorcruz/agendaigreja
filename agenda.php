<?php
include "conn.php";
include "top.php";
?>
<div class="row">
<?php
if(isset($_COOKIE['inscricao'])){
unsetcookie('inscricao');
?>
<div class="jumbotron">
  <h1 class="display-4">Seu agendamento foi realizado com sucesso!</h1>
  <p class="lead">Esperamos que essa situação seja breve e retornemos as nossas atividades normais!</p>
  <hr class="my-4">
  <p>Deus abençoe!</p>
</div>
<?php
}else{
?>
<div class="jumbotron">
  <h1 class="display-4">Agendamento para participação em programações</h1>
  <p class="lead">É necessário para o retorno gradual do Culto na Igreja a limitação de pessoas no Templo, portanto faça o agendamento prévio para os Cultos.</p>
  <hr class="my-4">
  <p><b>Qualquer dúvida entre contato:</b> igreja@ipmontesiao.org.br</p>
  <a class="btn btn-success btn-lg" href="/" role="button">Agendamento</a>
</div>
<?php
}
?>
</div>
<?php
include "bottom.php";
?>