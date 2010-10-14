<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1250" />
	<title>Installation</title>
</head>
<h1>Installation</h1>
<body>
	<?
	if (isset($_POST['dbname'])) {
		if (empty($_POST['dbhost']) or empty($_POST['dbname']) or empty($_POST['dbuname']) or empty($_POST['dbpwd'])) {
			$err='Please fill all fields';
		}else {
			$con_data=array('dbname'=>$_POST['dbname'],'host'=>$_POST['dbhost'],'user'=>$_POST['dbuname'],'password'=>$_POST['dbpwd']);
			$db = new mysqli($con_data['host'], $con_data['user'], $con_data['password'], $con_data['dbname']);
			if ($db->connect_error) {
				$err='I cannot connect to the database because: ' . $db->connect_error . '. Please check connection settings and try again.';
			}else {
				if(!$db->query('CREATE TABLE `term` (
  `Term` varchar(255) NOT NULL,
  `Ord` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY  (`Term`)
)')){
					$err=$db->error;
				}else{
					$a=file('terms.txt',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
					$sql='INSERT INTO `term` VALUES (?,?,?)';
					$stm=$db->prepare($sql) or dberror($sql);
					$stm->bind_param('sis',$term,$ord,$url);
					foreach ($a as $ord=>$rest) {
						$at=explode(' ',$rest,2);
						$url=$at[0];
						$term=$at[1];
						$stm->execute();
					}
					$stm->close();
					$scon_data="<?\$scon_data='".serialize($con_data)."'?>";
					file_put_contents('con_data.php',$scon_data);
					if(file_exists('con_data.php')){
						unlink('install.php');
						unlink('terms.txt');
					}
				}
			}
		}
		if ($err) {
			echo $err;
		}else {
			echo 'Installation completed.';
		}
	}else{
		?>
		<h3>Please provide following information</h3>
		<form method="post">
			<table align="center" style="margin-top:100px">
				<tr>
					<td>Database name</td>
					<td><input name="dbname"></td>
				</tr>
				<tr>
					<td>Database host</td>
					<td><input name="dbhost" value="localhost"></td>
				</tr>
				<tr>
					<td>Database user name</td>
					<td><input name="dbuname"></td>
				</tr>
				<tr>
					<td>Database user password</td>
					<td><input name="dbpwd"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit"></td>
				</tr>
			</table>
		</form>
		<?
	}
	?>
</body>
</html>