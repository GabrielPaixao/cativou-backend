<?php

//use DI\ContainerBuilder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require("../config/DB.class.php");
require("../services/functions.php");

require("../controllers/access.php");
require("../controllers/register.php");
require("../controllers/times.php");
require("../controllers/estadios.php");
require("../controllers/eventos.php");
require("../controllers/cadeirasCativas.php");
require("../controllers/cadeirasCativasEventos.php");
require("../controllers/campeonatos.php");

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$app = AppFactory::create();
$app->setBasePath("/cativou/api/public");



$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {

    $response->
    getBody()->
    write("Our index page! (Home page)");

    return $response;
});

/* 
$app->get('/cadeira', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {    
   
	$cadeiras = [
			'1' => 'Marcio',
			'2' => 'Gabriel',
			'3' => 'Carol'
	 ];
	 
	 $response->getBody()->write(json_encode($cadeiras));
	 return $response->withHeader('Content-type','application/json'); 
	 
}); */


$app->get('/carregaUsuario/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$userId = $args['id'];
		$dados = RegisterU::select_dados_user_by_id($userId);
		$dados['num'] = "N/A";
		$response->getBody()->write(json_encode($dados));
		if(!empty($dados['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}
	 
});
$app->get('/testeScan/{cod}/{login}/{senha}/{setor}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		//$cod = 		
		$dados['cod'] 		= $args['cod'];
		$dados['login'] 	= $args['login'];
		$dados['senha'] 	= $args['senha'];
		$dados['setor'] 	= $args['setor'];
		$response->getBody()->write(json_encode($dados));
		if(!empty($dados['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}
	 
});

$app->get('/cancelaConta/{id}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$userId = $args['id'];
		$dados = RegisterU::delete_user_by_id($userId);
		/* $dados['num'] = "N/A";
		$response->getBody()->write(json_encode($dados)); */
		
		return $response->withHeader('Content-type','application/json')->withStatus(200);
	 
});

$app->get('/jogos/{id_estadio}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_estadio = $args['id_estadio'];
		$dados = Campeonato::select_all_jogos_estadio($id_estadio);
		$dados_t = [];
		
		foreach($dados['dados'] as $c){
			$c['data'] = databr($c['data']);
			$c['hora'] = substr($c['hora'],0,-3)."h";
			array_push($dados_t,$c);
		}
		
		$response->getBody()->write(json_encode($dados_t));
		
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/jogos_by_id/{id_jogo}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_jogo = $args['id_jogo'];
		$dados = Campeonato::select_jogo_by_id($id_jogo);
		
		$response->getBody()->write(json_encode($dados));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/cadeiras_by_sector/{id_setor}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_setor = $args['id_setor'];
		$dados = CadeiraCativa::select_all_cadeiras_by_sector($id_setor);
		
		$response->getBody()->write(json_encode($dados));
		return $response->withHeader('Content-type','application/json')->withStatus(201); 
	 
});

$app->get('/setores_by_estadio/{id_estadio}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_estadio = $args['id_estadio'];
		$dados = Estadio::select_all_sector_by_estadio($id_estadio);
		
		$response->getBody()->write(json_encode($dados['dados']));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/cadeira_by_jogo_user_manager/{id_usuario}/{id_jogo}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_usuario = $args['id_usuario'];
		$id_jogo = $args['id_jogo'];
		$dados = CadeiraCativa::select_jogo_cadeira_by_id_jogo_and_id_user($id_jogo,$id_usuario);
		
		$response->getBody()->write(json_encode($dados));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/cadeira_by_evento_user_manager/{id_usuario}/{id_evento}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_usuario = $args['id_usuario'];
		$id_evento = $args['id_evento'];
		$dados = CadeiraCativaEvento::select_eventos_cadeira_by_id_evento_and_id_user($id_evento,$id_usuario);
		
		$response->getBody()->write(json_encode($dados));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/atualiza_cadeira_jogo/{id_cadeira}/{id_jogo}/{status}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_cadeira = $args['id_cadeira'];
		$id_jogo = $args['id_jogo'];
		$status = $args['status'];
		$dados = CadeiraCativa::atuliza_status_cadeira_jogo($id_cadeira, $id_jogo, $status);
		
		$response->getBody()->write(json_encode($dados));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/atualiza_cadeira_evento/{id_cadeira}/{id_evento}/{status}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_cadeira = $args['id_cadeira'];
		$id_jogo = $args['id_evento'];
		$status = $args['status'];
		$dados = CadeiraCativaEvento::atuliza_status_cadeira_evento($id_cadeira, $id_evento, $status);
		
		$response->getBody()->write(json_encode($dados));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});


$app->get('/clubes', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		
		$dados = Clubes::select_all_clubes();
		
		$response->getBody()->write(json_encode($dados['dados']));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/bancos', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		
		$dados = RegisterU::select_all_banks();
		
		$response->getBody()->write(json_encode($dados['dados']));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});


