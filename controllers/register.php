<?php
require("../models/Register.class.php");


class RegisterU extends Register{
	
	static function select_all_banks(){
		$l = parent::select_all_banks();	
		if($l['num'] > 0){
			//$l['dados']['sid'] = "s".$l['id'];
			return $l;

		}
		
	}
	
	static function register_usuer($request){	
		$l['cod_error'] = "";
		
		if(empty($request['nome'])){
			$l['cod_error'] = "2";
			$l['msg_error'] = "Preencha o campo nome";
		}
		
		$n = explode(" ",$request['nome']);
		if(count($n) < 2){
			$l['cod_error'] = "2.1";
			$l['msg_error'] = "É necessário preencher com nome e sobrenome";
		}
		
		if(empty($request['id_tipo'])){
			$l['cod_error'] = "3";
			$l['msg_error'] = "É necessário passar o tipo de cadastro";
		} /* 1 : alugar 2: gerenciar */
		
		if(empty($request['email'])){
			$l['cod_error'] = "4";
			$l['msg_error'] = "Preencha o campo e-mail";
		}		
		
		if(empty($request['celular'])){
			$l['cod_error'] = "9";
			$l['msg_error'] = "Preencha o campo celular";
		}		
			
		if(!valid_email($request['email'])){
			$l['cod_error'] = "5";
			$l['msg_error'] = "E-mail inválido";
		}
					
		$v_email = parent::select_user_email($request['email']);	
		if($v_email['num'] >0){
			$l['cod_error'] = "6";
			$l['msg_error'] = "E-mail já cadastrado";
		}
			
		if(empty($request['cpf'])){
			$l['cod_error'] = "7";
			$l['msg_error'] = "Preencha o campo cpf";
		}		
			
		if(!validaCPF($request['cpf'])){
			$l['cod_error'] = "8";
			$l['msg_error'] = "CPF inválido";
		}
		
		if(strlen($request['senha']) < 7){
			$l['cod_error'] = "33";
			$l['msg_error'] = "Senha inválida. Senha deve ter mais de 7 dígitos.";
		}
		
	
 		$v_cpf = parent::select_user_cpf($request['cpf'],$request['id_tipo']);		
		if($v_cpf['num'] >0){
			$l['cod_error'] = "10";
			$l['msg_error'] = "CPF já cadastrado";
		} /**/
		
		if($l['cod_error'] == ""){
			
			$cpf = str_ireplace(".","",$request['cpf']);
			$cpf = str_ireplace("-","",$cpf);
			
			$l = parent::register_user($request['id_time'],$request['id_tipo'],$request['nome'],$request['email'],$cpf,$request['celular'],$request['endereco'],sha1($request['senha']),$request['img_cartao'],$request['img_documento'],$request['img_perfil'],$request['token_facebook'],$request['token_google']);
			$l['msg_success'] = "Cadastro realizado com sucesso";
			$l['sid'] = "s".$l['id_last_insert'];
		}
		
		return $l;
		
	}	
	
	public function register_user_by_google($request){	
		$l['cod_error'] = "";
		
		if(empty($request['id_tipo'])){
			$l['cod_error'] = "3";
			$l['msg_error'] = "É necessário passar o tipo de cadastro";
		} /* 1 : alugar 2: gerenciar */
		
		
		if(empty($request['token_google'])){
			$l['cod_error'] = "54";
			$l['msg_error'] = "Token google inválido";
		} 
		
							
		$v_email = parent::select_user_email($request['email'],$request['id_tipo']);	
		if($v_email['num'] >0){
			$l['cod_error'] = "6";
			$l['msg_error'] = "E-mail já cadastrado";
		}
		
		if($l['cod_error'] == ""){
			
			$cpf = str_ireplace(".","",$request['cpf']);
			$cpf = str_ireplace("-","",$cpf);
			
			$l = parent::register_user_by_google($request['id_tipo'],$request['name'],$request['email'],$request['token_google'],$request['img_perfil'],"","");
			$l['msg_success'] = "Cadastro realizado com sucesso";
			$l['sid'] = "s".$l['id_last_insert'];
		}
		
		return $l;
		
	}	
	
