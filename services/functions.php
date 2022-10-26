<?php



function valid_email($email) {
	$conta = "^[a-zA-Z0-9\._-]+@";
	$domino = "[a-zA-Z0-9\._-]+.";
	$extensao = "([a-zA-Z]{2,4})$";

	$pattern = $conta.$domino.$extensao;

	if (preg_match("/$pattern/", $email))
	return true;
	else
	return false;
}

function limpaDocumentos($valor){
	$valor = trim($valor);
	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", "", $valor);
	$valor = str_replace("-", "", $valor);
	$valor = str_replace("/", "", $valor);
	$valor = str_replace("(", "", $valor);
	$valor = str_replace(")", "", $valor);
	
	return $valor;
}

function limpaTelefone($valor){
	$valor = trim($valor);
	$valor = str_replace(".", "", $valor);
	$valor = str_replace(",", "", $valor);
	$valor = str_replace("-", "", $valor);
	$valor = str_replace("/", "", $valor);
	$valor = str_replace("(", "", $valor);
	$valor = str_replace(")", "", $valor);
	$valor = str_replace(" ", "", $valor);
	
	return (int)$valor;
}


function clean_full($str){
	$str = trim($str);
	$str = str_replace(".", "", $str);
	$str = str_replace(",", "", $str);
	$str = str_replace("-", "", $str);
	$str = str_replace("/", "", $str);
	$str = str_replace("(", "", $str);
	$str = str_replace(")", "", $str);
	$str = str_replace(" ", "", $str);
	return $str;
}

function status($status, $id_user) {

	if ( $status==0) {
	  $button ='<label class="btn btn-outline btn-danger btn-xs" title="Click para Ativar">
					<i class="fa fa-ban"> </i>
				</label>';
	}else{
	  $button ='<label class="btn btn-outline btn-success btn-xs" title="Click para Desativar">
					<i class="fa fa-check-square"> </i>
				</label>';
	}
		
	return $button;
}

