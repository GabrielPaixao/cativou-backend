<?php
require("../models/Eventos.class.php");


class Evento extends Eventos{
	
	
	static function select_all_eventos(){
		$l = parent::select_eventos();	
		if($l['num'] > 0){			
			return $l;
		}
	}
		
	static function select_eventos_by_id($id){
		$l = parent::select_eventos_by_id($id);	
		if($l['num'] > 0){			
			return $l;
		}
	}
	
}
?>