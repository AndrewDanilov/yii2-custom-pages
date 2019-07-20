Custom pages
===================
Make your custom pages with own templates. Pages can be separated by categories, i.e. news, articles, etc.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require andrewdanilov/yii2-custom-pages "dev-master"
```

or add

```
"andrewdanilov/yii2-custom-pages": "dev-master"
```

to the require section of your `composer.json` file.

Than run db migrations, to create needed tables:

yii migrate --migrationPath=@andrewdanilov/CustomPages/migrations

Usage
-----

In backend main config modules section add:
```php
$config = [
    ...
    'modules' => [
        ...
        'CustomPages' => [
            'class' => 'andrewdanilov\CustomPages\Module',
            'controllerNamespace' => 'andrewdanilov\CustomPages\controllers\backend',
            'templatesPath' => '@frontend/templates', // optional - path to pages and categories template views
        ],
    ],
    ...
];
```

In frontend main config modules section add:
```php
$config = [
    ...
    'modules' => [
        ...
        'CustomPages' => [
            'class' => 'andrewdanilov\CustomPages\Module',
            'controllerNamespace' => 'andrewdanilov\CustomPages\controllers\frontend',
            'templatesPath' => '@frontend/templates', // optional - path to pages and categories template views
        ],
    ],
    ...
];
```