<?php

	
class Campeonatos extends DB{
		
		
/*=================================================selects======================================================*/
		
	static function select_all_times(){
			
			$n1 = self::getConn()->prepare('SELECT 
												*
											FROM `times` ');
			$n1->execute(array()); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
	static function select_jogos($id_estadio){
			
			$n1 = self::getConn()->prepare('SELECT 
												j.id as id_jogo,
												c.nome as campeonato,
												t1.time as time_casa,
												t1.escudo as escudo_casa,
												t2.time as time_visitante,
												t2.escudo as escudo_visitante,
												r.rodada as rodada,
												j.data as data,
												j.hora as hora
											FROM `jogos` as j 
												LEFT JOIN times as t1 
													ON (j.id_time_casa = t1.id)
												LEFT JOIN times as t2 
													ON (j.id_time_visitante = t2.id)
												LEFT JOIN campeonatos as c 
													ON (j.id_campeonato = c.id)
												LEFT JOIN rodadas as r 
													ON (j.id_rodada = r.id)
											WHERE 
												j.id_estadio=?
												AND j.data > CURDATE()
											ORDER BY j.data, j.hora ASC');
			$n1->execute(array($id_estadio)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
		
	static function select_jogo_by_id($id_jogo){
			
			$n1 = self::getConn()->prepare('SELECT 
												j.id as id_jogo,
												c.nome as campeonato,
												t1.time as time_casa,
												t1.escudo as escudo_casa,
												t2.time as time_visitante,
												t2.escudo as escudo_visitante,
												r.rodada as rodada,
												j.data as data,
												j.hora as hora
											FROM `jogos` as j 
												LEFT JOIN times as t1 
													ON (j.id_time_casa = t1.id)
												LEFT JOIN times as t2 
													ON (j.id_time_visitante = t2.id)
												LEFT JOIN campeonatos as c 
													ON (j.id_campeonato = c.id)
												LEFT JOIN rodadas as r 
													ON (j.id_rodada = r.id)
											WHERE 
												j.id=?
												
											ORDER BY j.data, j.hora ASC');
			$n1->execute(array($id_jogo)); 
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
		}
	
	
/*=================================================insert======================================================*/

	
	
/*=================================================update======================================================*/

	
	
}