$app->get('/estadios', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		
		$dados = Estadio::select_all_estadios();
		
		$response->getBody()->write(json_encode($dados['dados']));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});


$app->get('/eventos', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$dados = Evento::select_all_eventos();
		$dados_t = [];
		
		foreach($dados['dados'] as $c){
			$c['artista'] = htmlspecialchars_decode(($c['artista']));
			$c['data'] = databr($c['data']);
			$c['hora'] = substr($c['hora'],0,-3)."h";
			array_push($dados_t,$c);
		}
		
		$response->getBody()->write(json_encode($dados_t));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/times', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$dados = Campeonato::select_all_times();
		
		$response->getBody()->write(json_encode($dados['dados']));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/eventos_by_id/{id_evento}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_evento = $args['id_evento'];
		$dados = Evento::select_eventos_by_id($id_evento);
		
		$response->getBody()->write(json_encode($dados));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->get('/cartoes_by_user/{id_user}', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
		$id_user = $args['id_user'];
		$dados = CadeiraCativa::select_all_cartoes_by_user($id_user,$id_user);
		$dados_e = CadeiraCativaEvento::select_all_cartoes_by_user($id_user,$id_user);
		$dados_t = [];
		
		foreach($dados['dados'] as $c){
			array_push($dados_t,$c);
		}
		
		foreach($dados_e['dados'] as $ce){
			array_push($dados_t,$ce);
		}
		
		$response->getBody()->write(json_encode($dados_t));
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	 
});

