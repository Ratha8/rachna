<?php
function getConnection(){
	$servername = "localhost";
	$username = "root";
	$password = "";
	// $dbname = "db_ricsmsorg";
	$dbname = "rachna_db"; 
	try{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname",$username,$password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conn->exec("SET NAMES utf8");
		return $conn; 
	}catch(PDOException $e){
		echo "Connect to database fail " . $e->getMessage();
	}
}
?>