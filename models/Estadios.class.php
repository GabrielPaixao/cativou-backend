<?php

	
class Estadios extends DB{
		
		
/*=================================================selects======================================================*/
		
		static function select_estadios(){
			
			$n1 = self::getConn()->prepare('SELECT * FROM estadios');
			$n1->execute(array()); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
		
		static function select_all_sector_by_estadio($id_estadio){
			
			$n1 = self::getConn()->prepare('SELECT * FROM setores WHERE id_estadio=?');
			$n1->execute(array($id_estadio)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
	
/*=================================================insert======================================================*/

	
	
/*=================================================update======================================================*/

	
	
}