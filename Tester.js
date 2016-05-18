(function(){
	window.Tester = function(plugin,step){
		var list=infra.loadJSON('-tester/test.php?list').list;
		if (!plugin) return list;
		if (!list[plugin]) return 'Тестов '+plugin+' не найдено';
		setTimeout(function(){//надо чтобы в консоли сначало вывелась строка return а потом уже тест запустился. наоборот тупо.
			Tester.plugin=plugin;
			Tester.index=0;
			Tester.step=step;
			Tester.iserr=false;
			Tester.tasks=[];
			infra.unload('-tester/test.php?plugin='+plugin);
			infra.require('-tester/test.php?plugin='+plugin);
		},1);
		return 'Тест '+plugin;
	}
	Tester.ok=function(msg){
		if(Tester.iserr)return;
		if(!msg)msg='ok';
		console.info(this.index+': '+msg);
		this.index++;
		this.exec();
	}
	Tester.err=function(msg){
		Tester.iserr=true;
		console.warn(this.index+':ОШИБКА: '+msg);
		return false;
	}
	Tester.exec=function(){
		if(typeof(Tester.step)!=='undefined'){

			var tasks=[];
			infra.fora(Tester.step,function(val){
				tasks.push(Tester.tasks[val]);
			});
			Tester.tasks=tasks;
			delete Tester.step;
			
		}
		setTimeout(function(){//Все процессы javascript должны закончится Tester.ok может запускаться в центри серии подписок
			var task=Tester.tasks[Tester.index];
			if(!task){
				console.info('Тест '+Tester.plugin+' выполнен!');
				alert('Тест '+Tester.plugin+' выполнен');
			}else{
				console.info(Tester.index+': '+task[0]);
				task[1]();
			}
		},1);
	}
	Tester.check=function(){
		var task=this.tasks[this.index];
		task[2]();
	}
	if (window.infrajs) infrajs.test = Tester;
})();