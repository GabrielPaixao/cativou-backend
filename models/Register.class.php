<?php

	
class Register extends DB{
		
		
/*=================================================selects======================================================*/
		
	static function select_user_cpf($cpf,$id_tipo){
			
			$n1 = self::getConn()->prepare('SELECT cpf FROM usuarios WHERE cpf=? AND id_tipo=?');
			$n1->execute(array($cpf,$id_tipo));
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
	}

	static function select_user_email($email){
			
			$n1 = self::getConn()->prepare('SELECT email FROM usuarios WHERE email=?');
			$n1->execute(array($email));
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
	}
	
	static function select_user_by_id($id){
			
			$n1 = self::getConn()->prepare('SELECT * FROM usuarios WHERE id =?');
			$n1->execute(array($id));
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
	}
	static function select_dados_bancarios_by_id_user($id_usuario){
			
			$n1 = self::getConn()->prepare('SELECT * FROM dados_bancarios WHERE id_usuario =?');
			$n1->execute(array($id_usuario));
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
	}
		
	static function select_times_by_id($id){
									
			$n1 = self::getConn()->prepare('SELECT * FROM times WHERE id=?');
			$n1->execute(array($id)); 
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
		}
		
	static function select_all_banks(){
			
			$n1 = self::getConn()->prepare('SELECT * FROM bancos');
			$n1->execute(array()); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
	}
	
/*=================================================insert======================================================*/

	static function register_user($id_time,$id_tipo,$nome,$email,$cpf,$celular,$endereco,$senha,$img_cartao,$img_documento,$img_perfil,$token_facebook,$token_google){
			
			$n = self::getConn()->prepare('INSERT INTO `usuarios` SET 
											id_time=?,
											id_tipo=?,
											nome=?,
											email=?,
											cpf=?,
											celular=?,
											endereco=?,
											senha=?,
											img_cartao=?,
											img_documento=?,
											img_perfil=?,
											token_facebook=?,
											token_google=?,
											ativo=0,		
											data_cadastro="'.date("Y-m-d").'"		
										  ');											
			$n->execute(array($id_time,$id_tipo,$nome,$email,$cpf,$celular,$endereco,$senha,$img_cartao,$img_documento,$img_perfil,$token_facebook,$token_google));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_insert');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
	}
	
	public function register_user_by_google($id_tipo,$nome,$email,$token_google,$img_perfil,$cpf="",$celular=""){
			
			$n = self::getConn()->prepare('INSERT INTO `usuarios` SET 
											id_tipo=?,
											nome=?,
											email=?,
											token_google=?,
											img_perfil=?,
											cpf=?,
											celular=?,	
											ativo=1,		
											data_cadastro="'.date("Y-m-d").'"		
										  ');											
			$n->execute(array($id_tipo,$nome,$email,$token_google,$img_perfil,$cpf="",$celular=""));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_insert');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
	}
	
	static function register_user_by_facebook2($id_tipo,$nome,$email,$token_facebook,$img_perfil,$cpf="",$celular=""){
			
			$n = self::getConn()->prepare('INSERT INTO `usuarios` SET 
											id_tipo=?,
											nome=?,
											email=?,
											token_facebook=?,
											img_perfil=?,
											cpf=?,
											celular=?,	
											ativo=1,		
											data_cadastro="'.date("Y-m-d").'"		
										  ');											
			$n->execute(array($id_tipo,$nome,$email,$token_facebook,$img_perfil,$cpf="",$celular=""));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_insert');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
	}
	
	static function register_dados_bancarios($id_usuario,$banco,$tipo_conta,$conta,$agencia,$pix){
			
			$n = self::getConn()->prepare('INSERT INTO `dados_bancarios` SET 
											id_usuario=?,
											banco=?,
											tipo_conta=?,
											conta=?,
											agencia=?,
											pix=?,	
											data_cadastro="'.date("Y-m-d").'"		
										  ');											
			$n->execute(array($id_usuario,$banco,$tipo_conta,$conta,$agencia,$pix));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_insert');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
	}
	
/*=================================================update======================================================*/

	static function update_dados_bancarios($banco, $tipo_conta, $conta, $agencia, $pix, $id_usuario){
					$n = self::getConn()->prepare('
													UPDATE  `dados_bancarios` SET
														banco=?,
														tipo_conta=?,
														conta=?,
														agencia=?,
														pix=?
													WHERE  `id_usuario` =? ');
											
					$n->execute(array($banco, $tipo_conta, $conta, $agencia, $pix, $id_usuario));
	}
	
	static function update_img_cartao($img_cartao, $id){
					$n = self::getConn()->prepare('
													UPDATE  `cadeiras_cativas` SET 
												   `imagem` =?
													WHERE  `id` =? ');
											
					$n->execute(array($img_cartao, $id));
	}
	
	static function update_img_documento($img_documento, $id){
					$n = self::getConn()->prepare('
													UPDATE  `usuarios` SET 
												   `img_documento` =?
													WHERE  `id` =? ');
											
					$n->execute(array($img_documento, $id));
	}
	
	static function update_img_documento_dados_bancarios($img_documento, $id){
					$n = self::getConn()->prepare('
													UPDATE  `usuarios` SET 
												   `img_documento` =?
													WHERE  `id` =? ');
											
					$n->execute(array($img_documento, $id));
	}
	
	static function update_img_perfil($img_perfil, $id){
					$n = self::getConn()->prepare('
													UPDATE  `usuarios` SET 
												   `img_perfil` =?
													WHERE  `id` =? ');
											
					$n->execute(array($img_perfil, $id));
	}
	
	static function update_perfil_aba_1($nome, $id_time="", $celular, $id){
					$n = self::getConn()->prepare('
													UPDATE  `usuarios` SET 
												   `nome` =?,
												   `id_time` =?,
												   
												   `celular` =?
													WHERE  `id` =? ');
											
					$n->execute(array($nome, $id_time, $celular, $id));
	}
	
	static function update_perfil_aba_2($email , $senha="", $id){
		
					if($senha==""){
						$where =",
												   `senha` ='".sha1($senha)."'";
					}
			
					$n = self::getConn()->prepare('
													UPDATE  `usuarios` SET 
												   `email` =?
												   '.$where.'
													WHERE  `id` =? ');
											
					$n->execute(array($email , $id));
	}
	
	static function delete_user($id){
			$n1 = self::getConn()->prepare('DELETE FROM `usuarios` WHERE id=?');		
			$n1->execute(array($id));	
	}
	
}