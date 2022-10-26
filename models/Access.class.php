<?php
	
class Access extends DB{
		

	static function login($login, $senha){
		$n1 = self::getConn()->prepare('SELECT id, id_time as time,  nome, id_tipo, email, endereco, img_perfil, img_cartao, img_documento, token_facebook, token_google FROM usuarios WHERE email=? and senha=? and ativo=1');		
		
		$n1->execute(array($login, $senha));
		$d = $n1->fetch();		
		$d['num'] = $n1->rowCount();
		return $d;
	}
	
	static function login_by_google($token_google){
		$n1 = self::getConn()->prepare('SELECT id, id_time as time,  nome, id_tipo, email, endereco, img_perfil, img_cartao, img_documento, token_facebook, token_google FROM usuarios WHERE token_google=? and ativo=1');		
		
		$n1->execute(array($token_google));
		$d = $n1->fetch();		
		$d['num'] = $n1->rowCount();
		return $d;
	}
	
	static function login_by_facebook($token_facebook){
		$n1 = self::getConn()->prepare('SELECT id, id_time as time,  nome, id_tipo, email, endereco, img_perfil, img_cartao, img_documento, token_facebook, token_google FROM usuarios WHERE token_facebook=? and ativo=1');		
		
		$n1->execute(array($token_facebook));
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
		

	
	
}