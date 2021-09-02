<?php
include "conn.php";
include "top.php";

$nomedata = "";
$telefonedata = "";
$cpfdata = "";
$eventodata = "";
$checkedaceitedata = "";
$qtdepeopledata = "";
$message = "";
$messageconsulta = "";
$autofocus = "";


$active1t = "active";
$active2t = "";
$active3t = "";

$active1 = "show active";
$active2 = "";
$active3 = "";

if(count($_POST)){
	$autofocus = "autofocus";
	if(isset($_POST['consultar'])){
        if($_POST['consultar'] == "OK"){
            $active1t = "";
            $active2t = "active";
            $active3t = "";

            $active1 = "";
            $active2 = "show active";
            $active3 = "";
            $messageconsulta = $_POST['consultar'];

            if(isset($_POST['cpfdata'])){
                $cpfdata = $_POST['cpfdata'];
                if(validaCPF($cpfdata)){
                        $SQLDATA = "select inscricoes.*, eventos.data, eventos.evento from inscricoes inner join eventos on  eventos.id = inscricoes.idevento where inscricoes.id = (SELECT max(inscricoes.id) FROM inscricoes INNER JOIN eventos ON eventos.id = inscricoes.idevento  WHERE inscricoes.cpf = '$cpfdata')";
                        $resultx = mysqli_query($conexao,$SQLDATA) or die("ERRO");
                        if ($resultx) {
                            $messageconsulta = "";
                            if (mysqli_num_rows($resultx)<=0){
                                $messageconsulta = "Nenhum agendamento encontrado!";
                            }else{
                                while($dadosr=mysqli_fetch_assoc($resultx))
                                {
                                    $messageconsulta = $messageconsulta . "<br><br>Último Agendamento:<br><b>" . $dadosr['evento'] . "</b>"; 
                                    $messageconsulta = $messageconsulta . "<br>Em nome de :<b>" . $dadosr['nome'] . "</b>"; 
                                    $messageconsulta = $messageconsulta . "<br>Quantidade Pessoas:<b>" . $dadosr['pessoas'] . "</b>"; 
                                }
                            }
                        }else{
                            $messageconsulta = "Nenhum agendamento encontrado!";
                        }
                    }else{
                        $messageconsulta = "CPF inválido!";
                    }
            }else{
                $messageconsulta = "Informe seu CPF!";
            }
        }
	}else if(isset($_POST['cancelar'])){
        if($_POST['cancelar'] == "OK"){
            $active1t = "";
            $active2t = "";
            $active3t = "active";

            $active1 = "";
            $active2 = "";
            $active3 = "show active";
        }
    }else if(isset($_POST['agendar'])){
        if($_POST['agendar'] == "OK"){
            $active1t = "active";
            $active2t = "";
            $active3t = "";

            $active1 = "show active";
            $active2 = "";
            $active3 = "";
            if(isset($_POST['eventodata'])){
                $eventodata = $_POST['eventodata'];
                if(isset($_POST['nomedata'])){
                    $nomedata = $_POST['nomedata'];
                    if(isset($_POST['cpfdata'])){
                        $cpfdata = $_POST['cpfdata'];
                        if(validaCPF($cpfdata)){
                            if(isset($_POST['telefonedata'])){
                                $telefonedata = $_POST['telefonedata'];
                                if(isset($_POST['checkedaceitedata'])){
                                    $checkedaceitedata = $_POST['checkedaceitedata'];
                                    $qtdepeopledata = $_POST['qtdepeopledata'];
                                    
                                    $resultcr = mysqli_query($conexao,"SELECT 
                                                                        (SELECT qtde FROM eventos WHERE id = '$eventodata' AND status = 1) TOTALEVENTO,
                                                                        (SELECT sum(pessoas) FROM inscricoes WHERE idevento = '$eventodata') TOTALINSCRITO
                                                                    ") or die("ERRO");
                                    if ($resultcr) {
                                        $rowrc = $resultcr->fetch_row();
                                        $resultcr -> free_result();
                                        $total = $rowrc[0];
                                        $totali = ($rowrc[1] + $qtdepeopledata);
                                        if($total >= $totali){
                                            $resultx = mysqli_query($conexao,"SELECT * FROM inscricoes INNER JOIN eventos ON eventos.id = inscricoes.idevento  WHERE eventos.status = 1 AND inscricoes.cpf = '$cpfdata' AND eventos.data in (SELECT eventos.data FROM eventos where eventos.status = 1 AND eventos.id = '$eventodata')");
                                            if ($resultx) {
                                                if (mysqli_num_rows($resultx)<=0){
                                                    $resultx2 = mysqli_query($conexao,"SELECT * FROM inscricoes WHERE idevento = '$eventodata' and cpf = '$cpfdata'") or die("ERRO");
                                                    if ($resultx2) {
                                                        $nomecompleto = explode(" ",$nomedata);
                                                        if(count($nomecompleto) > 1){
                                                            if (mysqli_num_rows($resultx2)<=0){
                                                                $registerevent = "INSERT INTO `inscricoes` (`id`,`idevento`,`nome`,`telefone`,`cpf`,`pessoas`,`aceito`,`data`) 
                                                            VALUES (NULL, '$eventodata', '$nomedata', '$telefonedata', '$cpfdata', '$qtdepeopledata', '$checkedaceitedata', NOW());";
                                                                $resultxe = $conexao->query($registerevent);
                                                                if ($resultxe) {
                                                                    if($totali >= $total){
                                                                        $closeevent = "UPDATE eventos SET status = 0 WHERE id = '$eventodata' AND status = 1";
                                                                        $resultxevc = $conexao->query($closeevent);
                                                                    }
                                                                    setcookie("inscricao",true);
                                                                    echo"<script language='javascript' type='text/javascript'>alert('Confirmada com SUCESSO a sua participação!');window.location.href='agenda.php';</script>";
                                                                }
                                                            }
                                                            else{
                                                                $message = "Você já se cadastrou para esse horário!";
                                                            }
                                                        }
                                                        else{
                                                            $message = "Seu nome parece estar está incompleto!";
                                                        }
                                                    }
                                                    else{
                                                        $message = "Você já se cadastrou para esse horário!";
                                                    }
                                                }
                                                else{
                                                    $message = "Você já se cadastrou para essa data!";
                                                }
                                            }
                                            else{
                                                $message = "Você já se cadastrou para essa data!";
                                            }
                                        }
                                        else{
                                            $message = "Quantidade de pessoas excede o limite para esse horário. Ou inscrições encerradas para esse horário!";
                                        }
                                    }
                                    else{
                                        $message = "Evento indisponível!";
                                    }
                                }
                                else{
                                    $message = "Necessário aceitar os termos da declaração de risco!";
                                }
                            }
                            else{
                                $message = "Informe seu telefone!";
                            }
                        }
                        else{
                            $message = "CPF inválido, verifique e tente novamente!";
                        }
                    }
                    else{
                        $message = "Informe seu cpf!";
                    }
                }
                else{
                    $message = "Informe seu nome!";
                }
            }
            else{
                $message = "Escolha um evento!";
            }
        }
	}
}
?>
<div class="row">
    
    <div class="col-sm-6">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link <?php echo $active1t;?>" id="nav-agendamento-tab" data-toggle="tab" href="#nav-agendamento" role="tab" aria-controls="nav-agendamento" aria-selected="true">Agendar</a>
                <a class="nav-link <?php echo $active2t;?>" id="nav-consultar-tab" data-toggle="tab" href="#nav-consultar" role="tab" aria-controls="nav-consultar" aria-selected="false">Consultar</a>
                <a class="nav-link <?php echo $active3t;?>" id="nav-cancelar-tab" data-toggle="tab" href="#nav-cancelar" role="tab" aria-controls="nav-cancelar" aria-selected="false">Cancelar</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade <?php echo $active1;?> " id="nav-agendamento" role="tabpanel" aria-labelledby="nav-agendamento-tab">
            <div class="card">
            <div class="card-header bg-primary text-white">
                AGENDAMENTO
            </div>
            <div class="card-body">
            <form action="index.php" method="post">
                <?php
                if(strlen($message) > 0){
                ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Aviso</strong> <?php echo $message;?>
                </div>
                <?php
                }
                ?>
            <div class="form-group">
                <label for="eventodata">Escolha o horário que deseja participar:</label>
                <select class="form-control" id="eventodata" name="eventodata" required>
                <option value="">ESCOLHA UM HORÁRIO</option>
                <?php
                $sql = mysqli_query($conexao,"select * from eventos where status = 1 order by data") or die("Erro");
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
            </div>
            <div class="form-group">
                <label for="nomedata">Nome Completo</label>
                <input type="text" class="form-control" id="nomedata" name="nomedata" value="<?php echo $nomedata;?>"  <?php echo $autofocus;?> required>
            </div>
            <div class="form-group">
                <label for="cpfdata">CPF</label>
                <input type="number" class="form-control" id="cpfdata" name="cpfdata"  value="<?php echo $cpfdata;?>"  required>
            </div>
            <div class="form-group">
                <label for="telefonedata">Telefone</label>
                <input type="phone" class="form-control" id="telefonedata" name="telefonedata"  value="<?php echo $telefonedata;?>" required>
            </div>
            <div class="form-group">
                <label for="qtdepeopledata">Quantidade de pessoas que irão com você:</label>
                <select class="form-control" id="qtdepeopledata" name="qtdepeopledata" required>
                    <option value="1" <?php if (isset($_POST['qtdepeopledata'])){
                    if ($qtdepeopledata == 1) {
                    echo  "selected";
                    }
                    }
                    ?>>Somente eu</option>
                    <option value="2" <?php if (isset($_POST['qtdepeopledata'])){
                    if ($qtdepeopledata == 2) {
                    echo  "selected";
                    }
                    }
                    ?>>Eu + 1</option>
                    <option value="3" <?php if (isset($_POST['qtdepeopledata'])){
                    if ($qtdepeopledata == 3) {
                    echo  "selected";
                    }
                    }
                    ?>>Eu + 2</option>
                    <option value="4" <?php if (isset($_POST['qtdepeopledata'])){
                    if ($qtdepeopledata == 4) {
                    echo  "selected";
                    }
                    }
                    ?>>Eu + 3</option>
                </select>
                </div>
                <div class="form-group">
                <label for="check">
                <b>Declaração de Risco *</b><br>
                <small>
                Declaro que eu não apresento os sintomas relacionados à COVID19. Entendo os possíveis riscos que envolvem a minha participação no Culto e comprometo-me a seguir todos os protocolos determinados pela liderança da Igreja. Assumo a responsabilidade pelos demais participantes que estão sendo inscritos por mim, garantindo que eles não apresentam os sintomas e nem fazem parte do <b>grupo de risco</b>, e que seguirão as mesmas regras.
                </small>
                </label>
                </div>
                <div class="form-group form-check">
                <p> </p>
                <input type="checkbox" class="form-check-input" id="checkedaceitedata" name="checkedaceitedata" <?php if (isset($_POST['checkedaceitedata'])){ echo  "checked" ;}?> required>
                <label class="form-check-label" for="checkedaceitedata" >Sim, declaro, estou ciente e assumo a responsabilidade</label>
            </div>
            <input type="hidden" name="agendar" id="agendar" value="OK">
            <button type="submit" class="btn btn-primary">ENVIAR</button>
            </form>
            </div>
        </div>
            </div>
            <div class="tab-pane fade <?php echo $active2;?>" id="nav-consultar" role="tabpanel" aria-labelledby="nav-consultar-tab">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                    CONSULTAR AGENDAMENTO
                    </div>
                    <div class="card-body">
                    <form action="index.php" method="post">
                    <?php
                    if(strlen($messageconsulta) > 0){
                    ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Aviso</strong> <?php echo $messageconsulta;?>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="form-group">
                    <label for="cpfdata">CPF</label>
                    <input type="number" class="form-control" id="cpfdata" name="cpfdata"  value="<?php echo $cpfdata;?>"  required>
                    </div>
                    <input type="hidden" name="consultar" id="consultar" value="OK">
                    <button type="submit" class="btn btn-warning">CONSULTAR</button>
                    </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade <?php echo $active3;?>" id="nav-cancelar" role="tabpanel" aria-labelledby="nav-cancelar-tab">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                    CANCELAR AGENDAMENTO
                    </div>
                    <div class="card-body">
                        Entre em contato com o Rev. Avaci!
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h2 >Instruções de agendamento para os cultos</h1>
        <p class="lead">É necessário para o retorno gradual do Culto na Igreja a limitação de pessoas no Templo, portanto faça o agendamento prévio para os Cultos.</p>
        <h2>LEIA COM ATENÇÃO ANTES DE REALIZAR O AGENDAMENTO</h2>
        <p class="lead">O Conselho da Igreja aconselha os irmãos pertencentes ao grupo de risco que fique em casa! Os dois Cultos serão transmitidos ao vivo através do <a href="https://www.youtube.com/c/IgrejaPresbiterianaMonteSião"><b>YOUTUBE</b></a></p>
        <br><b>GRUPO DE RISCO</b>
        <ul>
        <li>Idade < 12 anos e ≥ 65 anos.</li>
        <li>Doença pulmonar crônica.</li>
        <li>Doenças cardiovascular.</li>
        <li>Hipertensão arterial severa.</li>
        <li>Diabetes.</li>
        <li>Insuficiência renal</li>
        <li>Pacientes oncóticos </li>
        <li>Imunodeficiência.</li>
        <li>Gestantes</li>
        <li>Obesidade</li>
        </ul>
        <br>
        <b>Informações sobre o Culto</b><br>
        <p  class="lead">É obrigatório o uso de máscara em todas as dependências da Igreja (na área interna e externa, bem como durante todo o Culto, inclusive durante os cânticos, hinos e orações).</p> 
        <br><a href="Comunicado.pdf" class="btn btn-success">FAZER DOWNLOAD DO COMUNICADO</a><br><br><br>
    </div>
</div>
<?php
include "bottom.php";
?>