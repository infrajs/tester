# Выполнение js и php тестов

## Установка через composer

```json
{
	"require":{
		"infrajs/tester":"~1"
	}
}
```

Требуется поддержка коротких адресов [infrajs/router](https://github.com/infrajs/router) в .htaccess
```
RewriteEngine on
RewriteCond %{REQUEST_URI} ^/[-~\!]
RewriteRule ^(.*)$ vendor/infrajs/router/index.php [L,QSA]
```

## Использование

Для автоматического выполнения теста расширения X в .infra.json нужно указать в свойстве tester путь до php теста, который должен вернуть json
Тест пройден
```json
{
	"result":1
}
```
Тест не пройден
```json
{
	"result":0
}
```