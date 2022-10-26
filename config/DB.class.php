<?php

	class DB{  
		private static $conn;
		static function getConn(){
			if(is_null(self::$conn)){
				self::$conn = new PDO("mysql:host=localhost;dbname=gmpxcom_cativou","gmpxcom_cativou","1q2w3e!@#");
				self::$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			}
			return self::$conn;			
		} 
	}
	
?>