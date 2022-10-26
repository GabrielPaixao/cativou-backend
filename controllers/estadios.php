<?php
require("../models/Estadios.class.php");


class Estadio extends Estadios{
	
	
	static function select_all_estadios(){
		$l = parent::select_estadios();	
		if($l['num'] > 0){			
			return $l;
		}
	}
		
	static function select_all_sector_by_estadio($id_estadio){
		$l = parent::select_all_sector_by_estadio($id_estadio);	
		if($l['num'] > 0){			
			return $l;
		}
	}
	
}
?>