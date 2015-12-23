{root:}
<html>
<head>
	
	<!--
		<script src="/-config/js.php"></script>
	-->
	<link href="/vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
	<script src="/vendor/components/jquery/jquery.js"></script>
	<script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
	
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
	<div style="clear:both;"></div>
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
		{::someres}
	</tbody>
	</table>
</body>
</html>
{someres:}
	<tr class="bg-info"><th colspan="4"><a href="/-admin/config.php?plugin={~key}">{~key}</a></th></tr>
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

