# RzWebSys7 - CMS на основе Yii2

## Структура системы

1) app - web приложение

2) console - консольное приложение

3) common - ядро системы

4) vendor - сторонние компоненты

5) environments - настройки окружений

##Системные требования

1) PHP 5.4

2) Веб сервер Apache 2.2

3) PostgreSql 9.3

4) Composer

##Установка

Предполагается что composer находится в путях поиска вашей командной оболочки. Например, его можно разместить в **/usr/local/bin**

Apache настроен таким образом, что DOCUMENT_ROOT для виртуального хоста указывает на папку **app/web** 

Для начала неоходимо установть плагин **fxp/composer-asset-plugin:1.0.0** для composer. Для этого выполняем следующую комаду:

`composer.phar global require "fxp/composer-asset-plugin:1.0.0-beta2"`

После этого можно приступит к установки самой системы:

1) В файлах environments/dev/common/config/main-local.php и environments/prod/common/config/main-local.php
прописываем настройки соединения с базой данных для окружения разработки и продакшена соответственно.

2) Устанавливаем зависимости через composer. В корне системы выполняем команду `composer.phar install`

3) Запускаем скрипт **./init** и выбираем нужное окружение для установки

4) Запускаем **./yii install**

5) Наслаждаемся )

Административный раздел находится по адресу **/admin/**. Для входа используйте пароль пользователя **root** указанный при установке. 

## Модули входящие в состав системы

### Главный модуль

Предоставляет следующий функционал:

1.  Текстовые странички с возможностью создание иерархических структур и управлением мета - тегами. Возможность создания дружественных SEO url - адресов произвольной вложенности.
Например: **/articles/php/yii2/**

2.  Меню. Возможность создания любого количества меню, произвольной вложенности.

3.  Комментарии. Возможность добавления комментариев к любой сущности системы.

4.  Включаемые области. Текстовые включаемые области с возможностью подключения php сценариев.

5.  Группы включаемых областей. Объединение включаемых областей в группы с возможностью задания правил отображения на страницах сайта.

6.  Управление пользователями и правами доступа к сущностям. Возможность разграничить доступ к сущностям в админке для разных групп пользователей.

7.  Управление подключением шаблонов сайта в зависимости от условий (по url адресу, php выражению и т.п.)

8.  Генератор карты сайта в html и xml форматах.

9.  Форма обратной связи с отправкой сообщений на email. 

### Модуль новостей

Создание новостных и статейных разделов. Иерархический рубрикатор записей.

### Баннерный модуль

Добавление баннеров и их вывод в зависимости от баннерного места. Поддерживаются следующие форматы: jpg, gif, png, swf.

### Каталог

Каталог товаров с иерархической рубрикацией. Возможность интеграции с модулем магазина.

### Модуль магазина.

Компоненты корзины реализованы с помощью ajax и работают без перезагрузки страницы. Возможность создания вариантов доставки и оплаты, настройка статусов заказа. Содержимое заказа сохраняется в админке,
а также отправляется администратору сайта на email.

### Гео модуль

Содержит данные и компоненты для организации гео - справочника.

## Создание модулей

### Генерация каркаса нового модуля

Осуществляется с помощью системного генератора **App module generator**

### Подключение модуля к системе

Для покдлючения модуля к системе необходимо прописать идентификатор модуля в параметре **enabledModules** в файле:

```
common/config/params.php
```

### Создание таблиц сущностей новых модулей.

Осуществляется с помощью **миграций**. Миграции создаются на базе системных шаблонов.

Примеры (таблица простой сущности, таблица древовидной сущности):

```
./yii migrate/create --migrationPath=@webapp/modules/module_name/migrations --templateFile=@console/views/migrations/table.php migration_name
```

```
./yii migrate/create --migrationPath=@webapp/modules/module_name/migrations --templateFile=@console/views/migrations/table-tree.php migration_name
```

где **module_name** - имя модуля для которого создается миграция, **migration_name** - имя миграции

Пример применения миграций для конкретного модуля:

```
./yii migrate/up --applyPath=@webapp/modules/module_name/migrations
```

Без параметра **applyPath** применение миграций происходит для всех модулей сразу

### Создание моделей

Модели системы должны быть унаследованы от **\common\db\ActiveRecord** или **\common\db\TActiveRecord**
(обычные и древовидные соответственно).

Для каждой модели должен быть создан класс, унаследованный от **\common\db\MetaFields**. В нем должен быть реализован метод возвращающий конфигурацию объектов полей модели.
Поле модели - дополнительная абстракция над атрибутом модели. Класс поля должен быть унаследован от **\common\db\fields\Field**. Данная абстракция необходима для автоматической
генерации интерфейса администрирования.

Примеры кода можно найти в модуле main.

### Генерация CRUD сущностей

Осуществляется с помощью модуля Gii на основе системных шаблонов. Шаблоны **App CRUD** и **App tree CRUD**
для обычных и древовидных сущностей соответственно.
Базовый класс для контроллеров админки common\controllers\Admin.

## Рекомендации

Модули ресурсов (AssetBundle) необходимо наследовать от **\common\components\AssetBundle**

## Генерация документации

Для генерации документации воспользуйтесь следующими командами

```
vendor/bin/apidoc api app ./docs/app
```

```
vendor/bin/apidoc api common ./docs/common
```

```
vendor/bin/apidoc api console ./docs/console
```

Тестирование
------------

Пример генерации фикстур сущностей по шаблону:

```
./yii fixture/generate-all --templatePath='@tests/codeception/common/templates/fixtures' --fixtureDataPath='@tests/codeception/app/fixtures/data'
```