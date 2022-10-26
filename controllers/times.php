<?php
require("../models/Times.class.php");


class Clubes extends Times{
	
	
	static function select_all_clubes(){
		$l = parent::select_all_times();	
		if($l['num'] > 0){
			//$l['dados']['sid'] = "s".$l['id'];
			return $l;

		}
		
	}
	
}
?>