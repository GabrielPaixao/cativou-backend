<?php

	class Projects extends DB{
	
/*=================================================isset======================================================*/

		static function isset_projects(){
			
		

		}

/*=================================================selects======================================================*/




		static function select_projects_for_report(){
			
			$n1 = self::getConn()->prepare('SELECT * FROM projects WHERE institutions_id="'.$_SESSION['institutions_id'].'" AND deleted <> 1');
			$n1->execute(array()); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
	
		static function select_projects_for_report_id($id){
			
			$n1 = self::getConn()->prepare('SELECT * FROM projects WHERE institutions_id=? AND deleted <> 1');
			$n1->execute(array($id)); 
			$d['dados'] = $n1->fetchAll();	
			$d['num'] = $n1->rowCount();
			return $d; 
			
		}
	
		static function select_projects_for_report_super(){
			
			$n1 = self::getConn()->prepare('SELECT * FROM projects WHERE deleted <> 1');
			$n1->execute(array()); 
			$d['dados'] = $n1->fetchAll();	
			return $d; 
			
		}
	
		static function select_project_id($id){
			
			$n1 = self::getConn()->prepare('SELECT * FROM projects WHERE id=?  AND deleted <> 1');
			$n1->execute(array($id));
			$d = $n1->fetch();	
			$d['num'] = $n1->rowCount();	
			return $d;
			
		}
	
		
		
/*=================================================insert======================================================*/
		
		static function insert_project($institutions_id,$project,$note,$time_horizon,$project_type){
			
			$n = self::getConn()->prepare('INSERT INTO `projects` SET 
											institutions_id=?,
											project=?,
											note=?,
											time_horizon=?,
											project_type=?,
											status=1,		
											date_register="'.date("Y-m-d").'"		
										  ');											
			$n->execute(array($institutions_id,$project,$note,$time_horizon,$project_type));
			
			$id = self::getConn()->prepare('SELECT LAST_INSERT_ID() as id_last_insert');	
			$id->execute(array());
			$r = $id->fetch();
			return $r;
			
		}
		
		
		
/*=================================================update======================================================*/
		
		static function update_project($institutions_id, $project, $note, $time_horizon, $project_type, $id){
					$n = self::getConn()->prepare('
													UPDATE  `projects` SET 
												   `institutions_id` =?,
												   `project` =?,
												   `note` =?,
												   `time_horizon` =?,
												   `project_type` =?
													WHERE  `id` =? ');
											
					$n->execute(array($institutions_id, $project, $note, $time_horizon, $project_type, $id));
		}
	
		static function update_project_status($status,$id){
					$n = self::getConn()->prepare('
													UPDATE  `projects` SET 
												   `status` =?
													WHERE  `id` =? ');
											
					$n->execute(array($status,$id));	
		}
	
/*=================================================delete======================================================*/		
		
		static function delete_project($id){
				$n = self::getConn()->prepare('
													UPDATE  `projects` SET 
												   `deleted` =1
													WHERE  `id` =? ');
											
					$n->execute(array($id));	
		}
		
		static function delete_project_by_institutions_id($id){
				$n = self::getConn()->prepare('
													DELETE FROM `projects` 
													WHERE  `institutions_id` =? ');
											
					$n->execute(array($id));	
		}
		
		
		static function delete_system_by_project_id($id){
				$n = self::getConn()->prepare('
												DELETE FROM `ar_analyze_risks` WHERE  `id_project` ='.$id.';
												DELETE FROM `ar_magnitudes_risk` WHERE  `project_id` ='.$id.';
												DELETE FROM `ar_zoom_list_items_affected` WHERE  `project_id` ='.$id.';
												DELETE FROM `ar_zoom_list_items_affected_o` WHERE  `project_id` ='.$id.';
												DELETE FROM `ec_groups_value` WHERE  `project_id` ='.$id.';
												DELETE FROM `ec_mixed_values` WHERE  `project_id` ='.$id.';
												DELETE FROM `ec_subgroups_value` WHERE  `project_id` ='.$id.';
												DELETE FROM `ec_values_scale` WHERE  `project_id` ='.$id.';
												DELETE FROM `ec_value_pie_table` WHERE  `project_id` ='.$id.';
												DELETE FROM `tr_analyze_options` WHERE  `id_project` ='.$id.';
												DELETE FROM `tr_options` WHERE  `project_id` ='.$id.';
												
												
												');
											
					$n->execute(array());	
		}
		
		
		
		
		
}

?>