$app->post('/login', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $data = $request->getParsedBody();
	$login = Login::login_usuer($data['login'],$data['senha']);

	 $response->getBody()->write(json_encode($login));
		if(!empty($login['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}

});

$app->post('/login_by_google', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $data = $request->getParsedBody();
	$login = Login::login_usuer_by_google($data['token_google']);

	 $response->getBody()->write(json_encode($login));
		if(!empty($login['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}

});

$app->post('/login_by_facebook', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $data = $request->getParsedBody();
	$login = Login::login_usuer_by_facebook($data['token_facebook']);

	 $response->getBody()->write(json_encode($login));
		if(!empty($login['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}

});

$app->post('/updateAba1', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $data = $request->getParsedBody();
	$dados = RegisterU::update_perfil_aba_h_1($data['nome'], $data['id_time'],  $data['id_tipo'], $data['celular'], $data['id_usuario']);

	 $response->getBody()->write(json_encode($dados));
		if(!empty($dados['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}

});

$app->post('/updateAba2', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    $data = $request->getParsedBody();
	$dados = RegisterU::update_perfil_aba_2($data['email'], $data['senha'], $data['id_usuario']);

	 $response->getBody()->write(json_encode($dados));
		if(!empty($dados['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}

});


$app->post('/cadastro', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
	$directory = 'files';
    $uploadedFiles = $request->getUploadedFiles();
	$data = $request->getParsedBody();
	
	$register = RegisterU::register_usuer($data);
	
	if(empty($register['error'])){
		
		//Efetua o upload da imagem do cartão
		if(!empty($uploadedFiles['cartao'])){
			$uploadedCartao = $uploadedFiles['cartao'];
			if ($uploadedCartao->getError() === UPLOAD_ERR_OK) {
				$filename = moveUploadedFile($directory, $uploadedCartao);
				$u = RegisterU::update_imagem_cartao($filename,$register['id_last_insert']);
			}
		}
			
		//Efetua o upload da imagem do documento
		if(!empty($uploadedFiles['documento'])){	
			$uploadedDocumento = $uploadedFiles['documento'];
			if ($uploadedDocumento->getError() === UPLOAD_ERR_OK) {
				$filename = moveUploadedFile($directory, $uploadedDocumento);  
				$u = RegisterU::update_img_documento($filename,$register['id_last_insert']);				
			}	
		}	
		
		//Efetua o upload da imagem do perfil
		if(!empty($uploadedFiles['perfil'])){
			$uploadedPerfil = $uploadedFiles['perfil'];
			if ($uploadedPerfil->getError() === UPLOAD_ERR_OK) {
				$filename = moveUploadedFile($directory, $uploadedPerfil);  
				$u = RegisterU::update_img_perfil($filename,$register['id_last_insert']);				
			}
		}
	}
	
	$response->getBody()->write(json_encode($register));
		if(!empty($register['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}
	 

});


$app->post('/cadastro_by_google', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
	$directory = 'files';
    $uploadedFiles = $request->getUploadedFiles();
	$data = $request->getParsedBody();
	
	$register = RegisterU::register_user_by_google($data);
	
	$response->getBody()->write(json_encode($register));
		if(!empty($register['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}
});

$app->post('/cadastro_by_facebook', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
	$directory = 'files';
    $uploadedFiles = $request->getUploadedFiles();
	$data = $request->getParsedBody();
	
	$register = RegisterU::register_user_by_facebook($data);
	
	$response->getBody()->write(json_encode($register));
		if(!empty($register['cod_error'])){
			return $response->withHeader('Content-type','application/json')->withStatus(201);
		}else{
			return $response->withHeader('Content-type','application/json')->withStatus(200); 
		}
});


$app->post('/uploadPerfil', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
	$directory = 'files';
	$uploadedFiles = $request->getUploadedFiles();
	
	$data = $request->getParsedBody();
	if(!isset($data['id_usuario'])){
		
		$register['msg']="Id do usuário não enviado";		
		$response->getBody()->write(json_encode($register));
		return $response->withHeader('Content-type','application/json')->withStatus(201);
		
	//Efetua o upload da imagem do perfil
	}else if(!empty($uploadedFiles['perfil'])){
		$uploadedPerfil = $uploadedFiles['perfil'];
		$name = $uploadedPerfil->getClientFilename();
		
		$arq = explode(".",$name);
	
		 if(
			$arq[1] != "" && 
			$arq[1] != "png" && 
			$arq[1] != "jpg" && 
			$arq[1] != "heic" && 
			$arq[1] != "bmp" && 
			$arq[1] != "gif" && 
			$arq[1] != "jpeg" ){	
					
					$register['msg']="Imagem não enviada, formato inválido de arquivo";
					$register['imagem']=$name;
					$response->getBody()->write(json_encode($register));
					return $response->withHeader('Content-type','application/json')->withStatus(201);
					
		}else{
		
			if ($uploadedPerfil->getError() === UPLOAD_ERR_OK) {
				$filename = moveUploadedFile($directory, $uploadedPerfil);  
				$u = RegisterU::update_img_perfil($filename,$data['id_usuario']);			
			}
			
			$register['msg']="Imagem enviada com sucesso";
			$register['imagem']=$name;
			$response->getBody()->write(json_encode($register));
			return $response->withHeader('Content-type','application/json')->withStatus(200);
			
		}
	}
	
		 
	 
	
});

/* 

 */
 
$app->post('/uploadDocumento', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
	$directory = 'files';
	$uploadedFiles = $request->getUploadedFiles();
	
	$data = $request->getParsedBody();
	if(!isset($data['id_usuario'])){
		
		$register['msg']="Id do usuário não enviado";		
		$response->getBody()->write(json_encode($register));
		return $response->withHeader('Content-type','application/json')->withStatus(201);
		
	//Efetua o upload da imagem do perfil
	}else if(!empty($uploadedFiles['documento'])){
		$uploadedPerfil = $uploadedFiles['documento'];
		$name = $uploadedPerfil->getClientFilename();
		
		$arq = explode(".",$name);
	
		 if(
			$arq[1] != "" && 
			$arq[1] != "png" && 
			$arq[1] != "jpg" && 
			$arq[1] != "heic" && 
			$arq[1] != "bmp" && 
			$arq[1] != "gif" && 
			$arq[1] != "jpeg" ){	
					
					$register['msg']="Imagem não enviada, formato inválido de arquivo";
					$register['imagem']=$name;
					$response->getBody()->write(json_encode($register));
					return $response->withHeader('Content-type','application/json')->withStatus(201);
					
		}else{
		
			if ($uploadedPerfil->getError() === UPLOAD_ERR_OK) {
				$filename = moveUploadedFile($directory, $uploadedPerfil);  
				$u = RegisterU::update_img_documento_dados_bancarios($filename,$data['id_usuario']);			
			}
			
			$register['msg']="Imagem enviada com sucesso";
			$register['imagem']=$name;
			$response->getBody()->write(json_encode($register));
			return $response->withHeader('Content-type','application/json')->withStatus(200);
			
		}
	}
	
		 
	 
	
});

$app->post('/uploadCartao', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
	$directory = 'files';
	$uploadedFiles = $request->getUploadedFiles();
	
	$data = $request->getParsedBody();
	if(!isset($data['id_cartao'])){
		
		$register['msg']="Id do usuário não enviado";		
		$response->getBody()->write(json_encode($register));
		return $response->withHeader('Content-type','application/json')->withStatus(201);
		
	//Efetua o upload da imagem do cartao
	}else if(!empty($uploadedFiles['cartao'])){
		$uploadedCartao = $uploadedFiles['cartao'];
		$name = $uploadedCartao->getClientFilename();
		
		$arq = explode(".",$name);
	
		 if(
			$arq[1] != "" && 
			$arq[1] != "png" && 
			$arq[1] != "jpg" && 
			$arq[1] != "heic" && 
			$arq[1] != "bmp" && 
			$arq[1] != "gif" && 
			$arq[1] != "jpeg" ){	
					
					$register['msg']="Imagem não enviada, formato inválido de arquivo";
					$register['imagem']=$name;
					$response->getBody()->write(json_encode($register));
					return $response->withHeader('Content-type','application/json')->withStatus(201);
					
		}else{
		
			if ($uploadedCartao->getError() === UPLOAD_ERR_OK) {
				$filename = moveUploadedFile($directory, $uploadedCartao);  
				$u = RegisterU::update_imagem_cartao($filename,$data['id_cartao']);			
			}
			
			$register['msg']="Imagem enviada com sucesso";
			$register['imagem']=$name;
			$response->getBody()->write(json_encode($register));
			return $response->withHeader('Content-type','application/json')->withStatus(200);
			
		}
	}
	
		 
	 
	
});


$app->post('/cadastroCadeiraCativa', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
	$directory = 'files';
    $uploadedFiles = $request->getUploadedFiles();
	$data = $request->getParsedBody();
	
	$register = CadeiraCativa::register_cadeira_cativa($data);
	
	if(empty($register['error'])){
		
		//Efetua o upload da imagem do cartão
		if(!empty($uploadedFiles['imagem'])){
			$uploadedCartao = $uploadedFiles['imagem'];
			if ($uploadedCartao->getError() === UPLOAD_ERR_OK) {
				$filename = moveUploadedFile($directory, $uploadedCartao);
				$u = CadeiraCativa::update_imagem_cadeira($filename,$register['id_last_insert']);
			}
		}			
		
	}
	
	$response->getBody()->write(json_encode($register));
	if(!empty($register['cod_error'])){
		return $response->withHeader('Content-type','application/json')->withStatus(201);
	}else{
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	}
});


$app->post('/cadastroDadosBancarios', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
	$directory = 'files';
    $uploadedFiles = $request->getUploadedFiles();
	$data = $request->getParsedBody();
	
	$register = RegisterU::register_usuer_dados_bancarios($data);
	
	if(empty($register['error'])){
		
		//Efetua o upload da imagem do cartão
		if(!empty($uploadedFiles['imagem'])){
			$uploadedCartao = $uploadedFiles['imagem'];
			if ($uploadedCartao->getError() === UPLOAD_ERR_OK) {
				$filename = moveUploadedFile($directory, $uploadedCartao);
				$u = RegisterU::update_img_documento_dados_bancarios($filename,$register['id_last_insert']);
			}
		}			
		
	}
	
	$response->getBody()->write(json_encode($register));
	if(!empty($register['cod_error'])){
		return $response->withHeader('Content-type','application/json')->withStatus(201);
	}else{
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	}

});


$app->post('/atualizaDadosBancarios', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
	$directory = 'files';
    $uploadedFiles = $request->getUploadedFiles();
	$data = $request->getParsedBody();
	
	$register = RegisterU::update_dados_bancarios($data);	
		
	$response->getBody()->write(json_encode($register));
	if(!empty($register['cod_error'])){
		return $response->withHeader('Content-type','application/json')->withStatus(201);
	}else{
		return $response->withHeader('Content-type','application/json')->withStatus(200); 
	}

});


function moveUploadedFile(string $directory, UploadedFileInterface $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

    // see http://php.net/manual/en/function.random-bytes.php
    $basename = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}
//phpinfo();

$app->run();

?>