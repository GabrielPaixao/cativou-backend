<?php
error_reporting(E_ERROR);
ini_set("display_errors", 0);
  session_start(); 
if(isset($_GET['lang'])){
	
	$_SESSION['lang'] = $_GET['lang'];
	
}elseif(!isset($_SESSION['lang'])){

	$_SESSION['lang'] = "eng";

}

//session_name(md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));

if(!isset($_SESSION['id_logado'])){
	
	echo'<script language= "JavaScript">location.href="login"</script>';
	
}	

if($_SESSION['first_acess'] == "1"){
	
	echo'<script language= "JavaScript">location.href="first_acess"</script>';
	
}	

if((isset($_SESSION['project_fi']) && $_SESSION['project_fi'] == 0) || $_SESSION['perfil_logado'] == 4){
	$readonly = "readonly";
}else{ 
	$readonly = "";
}		

include("./functions.php");
include("./translate.php");
include("./models/DB.class.php");
include("./controllers/Vendas.class.php");

//include("./controllers/ADM_Institutions.class.php");
include("./controllers/ADM_Users.class.php");
include("./controllers/ADM_Projects.class.php");
include("./controllers/EC_Documents.class.php");
include("./controllers/IR_Risks.class.php");
include("./controllers/IR_Agents.class.php");
include("./controllers/AR_Analyse_risks.class.php");
include("./controllers/EC_Enter_values.class.php");
include("./controllers/EC_Build_value_pie.class.php");
include("./controllers/EC_Select_values.class.php");
include("./controllers/TR_Analyze_options.class.php");
include("./controllers/Access.class.php");


/*
function __autoload($className){
	
	 //Carrega models
	 if(file_exists("./models/".$className.".class.php")){
          include("./models/".$className.".class.php"); 
     }
	 
	 //Carrega controllers
     if(file_exists("./controllers/".$className.".class.php")){
          include("./controllers/".$className.".class.php"); 
     }
} */

?>