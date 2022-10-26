<?php

	
class CadeirasCativasEventos extends DB{
		
		
/*=================================================selects======================================================*/
		
		static function select_all_cadeiras_by_sector($id_setor){
			
			$n1 = self::getConn()->prepare('SELECT * FROM cadeiras_cativas WHERE id_setor=?');
			$n1->execute(array($id_setor)); 
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
												AND c.id IN (SELECT id_cadeira FROM eventos_cadeira WHERE id_usuario=? AND status=1 )');
			$n1->execute(array($id_user,$id)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
		
		
		static function verifica_cadeira_evento($id_cadeira, $id_evento){
			
			$n1 = self::getConn()->prepare('SELECT * FROM eventos_cadeira WHERE id_cadeira=? AND id_evento=?');
			$n1->execute(array($id_cadeira, $id_evento)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
		
		
		static function select_eventos_cadeira_by_id_evento_and_id_user($id_evento,$id_user){
			
			$n1 = self::getConn()->prepare('SELECT 
												*
											FROM `eventos_cadeira` 
											WHERE 
												id_evento=? AND
												id_usuario=?
												
											');
			$n1->execute(array($id_evento,$id_user)); 
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
		}
	
	
	
/*=================================================insert======================================================*/

		
	static function register_cadeira_cativa_evento($id_cadeira,$id_evento,$status){
			
			$n = self::getConn()->prepare('INSERT INTO `eventos_cadeira` SET 
											id_cadeira=?,
											id_evento=?,
											status=?
										  ');											
			$n->execute(array($id_cadeira,$id_evento,$status));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_insert');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
	}
	
	
/*=================================================update======================================================*/

	
	static function update_cadeira_cativa_evento($status,$id_cadeira,$id_evento){
			$n = self::getConn()->prepare('
											UPDATE  `eventos_cadeira` SET 
												`status` =?
											WHERE  
												`id_cadeira` =? AND `id_evento` =? 
											');
									
			$n->execute(array($status,$id_cadeira,$id_jogo));
	}
	
	
}