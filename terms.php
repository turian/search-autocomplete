<?
require('connect.php');
if (!get_magic_quotes_gpc()) {
	$_GET['t']=addslashes($_GET['t']);
}
$sql="SELECT `Term`,`url` FROM `term` WHERE `term` LIKE '$_GET[t]%' ORDER BY `Ord` LIMIT 5";
$q=$db->query($sql) or dberror($sql);
while ($r=$q->fetch_assoc()) {
	$fl[]=array($r['Term'],$r['url']);
}
echo json_encode($fl);
?>