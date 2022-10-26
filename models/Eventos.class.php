<?php

	
class Eventos extends DB{
		
		
/*=================================================selects======================================================*/
		
		static function select_eventos(){
			
			$n1 = self::getConn()->prepare('SELECT * FROM eventos WHERE data > CURDATE()');
			$n1->execute(array()); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
		
		static function select_eventos_by_id($id){
			
			$n1 = self::getConn()->prepare('SELECT * FROM eventos WHERE id=? ');
			$n1->execute(array($id)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
	
/*=================================================insert======================================================*/

	
	
/*=================================================update======================================================*/

	
	
}