	static function register_user_by_facebook($request){	
		$l['cod_error'] = "";
		
		if(empty($request['id_tipo'])){
			$l['cod_error'] = "3";
			$l['msg_error'] = "É necessário passar o tipo de cadastro";
		} /* 1 : alugar 2: gerenciar */
		
		if(empty($request['token_facebook'])){
			$l['cod_error'] = "53";
			$l['msg_error'] = "Token facebook inválido";
		} 
		
							
		$v_email = parent::select_user_email($request['email'],$request['id_tipo']);	
		if($v_email['num'] >0){
			$l['cod_error'] = "6";
			$l['msg_error'] = "E-mail já cadastrado";
		}
		
		if($l['cod_error'] == ""){
			
			$cpf = str_ireplace(".","",$request['cpf']);
			$cpf = str_ireplace("-","",$cpf);
			
			$l = parent::register_user_by_facebook2($request['id_tipo'],$request['name'],$request['email'],$request['token_facebook'],$request['img_perfil'],"","");
			$l['msg_success'] = "Cadastro realizado com sucesso";
			$l['sid'] = "s".$l['id_last_insert'];
		}
		
		return $l;
		
	}	
	
	static function register_usuer_dados_bancarios($request){	
		$l['cod_error'] = "";
		
		if(empty($request['id_usuario'])){
			$l['cod_error'] = "11";
			$l['msg_error'] = "Usuario não informado";
		}
	
		if(empty($request['banco'])){
			$l['cod_error'] = "12";
			$l['msg_error'] = "Banco não informado";
		}
		
		if(empty($request['tipo_conta'])){
			$l['cod_error'] = "13";
			$l['msg_error'] = "Informe o tipo de conta";
		}		
		
		if(empty($request['conta'])){
			$l['cod_error'] = "14";
			$l['msg_error'] = "Informe a conta";
		}		
		
		if(empty($request['agencia'])){
			$l['cod_error'] = "15";
			$l['msg_error'] = "Informe a agencia";
		}						
		
		if($l['cod_error'] == ""){
			$l = parent::register_dados_bancarios($request['id_usuario'],$request['banco'],$request['tipo_conta'],$request['conta'],$request['agencia'],$request['pix']);
			$l['msg_success'] = "Cadastro realizado com sucesso";
		}
		
		return $l;
		
	}
	
	static function update_imagem_cartao($img_cartao, $id){
		$l = parent::update_img_cartao($img_cartao, $id);
	}
	
	static function update_img_documento($img_documento, $id){
		$l = parent::update_img_documento($img_documento, $id);
	}	
	
	static function update_img_documento_dados_bancarios($img_documento, $id){
		$l = parent::update_img_documento_dados_bancarios($img_documento, $id);
	}	
	
	static function update_imagem_perfil($img_perfil, $id){
		$l = parent::update_img_perfil($img_perfil, $id);		
	}
	//
	
