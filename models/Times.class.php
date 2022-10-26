<?php

	 
class Times extends DB{
		
		
/*=================================================selects======================================================*/
		

	static function select_user_email($email){
			
			$n1 = self::getConn()->prepare('SELECT email FROM usuarios WHERE email=?');
			$n1->execute(array($email));
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
	}
	
	static function select_all_times(){
			
			$n1 = self::getConn()->prepare('SELECT * FROM times');
			$n1->execute(array($id)); 
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
											ativo=1,		
											data_cadastro="'.date("Y-m-d").'"		
										  ');											
			$n->execute(array($id_time,$id_tipo,$nome,$email,$cpf,$celular,$endereco,$senha,$img_cartao,$img_documento,$img_perfil,$token_facebook,$token_google));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_insert');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
	}
	
/*=================================================update======================================================*/

	static function update_img_cartao($img_cartao, $id){
					$n = self::getConn()->prepare('
													UPDATE  `usuarios` SET 
												   `img_cartao` =?
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
	static function update_img_perfil($img_perfil, $id){
					$n = self::getConn()->prepare('
													UPDATE  `usuarios` SET 
												   `img_perfil` =?
													WHERE  `id` =? ');
											
					$n->execute(array($img_perfil, $id));
	}
	
}