<p align="center">
    <h1 align="center">Тестовое задание на основе Yii 2 Basic Project Template</h1>
    <br>
<p>

Задание
-------------------

Разработать сервис для работы с датасетом

Исходные данные:
CSV dataset
    'category', // любимая категория клиента
    'firstname',
    'lastname',
    'email',
    'gender',
    'birthDate'

Записать полученные данные в базу данных.

Данные отобразить в виде таблицы с постраничным выводом.

Реализовать фильтры по значениям:
    категория
    пол
    дата рождения
    возраст
    ворзрастной промежуток

Реализовать экспорт данных (в csv) по заданным фильтрам.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.0

To work with large files, you need to increase max_execution_time in php.ini


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
composer create-project --prefer-dist yiisoft/yii2-app-basic basic
~~~

Now you should be able to access the application through the following URL, assuming `basic` is the directory
directly under the Web root.

~~~
http://localhost/basic/web/
~~~

You can then access the application through the following URL:

~~~
http://localhost/basic/web/
~~~

### creating tables

after setting up your database connection do migration

~~~
 yii migrate
~~~