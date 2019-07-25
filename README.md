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

yii migrate --migrationPath=@andrewdanilov/custompages/migrations

Usage
-----

In backend main config modules section add:
```php
$config = [
    ...
    'modules' => [
        ...
        'custompages' => [
            'class' => 'andrewdanilov\custompages\Module',
            'controllerMap' => [
                'category' => [
                    'class' => 'andrewdanilov\custompages\controllers\backend\CategoryController',
                    'access' => ['admin'],
                ],
                'page' => [
                    'class' => 'andrewdanilov\custompages\controllers\backend\PageController',
                    'access' => ['admin'],
                ],
            ],
            'templatesPath' => '@frontend/views/custompages', // optional - path to pages and categories template views
        ],
    ],
];
```

In frontend main config modules section add:
```php
$config = [
    ...
    'modules' => [
        ...
        'custompages' => [
            'class' => 'andrewdanilov\custompages\Module',
            'templatesPath' => '@frontend/views/custompages', // optional - path to pages and categories template views
        ],
    ],
];
```

If you use own _templatesPath_ you need to copy example files from __/vendor/andrewdanilov/yii2-custom-pages/src/views/frontend/default__ to your _templatesPath_ directory. Modify them or add as many templates as you need.

Note, that template file name for category must begins with prefix 'category.', meanwhile template file name for page must begins with prefix 'page.'