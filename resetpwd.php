<?php
define('SYSTEM_ROOT', dirname(__FILE__));
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="charset" content="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>贴吧云签到密码重置工具</title>
</head>
<body>
<?php
	if(!empty($_POST['name']) && !empty($_POST['pw'])) {
		$result = '失败，未知错误';
		if(!file_exists('config.php') || !file_exists(SYSTEM_ROOT.'/lib/class.S.php')) {
			$result = '找不到 config.php 或 /lib/class.S.php，请检查将本文件放到了云签到根目录';
		} else {
			require 'config.php';
			try {
				require SYSTEM_ROOT.'/lib/mysql_autoload.php';
				global $m;
				$sql = "UPDATE `".DB_PREFIX."users` SET `pw`='" . md5(md5(md5($_POST['pw']))) . "' WHERE (`name`='" . addslashes($_POST['name']) . "')";
				$r = $m->query($sql);
				if(empty($r)) {
					$result = '更改密码失败，查询出错，请手动运行该SQL语句：<br/>' . $sql;
				} else {
					$result = '已更改密码：' . $_POST['name'] . '<br/>影响了 '.$r.' 行';
				}
			} catch(Exception $ex) {
				$result = $ex->getMessage();
			}
		}
		?>
		<fieldset>
			<legend>操作结果</legend>
			<?php echo $result ?>
		</fieldset>
		<br/>
		<?php
	}
?>
<fieldset>
    <legend>更改云签到密码</legend>
    <form method="post">
		<p><label>名称 <input type="text" name="name" required></label></p>
		<p><label>密码 <input type="password" name="pw" required></label></p>
		<p><input type="submit"></p>
    </form>
</fieldset>
<br/>
<fieldset>
	<legend>警告</legend>
	<p>将本文件放到云签到根目录</p>
	<p>用完立即删除，因为任何人都可以使用本工具更改你的密码</p>
	<p>贴吧云签到密码重置工具 版本 V2.1</p>
	<p><a href="https://zhizhe8.net" target="_blank">Kenvix</a> @ <a href="http://www.stus8.com/" target="_blank">StusGame GROUP</a></p>
</fieldset>
</body>
</html>