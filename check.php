<?
require('connect.php');
if (!get_magic_quotes_gpc()) {
	$_GET['t']=addslashes($_GET['t']);
}
$sql="SELECT `url` FROM `term` WHERE `term` = '$_GET[t]' LIMIT 1";
$q=$db->query($sql) or dberror($sql);
if ($q->num_rows==1) {
	$r=$q->fetch_assoc();
	echo $r['url'];
}else{
	echo 'none';
}
?>