/// FUNÇÃO PARA VALIDAR CPF
function validaCPF($cpf = null) {

	// Verifica se um número foi informado
	if(empty($cpf)) {
		return false;
	}
 
	// Elimina possivel mascara
	$cpf = preg_replace('/[^0-9]/', '', $cpf);
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
				$d += $cpf[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf[$c] != $d) {
				return false;
			}
		}
 
		return true;
	}
}

	
// Valida CNPJ
function validaCNPJ($cnpj){
	   
	$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
		
	// Valida tamanho
	if (strlen($cnpj) != 14)
		return false;
	
	// Lista de CNPJs inválidos
	$invalidos = [
	'00000000000000',
	'11111111111111',
	'22222222222222',
	'33333333333333',
	'44444444444444',
	'55555555555555',
	'66666666666666',
	'77777777777777',
	'88888888888888',
	'99999999999999'
	];

	// Verifica se o CNPJ está na lista de inválidos
	if (in_array($cnpj, $invalidos)) {	
		return false;
	}	
	
	// Valida primeiro dígito verificador
	for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
	{
		$soma += $cnpj[$i] * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
		return false;
	// Valida segundo dígito verificador
	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
	{
		$soma += $cnpj[i] * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);	
	
}	
	


function cripto($id) {	
	
	$fator = 0;
	$chave = 0;
	$N     = 0;
	$X     = 0;
	
	//preenchimento aleatório     
	$O = 0;
	$M = 0;
	  
	  
    $keys = array(
		1  => array(59,56),
		2  => array(85,57),
		3  => array(15,23),
		4  => array(5,3),
		5  => array(1,2),
		6  => array(4,2),
		7  => array(1658,235),
		8  => array(85,1024),
		9  => array(9,84),
		10 => array(19,15),
		11 => array(46,79),
		12 => array(35,941),
		13 => array(1515,21536),
		14 => array(1685,3216),
		15 => array(512,2354),);
	
    //chave matriz - aleatória
    $N = rand(1, 15);
    $chave = $N;
	
	//preenchimento aleatório     
	$O = rand(1, 99999999999);
	$M = rand(1, 99999999999);
	  
	//ID qrcode
	$X = $id;

	$fator = $keys[$chave][0] * $keys[$chave][1];
	
	//Criptografa valores com o fator gerado pela chave de criptografia
	$N = $N * $fator;
	$O = $O * $fator;
	$M = $M * $fator;
	$X = $X * $fator;
	
	//Criptografa os valores com o base64
	$chave = base64_encode($chave);
	$N     = base64_encode($N);
	$O     = base64_encode($O);
	$M     = base64_encode($M);
	$X     = base64_encode($X);
		
	//gera o código criptografado final, com os separadores
	$codigo = "".$chave."/".$N."|||".$O."||".$M."|".$X."";
		
	return $codigo;
}

function chave($chave){
  $keys = array(
    1  => array(59,56),
    2  => array(85,57),
    3  => array(15,23),
    4  => array(5,3),
    5  => array(1,2),
    6  => array(4,2),
    7  => array(1658,235),
    8  => array(85,1024),
    9  => array(9,84),
    10 => array(19,15),
    11 => array(46,79),
    12 => array(35,941),
    13 => array(1515,21536),
    14 => array(1685,3216),
    15 => array(512,2354));

  $response = $keys[$chave][0] * $keys[$chave][1];
  return $response;
}

function criptografar($data){
  //chave matriz - aleatória
  //$N = $_POST["N"]; //teste
  $N = rand(1, 15);
  //preenchimento aleatório   
  //$O = $_POST["O"]; //teste   
  $O = rand(1, 99999);
  //preenchimento aleatório
  //$M = $_POST["M"]; //teste   
  $M = rand(1, 99999);
  //ID qrcode
  $X = $data;    
  
  //Define o número da chave aser usada
  $chave = $N;
  //Define o fator, sendo o valor da multiplicação dos elementos do vetor vertical, da chave passada
  $fator = chave($chave);
  
  //Criptografa valores com o fator gerado pela chave de criptografia
  $N = $N * $fator;
  $O = $O * $fator;
  $M = $M * $fator;
  $X = $X * $fator;

  //Criptografa os valores com o base64
  $chave = base64_encode($chave);
  $N = base64_encode($N);
  $O = base64_encode($O);
  $M = base64_encode($M);
  $X = base64_encode($X);

  //gera o código criptografado final, com os separadores
  $codigo = "".$chave."/".$N."|||".$O."||".$M."|".$X."";
  $codigo = "https://prixpay.com/pagamento/index.php?qr=".$codigo;
  return $codigo;
}


function removerCodigoMalicioso($comSeguranca) {
   $comSeguranca = addslashes($comSeguranca);
   $comSeguranca = htmlspecialchars($comSeguranca);
   $comSeguranca = str_replace("SELECT","",$comSeguranca);
   $comSeguranca = str_replace("FROM","",$comSeguranca);
   $comSeguranca = str_replace("WHERE","",$comSeguranca);
   $comSeguranca = str_replace("INSERT","",$comSeguranca);
   $comSeguranca = str_replace("UPDATE","",$comSeguranca);
   $comSeguranca = str_replace("DELETE","",$comSeguranca);
   $comSeguranca = str_replace("DROP","",$comSeguranca);
   $comSeguranca = str_replace("DATABASE","",$comSeguranca);
   
   $comSeguranca = str_replace("select","",$comSeguranca);
   $comSeguranca = str_replace("from","",$comSeguranca);
   $comSeguranca = str_replace("where","",$comSeguranca);
   $comSeguranca = str_replace("insert","",$comSeguranca);
   $comSeguranca = str_replace("update","",$comSeguranca);
   $comSeguranca = str_replace("delete","",$comSeguranca);
   $comSeguranca = str_replace("drop","",$comSeguranca);
   $comSeguranca = str_replace("database","",$comSeguranca);
      
   //$comSeguranca = trim($comSeguranca);
   $comSeguranca = strip_tags($comSeguranca);
   
   return $comSeguranca;
}

/// CONVERTE DATA DE BANCO PARA DATA HTML
function databr($datasql) {
	if (!empty($datasql)){
	$p_dt = explode('-',$datasql);
	$data_br = $p_dt[2].'/'.$p_dt[1].'/'.$p_dt[0];
	return $data_br;
	}
}

function moeda_virgula($num) {
	return number_format($num, 2, ',', '.');
}

function img_logo($img, $path) {
	
	if ($img == "") {return $path.'/no_image.png'; exit;}
	
	$filename_jpg = $path.'/'.$img;
	$filename_png = $path.'/'.$img;
	
	if (file_exists($filename_jpg)) {
		
		return $path.'/'.$img;	
		unlink($path.'/'.$img);
		
	} elseif(file_exists($filename_png)){
		
		return $path.'/'.$img;
		unlink($path.'/'.$img);
		
	} else {
		return $path.'/no_image.png';
	}
	
}

/// CONVERTE DATA HTML PARA DATA DE BANCO
function datasql($databr) {
	if (!empty($databr)){
	$p_dt = explode('/',$databr);
	$data_sql = $p_dt[2].'-'.$p_dt[1].'-'.$p_dt[0];
	return $data_sql;
	}
}

function contains_number($string) {
   return is_numeric(filter_var($string, FILTER_SANITIZE_NUMBER_INT));
}
?>