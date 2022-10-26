<?php

require_once('./models/DB.class.php');

	class Users extends DB{
	
/*=================================================isset======================================================*/

		static function isset_cpf($cpf){
			
			$n = self::getConn()->prepare('SELECT cpf FROM users WHERE cpf=?');					
			$n->execute(array($cpf));		
			$d['num'] = $n->rowCount();
			return $d;
			
		}
		
		static function isset_email($email){
			$n = self::getConn()->prepare('SELECT email FROM users WHERE email=?');					
			$n->execute(array($email));		
			$d['num'] = $n->rowCount();
			return $d;
		}


/*=================================================selects======================================================*/


	
		static function select_users_for_report(){
			
			if($_SESSION['perfil_logado'] != "1"){ 
				$where = " WHERE institutions_id=".$_SESSION['institutions_id'];
			}else{
				$where="";
			}	
			
			$n1 = self::getConn()->prepare('SELECT * FROM users '.$where);
			$n1->execute(array()); 
			$d['dados'] = $n1->fetchAll();	
			return $d; 
			
		}
	
	
		static function select_profiles(){
			
			if($_SESSION['perfil_logado'] != "1"){ 
				$where = " WHERE id <> 1 ";
			}else{
				$where="";
			}
			
			
			$n1 = self::getConn()->prepare('SELECT * FROM profiles '.$where);
			$n1->execute(array()); 
			$d['dados'] = $n1->fetchAll();	
			return $d; 
			
		}

	
	
		static function select_profile_id($id){
			
			$n1 = self::getConn()->prepare('SELECT * FROM profiles WHERE id=?');
			$n1->execute(array($id));
			$d['dados'] = $n1->fetchAll();
			$d['num'] = $n1->rowCount();		
			return $d;
			
		}
	
		static function select_users_id($id){
			
			$n1 = self::getConn()->prepare('SELECT * FROM users WHERE id=?');
			$n1->execute(array($id));
			$d = $n1->fetchall();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
		}

		static function select_all_users(){
			
			$n1 = self::getConn()->prepare('SELECT * FROM users WHERE cancelado <> 1 order by id desc ');
			$n1->execute(array()); 
			$d['dados'] = $n1->fetchAll();
			$d['num'] = $n1->rowCount();				
			return $d; 
			
		}
	

	
		
		
/*=================================================insert======================================================*/
		
	static function insert_users($name, $email, $cpf, $status,$password,$id_perfil){
			
			$n = self::getConn()->prepare('INSERT INTO `users` SET 
											name=?,
											email=?,
											cpf=?,
											status=?, 
											password=?,		
											id_perfil=?,		
											date_register="'.date("Y-m-d").'"		
										  ');											
			$n->execute(array($name, $email, $cpf, $status,$password,$id_perfil));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_insert');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
			
		}
		
		
		
/*=================================================update======================================================*/
		
		static function update_user($name, $email, $cpf, $status,$password,$id_perfil,$id){
					$n = self::getConn()->prepare('
													UPDATE  `users` SET 
													name=?,
													email=?,
													cpf=?,
													status=?, 
													password=?,		
													id_perfil=?
													WHERE  `id` =? ');
											
					$n->execute(array($name, $email, $cpf, $status,$password,$id_perfil,$id));
		}
	
		static function update_user_status($status,$id){
					$n = self::getConn()->prepare('
													UPDATE  `users` SET 
												   `status` =?
													WHERE  `id` =? ');
											
					$n->execute(array($status,$id));	
		}
		
		static function update_userDel($cancelado,$id){
			$n = self::getConn()->prepare('
											UPDATE  `users` SET 
										   `cancelado` =?
											WHERE  `id` =? ');
									
			$n->execute(array($cancelado,$id));	
}
		
	
/*=================================================delete======================================================*/		
		

		static function delete_user($id){
				$n1 = self::getConn()->prepare('DELETE FROM `users` WHERE id=?');		
				$n1->execute(array($id));	
		}
		
		static function delete_user_by_institutions_id($id){
				$n1 = self::getConn()->prepare('DELETE FROM `users` WHERE institutions_id=?');		
				$n1->execute(array($id));	
		}
		
		
		
}
