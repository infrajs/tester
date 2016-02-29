<?php
	use infrajs\load\Load;
	use infrajs\access\Access;
	use infrajs\event\Event;
	use infrajs\config\Config;
	
	$conf=Config::get('tester');
	if ($conf['updatetest']) {
		$ans = Load::loadJSON('-tester/?type=auto');
		if (!$ans || !$ans['result']) {
			error_log('TESTER: There are errors in the tests /-tester/?type=errors '.$ans['msg']);
			if (Access::debug()) die('TESTER: There are errors in the tests <a href="/-tester/?type=errors">errors</a> '.$ans['msg']);
		}
	}

?>