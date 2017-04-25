{root:}
<html>
<head>
	<link rel="stylesheet" href="/-collect/?css"></link>
	<style>
		.navbar ul {
			list-style:none;
		}
		.navbar li {
			display:block;
			float:left;
			padding:5px 10px;
		}
		.collapsed {
			display:none;
		}
		h1 {
			margin-left: 10px;
			margin-right: 10px;
		}
		.table {
			margin-top:30px;
		}
		.bg-success {
			background-color:lightgreen;
		}
		.bg-info {
			background-color:lightblue;
		}
		.bg-warning {
			background-color:aquamarine;
		}
		.bg-danger {
			background-color: pink;
		}
		.bg-primary {
			background-color:gray;
		}
		.table thead {
			font-size:20px;
			
		}
		.table td,.table th {
			padding:5px 5px;
		}
	</style>
</head>
<body>
	<div class="container">
		{~length(list)?:body?:nobody}
	</div>
</body>
</html>
{nobody:}<div class="well">Ошибки не найдены. <a href=".">Тесты</a>.</div>
{body:}
	{type=:errors?:ermsgtop}
	<table cellpadding="0" cellspacing="0" class="table">
	<thead>
		<tr class="bg-primary">
			<td>
			Filename
			</td>
			<td>
			Title
			</td>
			<td>
			Result
			</td>
			<td>
			Message
			</td>
		</tr>
	</thead>
	<tbody>
		{list::someres}
	</tbody>
	</table>
	<p>Тесты расширений с js выполняются в консоли с помощью команды Tester() и Tester(name)</p>
	{type=:errors?:ermsgbot}
{ermsgtop:}<h1 class="alert alert-danger">При тестировании обнаружены критические ошибки</h1>
{ermsgbot:}
	<div class="well">
		Похоже что ошибка в плагине? 
		<br>Для исправления нужно изменять код плагина?
		<ol>
			<li>PRO: сделать форк, исправить ошибку, в проект подключить форк, а в оригинальный репозитарий отправить pull-request.<br>В комментарии к pull-request оставить конструктивный комментарий.</li>
			<li>LUCKY: Отключить для плагина тестирование в корневом .infra.json. или каждый раз игнорировать сообщение об ошибке<br>На странице плагина в issues оставить гневный комментарий.</li>
			<li>LASY: Отказаться от использования расширения, убрать о нём запись из composer.json.<br>На странице плагина в issues оставить гневный комментарий.</li>
		</ol>
<pre><code>{
	"plugin":{
		"tester":false
	}
}</code></pre>
	</div>
{someres:}
	<tr><th colspan="4"><a href="/-admin/config.php?plugin={~key}">{~key}</a></th></tr>
	{::sometest}
	{sometest:}
		<tr class="{class?class?(result?:bg-success?:bg-danger)}">
			<td>
			<a href="/{src}">{name}</a>
			</td>
			<td>
			{title}
			</td>
			<td>
			{result}
			</td>
			<td>
			{msg}
			</td>
		</tr>

