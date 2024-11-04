<?php
$db_host = "localhost";
$db_name = "caja";
$db_user = "root";
$db_password = "DBt3s0r0";
try
{
	$db=new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_password);
        $db->exec("set names utf8mb4");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOEXCEPTION $e)
{
	$e->getMessage();
}

?>