<?php
require("../models/Campeonatos.class.php");


class Campeonato extends Campeonatos{
	
		static function select_all_times(){
			$l = parent::select_all_times();	
			if($l['num'] > 0){			
				return $l;
			}			
		}
		
		static function select_all_jogos_estadio($id_estadio){
			$l = parent::select_jogos($id_estadio);	
			if($l['num'] > 0){	
					
				return $l;
			}			
		}
		
		static function select_jogo_by_id($id_jogo){
			$l = parent::select_jogo_by_id($id_jogo);	
			if($l['num'] > 0){			
				return $l;
			}			
		}
	
}
?>