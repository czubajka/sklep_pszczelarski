<?php
	$host = "localhost";
	$db_user = "root";
	$db_password = "";
	$db_name = "pasieka";	
	
function polacz()
{
	$host = "localhost";
	$db_user = "root";
	$db_password = "";
	$db_name = "pasieka";
	$connection = new mysqli($host, $db_user, $db_password, $db_name);	
	$connection->set_charset("utf8");	
	return $connection;
}

	
?>