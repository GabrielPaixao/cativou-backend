<?php

	
class CadeirasCativas extends DB{
		
		
/*=================================================selects======================================================*/
		
		static function select_all_cadeiras_by_sector($id_setor){
			
			$n1 = self::getConn()->prepare('SELECT * FROM cadeiras_cativas WHERE id_setor=?');
			$n1->execute(array($id_setor)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
		
		static function select_all_cadeiras_by_codigo_cadeira($codigo_cadeira){
			
			$n1 = self::getConn()->prepare('SELECT * FROM cadeiras_cativas WHERE codigo_cadeira=?');
			$n1->execute(array($codigo_cadeira)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
		
		static function select_all_cartoes_by_user($id_user,$id){
			
			$n1 = self::getConn()->prepare('SELECT 
												u.nome as nome,
												u.cpf as cpf,
												c.rampa as rampa, 
												c.bloco as bloco, 
												c.fila as fila, 
												c.cadeira as cadeira, 
												c.codigo_cadeira as codigo_cadeira
											FROM `cadeiras_cativas` c  
											INNER JOIN usuarios u 
											ON (c.id_usuario = u.id)
											WHERE 
												c.id_usuario=? 
												AND c.id IN (SELECT id_cadeira FROM jogo_cadeira WHERE id_usuario=? AND status=1 )');
			$n1->execute(array($id_user,$id)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
		
		static function verifica_cadeira_jogo($id_cadeira, $id_jogo){
			
			$n1 = self::getConn()->prepare('SELECT * FROM jogo_cadeira WHERE id_cadeira=? AND id_jogo=?');
			$n1->execute(array($id_cadeira, $id_jogo)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
		
		static function select_jogo_cadeira_by_id_jogo_and_id_user($id_jogo,$id_user){
			
			$n1 = self::getConn()->prepare('SELECT 
												*
											FROM `jogo_cadeira` 
											WHERE 
												id_jogo=? AND
												id_usuario=?
												
											');
			$n1->execute(array($id_jogo,$id_user)); 
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
		}
	
	
/*=================================================insert======================================================*/

	static function register_cadeira_cativa_bd($id_usuario,$id_estadio,$id_setor,$rampa,$bloco,$fila,$cadeira,$codigo_cadeira){
			
			$n = self::getConn()->prepare('INSERT INTO `cadeiras_cativas` SET 
											id_usuario=?,
											id_estadio=?,
											id_setor=?,
											rampa=?,
											bloco=?,
											fila=?,
											cadeira=?,
											codigo_cadeira=?,											
											disponibilizada="0"		
										  ');											
			$n->execute(array($id_usuario,$id_estadio,$id_setor,$rampa,$bloco,$fila,$cadeira,$codigo_cadeira));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_cadeira');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
	}
	
	static function register_cadeira_cativa_jogo($id_cadeira,$id_jogo,$status){
			
			$n = self::getConn()->prepare('INSERT INTO `jogo_cadeira` SET 
											id_cadeira=?,
											id_jogo=?,
											status=?
										  ');											
			$n->execute(array($id_cadeira,$id_jogo,$status));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_insert');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
	}
	
	
/*=================================================update======================================================*/
	static function update_imagem($imagem, $id){
			$n = self::getConn()->prepare('
											UPDATE  `cadeiras_cativas` SET 
										   `imagem` =?
											WHERE  `id` =? ');
									
			$n->execute(array($imagem, $id));
	}
	
	static function update_cadeira_cativa_jogo($status,$id_cadeira,$id_jogo){
			$n = self::getConn()->prepare('
											UPDATE  `jogo_cadeira` SET 
												`status` =?
											WHERE  
												`id_cadeira` =? AND `id_jogo` =? 
											');
									
			$n->execute(array($status,$id_cadeira,$id_jogo));
	}
	
	
}