<?php
use infrajs\access\Access;
use infrajs\path\Path;
use infrajs\load\Load;
use infrajs\ans\Ans;
use infrajs\config\Config;
use infrajs\each\Each;
use infrajs\template\Template;
use infrajs\router\Router;

if (!is_file('vendor/autoload.php')) {
	chdir('../../../');
	require_once('vendor/autoload.php');
	Router::init();
}

Config::init();

Access::test(true);

header('Infrajs-Test: Start');
$type = Ans::GET('type');
/** type=auto - Запуск всех тестов. Выполняется из других скриптов Load::loadJSON('-tester/?type=auto');
 *  Если все result true выдать один положительный ответ result: true
 *  Если найдена ошибка то добавляется переадресация на страницу с ошибками type=errors без exit
 *  type=errors - показывает только ошибки и инструкцию для справления
 *  Если ошибок нет переадресовывает на -tester/
 **/
$ans = array();

$plugin = Ans::GET('plugin');


$conf = Config::get();


$list = array();
foreach ($conf as $name=>$c) {
	if ($plugin && $plugin != $name) continue;
	if (empty($conf[$name]['tester'])) continue;
	$list[$name]=[];
	Each::exec($conf[$name]['tester'], function &($tsrc) use (&$list, $name, $c) {
		$r = null;
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
		return $r;
	});
}
$data = array('list'=>array());
$errors = array();
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
				$res = array('result' => 0, 'msg' => 'Некорректный json '.print_r($res,true));
			}
		}

		$res['src'] = $finfo['src'];
		$res['name'] = $finfo['file']; //имя тестируемого файла
		
		
		if (empty($res['result']))	$errors[] = $name.' '.$res['name'].' '.$res['msg'];
		
		if($type == 'errors') {
			if(!$res['result'] ) $data['list'][$name][] = $res;
		} else {
			$data['list'][$name][] = $res;
		}
	}
}
/*if ($type=='errors' && !sizeof($data['list'])) {
	header('Location: '.View::getPath().'-tester/');
	exit;
}*/
if ($type=='auto') {
	$ans['result'] = !$errors;
	if (!$ans['result']) $ans['msg'] = implode(', ',$errors).'.';
	return Ans::ans($ans);
}
$data['type']=$type;

$html = Template::parse('-tester/index.tpl', $data);
echo $html;
