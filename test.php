<?php
namespace infrajs\tester;
use infrajs\access\Access;
use infrajs\config\Config;
use infrajs\path\Path;
use infrajs\load\Load;
use infrajs\ans\Ans;

if (!is_file('vendor/autoload.php')) {
	chdir('../../../../');
	require_once('vendor/autoload.php');
	Config::init();
}

Access::test(true);

if (isset($_GET['list'])) {
	$ans = array();
	$list = array();

	Access::test(true);

	$plugin=Ans::get('plugin');


	$conf=Config::get();


	$list = array();
	foreach ($conf as $name=>$c) {
		if ($plugin && $plugin != $name) continue;
		if (empty($conf[$name]['testerjs'])) continue;
		$list[$name]=[];
		$tsrc = $conf[$name]['testerjs'];
		
		$tsrc=Path::theme('-'.$name.'/'.$tsrc);
		if(!$tsrc) {
			echo '<pre>';
			print_r($c);
			throw new \Exception('Tester. Некорректно указан путь до теста.');
		}
		$list[$name]=Path::pretty($tsrc);
	}
	$ans['list'] = $list;

	return Ans::ret($ans);
}
$plugin=Ans::get('plugin');
if ($plugin) {
	$conf=Config::get();
	if (empty($conf[$plugin])) return Ans::err($ans, 'Плагин не найден');
	
	if (empty($conf[$plugin]['testerjs'])) return Ans::err($ans, 'Тесты у плагина не указаны testerjs');

	$code = Load::loadTEXT('-'.$plugin.'/'.$conf[$plugin]['testerjs']);
	echo $code;
} else {
	return Ans::err($ans, 'Wrong parameters. Required list or plugin.');
}
