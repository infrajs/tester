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

### Тест php
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

### Тест javascript

Все доступные тесты можно посмотреть на странице /vendor/infrajs/tester/test.html
Тесты вызваются из консоли.

- Tester() - список тестов
- Tester(name) - запуск тестов

##API javascript тесты
Для регистрации теста расширения X нужно в .infra.json указать в свойстве **testerjs** путь до js-файла теста.

Тестирование javascript разделено на задачи. Каждая задача характеризуется

1. названием
2. действие
3. проверка результата

Таким образом задача это массив из трёх элементов.

```js
var task = ['тестовая задача',fnaction, fncheck];
```

Все задачи собраны в массиве 

```js
Tester.tasks.push(task);
```

В функции **fnaction** должен быть вызов ```Tester.check();```. В функции **fncheck** должен быть вызов либо ```Tester.err('Сообщение об ошибке');``` либо ```Tester.ok()```. Для запуска тестов используется функций ```Tester.exec()```;

[Пример теста](https://github.com/infrajs/event/blob/master/tester.js)

Файл теста загружается с сервера при каждом вызове Tester(name);




