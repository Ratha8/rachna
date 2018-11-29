<?php
function getConnection(){
	$servername = "localhost";
	$username = "id1777290_rachna_db";
	$password = "admin";
	$dbname = "id1777290_root"; 
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