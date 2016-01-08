(function(){
	test = function(plugin,step){
		var list=infra.loadJSON('-tester/test.php?list').list;
		if (!plugin) return list;
		if (!list[plugin]) return 'Тестов '+plugin+' не найдено';
		setTimeout(function(){//надо чтобы в консоли сначало вывелась строка return а потом уже тест запустился. наоборот тупо.
			test.plugin=plugin;
			test.index=0;
			test.step=step;
			test.iserr=false;
			test.tasks=[];
			infra.unload('-tester/test.php?plugin='+plugin);
			infra.require('-tester/test.php?plugin='+plugin);
		},1);
		return 'Тест '+plugin;
	}
	test.ok=function(msg){
		if(test.iserr)return;
		if(!msg)msg='ok';
		console.info(this.index+': '+msg);
		this.index++;
		this.exec();
	}
	test.err=function(msg){
		test.iserr=true;
		console.warn(this.index+':ОШИБКА: '+msg);
		return false;
	}
	test.exec=function(){
		if(typeof(test.step)!=='undefined'){

			var tasks=[];
			infra.fora(test.step,function(val){
				tasks.push(test.tasks[val]);
			});
			test.tasks=tasks;
			delete test.step;
			
		}
		setTimeout(function(){//Все процессы javascript должны закончится test.ok может запускаться в центри серии подписок
			var task=test.tasks[test.index];
			if(!task){
				console.info('Тест '+test.plugin+' выполнен!');
				alert('Тест '+test.plugin+' выполнен');
			}else{
				console.info(test.index+': '+task[0]);
				task[1]();
			}
		},1);
	}
	test.check=function(){
		var task=this.tasks[this.index];
		task[2]();
	}
	infra.test=test;
})();