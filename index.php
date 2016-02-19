<?php
use infrajs\access\Access;
use infrajs\path\Path;
use infrajs\load\Load;
use infrajs\ans\Ans;
use infrajs\config\Config;
use infrajs\each\Each;
use infrajs\template\Template;

if (!is_file('vendor/autoload.php')) {
	chdir('../../../');
	require_once('vendor/autoload.php');
}

Config::init();
Access::test(true);

$plugin=Ans::GET('plugin');


$conf=Config::get();


$list = array();
foreach ($conf as $name=>$c) {
	if ($plugin && $plugin != $name) continue;
	if (empty($conf[$name]['tester'])) continue;
	$list[$name]=[];
	Each::exec($conf[$name]['tester'], function ($tsrc) use (&$list, $name, $c){
		$tsrc=Path::theme('-'.$name.'/'.$tsrc);
		if(!$tsrc) {
			echo '<pre>';
			print_r($c);
			throw new \Exception('Tester. Некорректно указан путь до теста.');
		}
		if(Path::isDir($tsrc)) {
			$files = scandir($tsrc);
			foreach($files as $file){
				if ($file{0} == '.') continue;
				if (!is_file($tsrc.$file)) continue;
				$list[$name][]=Path::pretty($tsrc.$file);
			}
		} else {
			$list[$name][]=Path::pretty($tsrc);
		}
	});
}
$data = array();
foreach($list as $name=>$files) {
	foreach($files as $file){
		$ext = Path::getExt($file);
		if ($ext != 'php') continue;
		$finfo = Load::srcInfo($file);
		$text = Load::loadTEXT($file.'?type=auto');
		if (strlen($text) > 1000) {
			$res = array('title' => $name.' '.$finfo['name'], 'result' => 0, 'msg' => 'Слишком длинный текст', 'class' => 'bg-warning');
		} else {
			
			$res = Load::json_decode($text, true);
			
			if (!is_array($res)) {
				$res = array('title' => $name.' '.$finfo['name'], 'result' => 0, 'msg' => 'Некорректный json');
			}
		}
		$res['src'] = $finfo['src'];
		$res['name'] = $finfo['file']; //имя тестируемого файла
		$data[$name][] = $res;
	}
}

$html = Template::parse('-tester/index.tpl', $data);
echo $html;
