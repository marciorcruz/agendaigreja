<?php 
ob_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getNameMonth($mes_num){
    $mes = "";
    switch ($mes_num) {
        case 1:    $mes = "Janeiro";     break;
        case 2:    $mes = "Fevereiro";   break;
        case 3:    $mes = "Março";       break;
        case 4:    $mes = "Abril";       break;
        case 5:    $mes = "Maio";        break;
        case 6:    $mes = "Junho";       break;
        case 7:    $mes = "Julho";       break;
        case 8:    $mes = "Agosto";      break;
        case 9:    $mes = "Setembro";    break;
        case 10:    $mes = "Outubro";     break;
        case 11:    $mes = "Novembro";    break;
        case 12:    $mes = "Dezembro";    break; 
     }
    return $mes;
}

function unsetcookie($key, $path = '', $domain = '', $secure = false)
{
    if (array_key_exists($key, $_COOKIE)) {
        if (false === setcookie($key, null, -1, $path, $domain, $secure)) {
            return false;
        }
        unset($_COOKIE[$key]);
    }
    return true;
}

function validaCPF($cpf = null) {

	// Verifica se um número foi informado
	if(empty($cpf)) {
		return false;
	}

	// Elimina possivel mascara
	$cpf = preg_replace("/[^0-9]/", "", $cpf);
	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
	
	// Verifica se o numero de digitos informados é igual a 11 
	if (strlen($cpf) != 11) {
		return false;
	}
	// Verifica se nenhuma das sequências invalidas abaixo 
	// foi digitada. Caso afirmativo, retorna falso
	else if ($cpf == '00000000000' || 
		$cpf == '11111111111' || 
		$cpf == '22222222222' || 
		$cpf == '33333333333' || 
		$cpf == '44444444444' || 
		$cpf == '55555555555' || 
		$cpf == '66666666666' || 
		$cpf == '77777777777' || 
		$cpf == '88888888888' || 
		$cpf == '99999999999') {
		return false;
	 // Calcula os digitos verificadores para verificar se o
	 // CPF é válido
	 } else {   
		
		for ($t = 9; $t < 11; $t++) {
			
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf{$c} != $d) {
				return false;
			}
		}

		return true;
	}
}

session_start();
$user = "agendauserdb"; 
$password = "agendapassdb"; 
$database = "agenda"; 
$hostname = "localhosf"; 
 
$conexao = mysqli_connect($hostname,$user,$password);
$banco = mysqli_select_db($conexao,$database);
mysqli_set_charset($conexao,'utf8');

$_msgdirect = "";
if(isset($_GET['ms'])){
    $_msgdirect = base64_decode($_GET['ms']);
}
?>