<?php
	use infrajs\load\Load;
	use infrajs\access\Access;
	use infrajs\event\Event;
	use infrajs\config\Config;
	use infrajs\update\Update;
	
	$conf = Config::get('tester');
	if ($conf['updatetest'] && Access::debug()) {
		Update::exec(); //Это отодвинет update testerа в конец очереди
		$ans = Load::loadJSON('-tester/?type=auto');
		if (!$ans || !$ans['result']) {
			echo '<div class="alert alert-danger"><a href="/-tester/?type=errors">Тестирование</a> выполнено с ошибками.</div>';
			error_log('TESTER: There are errors in the tests /-tester/?type=errors '.$ans['msg']);
			//if (Access::debug()) die('TESTER: There are errors in the tests <a href="/-tester/?type=errors">errors</a> <b>'.$ans['msg'].'</b>');
		} else {
			echo '<div class="well">С обновлением выполнено <a href="/-tester/">тестирование</a>, ошибок не обнаружено</div>';
		}
	}

?>