	static function update_dados_bancarios($request){
		
		$l['cod_error'] = "";
		
		if(empty($request['id_usuario'])){
			$l['cod_error'] = "11";
			$l['msg_error'] = "Usuario não informado";
		}
	
		if(empty($request['banco'])){
			$l['cod_error'] = "12";
			$l['msg_error'] = "Banco não informado";
		}
		
		if(empty($request['tipo_conta'])){
			$l['cod_error'] = "13";
			$l['msg_error'] = "Informe o tipo de conta";
		}		
		
		if(empty($request['conta'])){
			$l['cod_error'] = "14";
			$l['msg_error'] = "Informe a conta";
		}		
		
		if(empty($request['agencia'])){
			$l['cod_error'] = "15";
			$l['msg_error'] = "Informe a agencia";
		}						
		
		if($l['cod_error'] == ""){
			
			$s = parent::select_dados_bancarios_by_id_user($request['id_usuario']);
			if($s['num'] > 0){
				$l = parent::update_dados_bancarios($request['banco'], $request['tipo_conta'], $request['conta'], $request['agencia'], $request['pix'], $request['id_usuario']);
				$l['msg_success'] = "Dados atualizados com sucesso";
				
			}else{
				$l = parent::register_dados_bancarios($request['id_usuario'],$request['banco'], $request['tipo_conta'], $request['conta'], $request['agencia'], $request['pix']);
				$l['msg_success'] = "Cadastro realizado com sucesso";
			}
		}
		
		return $l;
		
	}
	
	
	static function update_perfil_aba_2($email , $senha, $id){
		
		$l['cod_error'] = "";
		if(empty($email)){
			$l['cod_error'] = "31";
			$l['msg_error'] = "Preencha o campo email";
		}
			
		if(!valid_email($email)){
			$l['cod_error'] = "5";
			$l['msg_error'] = "E-mail inválido";
		}
		
		if(empty($senha)){
			$l['cod_error'] = "32";
			$l['msg_error'] = "Preencha o campo senha";
		}
		
		if(strlen($senha) < 7){
			$l['cod_error'] = "33";
			$l['msg_error'] = "Senha inválida";
		}
		
		
		if($l['cod_error'] == ""){
			$l = parent::update_perfil_aba_2($email, $senha, $id);
			$l['msg_success'] = "Cadastro atualizado com sucesso";				
		}	
		
		return $l;
		
	}
	
	static function update_perfil_aba_h_1($nome, $id_time, $id_tipo, $celular, $id){
		$l['cod_error'] = "";
		if(empty($nome)){
			$l['cod_error'] = "31";
			$l['msg_error'] = "Preencha o campo nome";
		}		
		
		$n = explode(" ",$nome);
		if(count($n) < 2){
			$l['cod_error'] = "2.1";
			$l['msg_error'] = "É necessário preencher com nome e sobrenome";
		}		
		
		/* if(empty($cpf)){
			$l['cod_error'] = "32";
			$l['msg_error'] = "Preencha o campo cpf";
		}
		
		if(!validaCPF($cpf)){
			$l['cod_error'] = "8";
			$l['msg_error'] = "CPF inválido";
		}
	
 		$v_us = parent::select_user_by_id($id);		
 		$v_cpf = parent::select_user_cpf($cpf,$id_tipo);		
		if($v_cpf['num'] >0 && $v_us['cpf'] != $cpf){
			$l['cod_error'] = "9";
			$l['msg_error'] = "CPF já cadastrado";
		} */
				
		if(empty($celular)){
			$l['cod_error'] = "33";
			$l['msg_error'] = "Preencha o campo celular";
		}
		
		if($l['cod_error'] == ""){
			$l = parent::update_perfil_aba_1($nome, $id_time, $celular, $id);
			$l['msg_success'] = "Cadastro atualizado com sucesso";			
		}	
		
		return $l;		
	}
	 
	static function select_dados_user_by_id($id){
		$l = parent::select_user_by_id($id);	
		$b = parent::select_dados_bancarios_by_id_user($id);	
		if($l['num'] > 0){
			
			//dados bancarios
			if($b['num'] > 0){
				$l['banco'] 		= $b['banco'];
				$l['tipo_conta'] 	= $b['tipo_conta'];
				$l['conta'] 		= $b['conta'];
				$l['agencia'] 		= $b['agencia'];
				$l['pix'] 			= $b['pix'];
			
			}
			
			//cor
			$l['color_user'] = "0xff80d303";
			if($l['id_time'] != "" && $l['id_time'] != null ){
				$t = parent::select_times_by_id($l['id_time']);				
				if($t['cor'] != "" && $t['cor'] != null ){
					//$l['color_user'] = str_ireplace("#","",$t['cor']);
					$l['color_user'] = str_ireplace("#","0xff",$t['cor']);
				}
			}
			return $l;

		}else{
			$e['cod_error'] = "10";
			$e['msg_error'] = "Usuário não encontrado";
			
			return $e;
		}
		
	}
	
	static function delete_user_by_id($id){	
	
		$l = parent::delete_user($id);
		
	}
	

	
}
?>