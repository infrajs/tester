<?php
namespace infrajs\tester;
use infrajs\access\Access;
use infrajs\path\Path;
use infrajs\load\Load;
use infrajs\ans\Ans;
use infrajs\infra\Infra;
use infrajs\template\Template;

if (!is_file('vendor/autoload.php')) {
	chdir('../../../');
	require_once('vendor/autoload.php');
}

Infra::req();

Access::test(true);

ini_set('error_reporting',E_ALL & ~E_NOTICE & ~E_STRICT);
ini_set('display_errors', 1);
$plugin=Ans::get('plugin');

$data = array();
Tester::runPlugins(function ($dir, $name) use (&$data, $plugin) {
	if($plugin&&$plugin!=$name)return;
	$src = $dir.'tests/';
	if (!is_dir($src)) return;

	$data[$dir] = array();

	

	$list = scandir($src);
	foreach($list as $file){
		if ($file{0} == '.') continue;
		if (!is_file($src.$file)) continue;
		


		$ext = Path::getExt($file);
		if ($ext != 'php') continue;
		//echo $src.$file."\n";
		$finfo = Load::nameInfo($file);
		$text = Load::loadTEXT($src.$finfo['file'].'?type=auto');
		if (strlen($text) > 1000) {
			$res = array('title' => $name.' '.$finfo['name'], 'result' => 0, 'msg' => 'Слишком длинный текст', 'class' => 'bg-warning');
		} else {
			
			$res = Load::json_decode($text, true);
			if (!is_array($res)) {
				
				$res = array('title' => $name.' '.$finfo['name'], 'result' => 0, 'msg' => 'Некорректный json');
			}
		}
		$res['src'] = '?*'.$name.'/tests/'.$finfo['file'];
		$res['name'] = $finfo['file']; //имя тестируемого файла
		$data[$dir][] = $res;
	}
});
$html = Template::parse('*tester/tests.tpl', $data);
echo $html;
