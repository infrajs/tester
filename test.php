<?php

use infrajs\ans\Ans;

infra_test(true);

if (isset($_GET['list'])) {
	$ans = array();
	$list = array();
	infra_pluginRun(function ($src, $name) use (&$list) {
		if (is_file($src.'.test.js')) {
			$list[] = $name;
		}
	});
	$ans['list'] = $list;

	return Ans::ret($ans);
}

$plugin = $_SERVER['QUERY_STRING'];
$code = Load::loadTEXT('*'.$plugin.'/.test.js');
echo $code;
