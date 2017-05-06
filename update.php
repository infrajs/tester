<?php
use infrajs\load\Load;
use infrajs\access\Access;
use infrajs\event\Event;
use infrajs\config\Config;
use infrajs\update\Update;

$conf = Config::get('tester');
if ($conf['updatetest'] && Access::test()) {
	Update::exec(); //Это отодвинет update testerа в конец очереди
	$ans = Load::loadJSON('-tester/?type=auto');
	if (!$ans || !$ans['result']) {
		error_log('TESTER: При обновлении найдены ошибки /-tester/?type=errors '.$ans['msg']);
	} else {
		error_log('TESTER: При обновлении ошибок не найдено /-tester/');
	}
}