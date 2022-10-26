<?php
require("../models/CadeirasCativas.class.php");


class CadeiraCativa extends CadeirasCativas{
		
	static function select_all_cadeiras_by_sector($id_setor){
		$l = parent::select_all_cadeiras_by_sector($id_setor);	
		if($l['num'] > 0){			
			return $l;
		}
	}	
	
	static function select_jogo_cadeira_by_id_jogo_and_id_user($id_jogo,$id_user){
		$l = parent::select_jogo_cadeira_by_id_jogo_and_id_user($id_jogo,$id_user);	
		if($l['num'] > 0){	
			if($l['status'] == "0"){
				$l['cod_status'] = "0";
				$l['status'] 	= "disponível";
			}
			if($l['status'] == "1"){
				$l['cod_status'] = "1";
				$l['status'] 	= "reservada";
			}
		}else{
				$l['cod_status'] = "2";
				$l['status'] 	= "não definido";
		}
		return  $l;
	}	
	
	static function select_all_cartoes_by_user($id_user,$id){
		$l = parent::select_all_cartoes_by_user($id_user,$id);	
		if($l['num'] > 0){			
			return $l;
		}
	}
	
	static function atuliza_status_cadeira_jogo($id_cadeira, $id_jogo,$status){
		$v = parent::verifica_cadeira_jogo($id_cadeira, $id_jogo);	
		if($v['num'] > 0){			
			$a = parent::update_cadeira_cativa_jogo($status,$id_cadeira,$id_jogo);
			$l['msg_success'] = "Cadeira atualizada com sucesso";
		}else{
			$a = parent::register_cadeira_cativa_jogo($id_cadeira,$id_jogo,$status);
			$l['msg_success'] = "Cadeira atualizada com sucesso";
		}
		return $l;
	}
	
	static function register_cadeira_cativa($request){	
		$l['cod_error'] = "";
		
		if(empty($request['id_usuario'])){
			$l['cod_error'] = "16";
			$l['msg_error'] = "Usuário não informado";
		}
	
		if(empty($request['id_estadio'])){
			$l['cod_error'] = "17";
			$l['msg_error'] = "Estádio não informado";
		}
		/* 
		if(empty($request['id_setor'])){
			$l['cod_error'] = "18";
			$l['msg_error'] = "Setor não informado";
		}		
					
		if(empty($request['rampa'])){
			$l['cod_error'] = "19";
			$l['msg_error'] = "Informe a rampa";
		}		 */
					
		$request['id_setor'] 	= 0;		
		$request['rampa'] 		= 0;		
					
		if(empty($request['bloco'])){
			$l['cod_error'] = "20";
			$l['msg_error'] = "Informe o bloco";
		}		
					
		if(empty($request['fila'])){
			$l['cod_error'] = "21";
			$l['msg_error'] = "Informe a fila";
		}					
					
	/* 	if(empty($request['codigo_cadeira'])){
			$l['cod_error'] = "23";
			$l['msg_error'] = "Informe o código da cadeira";
		}		 */

/**/ 		
		$v = parent::select_all_cadeiras_by_codigo_cadeira($request['codigo_cadeira']);
		if($v['num'] > 0){	
			$l['cod_error'] = "36";
			$l['msg_error'] = "O código desta cadeira já foi cadastrado em nosso sistema";
		} 	
		
		if($l['cod_error'] == ""){

			$l = parent::register_cadeira_cativa_bd($request['id_usuario'],$request['id_estadio'],$request['id_setor'],$request['rampa'],$request['bloco'],$request['fila'],$request['cadeira'],$request['codigo_cadeira']);
			$l['msg_success'] = "Cadastro realizado com sucesso";
		}
		
		return $l;
		
	}	
	
	static function update_imagem_cadeira($imagem, $id){
		$l = parent::update_imagem($imagem, $id);
	}
	
	
}
?>