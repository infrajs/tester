<?php
namespace infrajs\tester;
use infrajs\path\Path;
use infrajs\once\Once;
class Tester {
	public static function runPlugins($callback)
	{
		$plugins=Once::exec('Infra::runPlugins', function () {
			$plugins=array();
			$dirs = Path::$conf;
			for ($i = 0, $il = sizeof($dirs['search']); $i < $il; ++$i) {
				$dir = Path::theme($dirs['search'][$i]);
				if(!$dir) continue;
				$list = scandir($dir);
				for ($j = 0, $jl = sizeof($list); $j < $jl; ++$j) {
					$plugin = $list[$j];
					if ($plugin{0} == '.') continue;
					if (!is_dir($dir.$plugin)) continue;
					$plugins[] = array('dir' => $dir, 'name' => $plugin);
				}
			}
			return $plugins;
		});
		
		for ($i = 0, $il = sizeof($plugins); $i < $il; ++$i) {
			$pl = $plugins[$i];
			$r = $callback($pl['dir'].$pl['name'].'/', $pl['name']);
			if (!is_null($r)) return $r;
		}
	}
}