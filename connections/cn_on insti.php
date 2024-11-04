<?php
$hostname = "localhost";
$database = "caja";
$username = "root";
$password = "";
$link = mysql_connect($hostname, $username, $password);
mysql_select_db($database, $link);
mysql_query("SET NAMES 'utf8'");
?>