<?
if (!file_exists('con_data.php')) {
	die();
}
require 'con_data.php';
$con_data=unserialize($scon_data);
$db = new mysqli($con_data['host'], $con_data['user'], $con_data['password'], $con_data['dbname']) or die ('I cannot connect to the database because: ' . mysqli_connect_error);
function dberror($sql){
	global $db;
	die('There is an error: ' . $db->error . '<br/>in following sql:<br/>'.$sql);
}
