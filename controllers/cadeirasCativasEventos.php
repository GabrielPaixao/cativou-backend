<?php
require("../models/CadeirasCativasEventos.class.php");


class CadeiraCativaEvento extends CadeirasCativasEventos{
	
	
	static function atuliza_status_cadeira_evento($id_cadeira, $id_evento,$status){
		$v = parent::verifica_cadeira_evento($id_cadeira, $id_jogo);	
		if($v['num'] > 0){			
			$a = parent::update_cadeira_cativa_evento($status,$id_cadeira,$id_evento);
			$l['msg_success'] = "Cadeira atualizada com sucesso";
		}else{
			$a = parent::register_cadeira_cativa_evento($id_cadeira,$id_evento,$status);
			$l['msg_success'] = "Cadeira atualizada com sucesso";
		}
		return $l;
	}
	
	static function select_all_cartoes_by_user($id_user,$id){
		$l = parent::select_all_cartoes_by_user($id_user,$id);	
		if($l['num'] > 0){			
			return $l;
		}
	}
	
	
	static function select_eventos_cadeira_by_id_evento_and_id_user($id_evento,$id_user){
		$l = parent::select_eventos_cadeira_by_id_evento_and_id_user($id_evento,$id_user);	
		if($l['num'] > 0){	
			if($l['status'] == "0"){
				$l['cod_status'] = "0";
				$l['status'] 	= "disponível";
			}
			if($l['status'] == "1"){
				$l['cod_status'] = "1";
				$l['status'] 	= "reservada";
			}
		}else{
				$l['cod_status'] = "2";
				$l['status'] 	= "não definido";
		}
		return  $l;
	}	
	
	
}
?>