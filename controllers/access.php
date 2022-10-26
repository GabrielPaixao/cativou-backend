<?php
require("../models/Access.class.php");

class Login extends Access{
	
	static function login_usuer($login, $senha){	
	
		$l = parent::login($login, sha1($senha));
		if($l['num']>0){
			$l['token_jwt'] = md5(uniqid(rand(), true));
			$l['sid'] = (string)"s".$l['id'];
			
			//cor
			$l['color_user'] = "0xff80d303";
			if($l['time'] != "" && $l['time'] != null ){
				$t = parent::select_times_by_id($l['time']);				
				if($t['cor'] != "" && $t['cor'] != null ){
					//$l['color_user'] = str_ireplace("#","",$t['cor']);
					$l['color_user'] = str_ireplace("#","0xff",$t['cor']);
				}
			}
			
			return $l;
		}else{
			$l['cod_error'] = "1";
			$l['msg_error'] = "Login ou senha incorretos";
			return $l;
		}
	}
	
	static function login_usuer_by_google($token_google){	
	
		$l = parent::login_by_google($token_google);
		if($l['num']>0){
			$l['token_jwt'] = md5(uniqid(rand(), true));
			$l['sid'] = (string)"s".$l['id'];
			
			//cor
			$l['color_user'] = "0xff80d303";
			if($l['time'] != "" && $l['time'] != null ){
				$t = parent::select_times_by_id($l['time']);				
				if($t['cor'] != "" && $t['cor'] != null ){
					//$l['color_user'] = str_ireplace("#","",$t['cor']);
					$l['color_user'] = str_ireplace("#","0xff",$t['cor']);
				}
			}
			
			return $l;
		}else{
			$l['cod_error'] = "1";
			$l['msg_error'] = "Token google inválido";
			return $l;
		}
	}
	
	static function login_usuer_by_facebook($token_facebook){	
	
		$l = parent::login_by_facebook($token_facebook);
		if($l['num']>0){
			$l['token_jwt'] = md5(uniqid(rand(), true));
			$l['sid'] = (string)"s".$l['id'];
			
			//cor
			$l['color_user'] = "0xff80d303";
			if($l['time'] != "" && $l['time'] != null ){
				$t = parent::select_times_by_id($l['time']);				
				if($t['cor'] != "" && $t['cor'] != null ){
					//$l['color_user'] = str_ireplace("#","",$t['cor']);
					$l['color_user'] = str_ireplace("#","0xff",$t['cor']);
				}
			}
			
			return $l;
		}else{
			$l['cod_error'] = "1";
			$l['msg_error'] = "Token facebook inválido";
			return $l;
		}
	}	
	static function delete_user_by_id($id){	
	
		$l = parent::delete_user($id);
		
	}
	
}
?>