<?php
use infrajs\router\Router;
use infrajs\ans\Ans;
use infrajs\config\Config;
use infrajs\access\Access;
use infrajs\load\Load;
use infrajs\nostore\Nostore;

if (!is_file('vendor/autoload.php')) {
	chdir('../../../');
	require_once('vendor/autoload.php');
	Router::init();
}

$action = Ans::GET('-tester');
if ($action == 'true') {
	Nostore::on();
	if (Access::test()) {
		$ans = Load::loadJSON('-tester/?type=auto');
		if (!$ans || !$ans['result']) {
			error_log('TESTER: There are errors in the tests /-tester/?type=errors '.$ans['msg']);
			if (Access::debug()) die('TESTER: There are errors in the tests <a href="/-tester/?type=errors">errors</a> <b>'.$ans['msg'].'</b>');
		} else {
			echo '<div class="well"><a href="/-tester/">Тестирование</a> выполнено, ошибок не обнаружено.</div>';
		}
	} else {
		$ans = array();
		die('<div class="alert alert-danger">Недостаточно прав для тестирования.</div>');
	}
}
